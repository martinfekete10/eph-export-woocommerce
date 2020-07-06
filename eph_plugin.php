<?php

/**
 * @package   Woo to EPH export
 * @author    Martin Fekete
 * @license   GPLv2 or later
 * @link      https://github.com/martinfekete10/eph-export-woocommerce
 * @copyright 2020 Martin Fekete
 * 
 * @wordpress-plugin
 * Plugin Name: Woocommerce to EPH Export
 * Plugin URI: https://github.com/martinfekete10/eph-export-woocommerce
 * Description: Export customer details into Slovak Post online service (EPH) XML format.
 * Version: 1.0.0
 * Author: Martin Fekete
 * Author URI: https://github.com/martinfekete10
 * License: GPLv2 or later
 * Text Domain: eph-export
 * Domain Path: /languages/
*/

include 'xml_generator.php';
include 'settings_page.php';

// --------------------------
// Load language files
function plugin_init() {
    load_plugin_textdomain('eph-export', false, dirname(plugin_basename(__FILE__)).'/languages/');
}
add_action('plugins_loaded', 'plugin_init');


// --------------------------
// File for storing exported data
$file = WP_PLUGIN_DIR . "/eph-export/exports/eph-export.xml";

// Adding to admin order list bulk dropdown a custom action 'export_eph'
add_filter('bulk_actions-edit-shop_order', 'eph_export_action', 20, 1);
function eph_export_action( $actions ) {
    $actions['export_eph'] = __('Export to EPH', 'eph-export');
    return $actions;
}

// Make the action from selected orders
add_filter('handle_bulk_actions-edit-shop_order', 'handle_export_eph_action', 30, 3);
function handle_export_eph_action($redirect_to, $action, $post_ids) {
    
    // Exit
    if ($action !== 'export_eph') return $redirect_to;

    global $directory, $file;

    // Open file for writing the output
    $xml_file = fopen($file, "w");
    
    $processed_ids = array();

    // Generate EPH header
    generate_infoEPH(count($post_ids));

    // Iterate through all the orders selected
    foreach ($post_ids as $post_id) {
        $order = wc_get_order($post_id);
        //$order_data = $order->get_data();

        // Write to file
        generate_zasielka($order);
        
        $processed_ids[] = $post_id;
    }

    // Save XML variable to $xml_file
    save_xml($xml_file);
    fclose($xml_file);

    return $redirect_to = add_query_arg(array(
                'export_eph' => '1',
                'processed_count' => count($processed_ids),
                'processed_ids' => implode(',', $processed_ids),
            ), $redirect_to);
}

// The results notice from bulk action on orders
add_action('admin_notices', 'eph_export_admin_notice');
function eph_export_admin_notice() {
    
    // Exit
    if (empty( $_REQUEST['export_eph'])) return;

    // Download
    download();
}

// Download the file
function download() {
    
    global $file;

    header('Content-Description: File Transfer');
    header("Content-Type: text/plain");
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Length: ' . filesize($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    
    ob_clean();
    flush();
    readfile($file);
    
    exit;
}

// --------------------------
// Setting page in the plugin admin screen

add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'eph_add_plugin_page_settings_link');
function eph_add_plugin_page_settings_link( $links ) {
    $links[] = '<a href="' . admin_url( 'options-general.php?page=eph-export' ) . '">' . __('Settings', 'eph-export') . '</a>';
    return $links;
}

// --------------------------
// Activation notice

register_activation_hook(__FILE__, 'eph_export_activation_hook');
function eph_export_activation_hook() {
    set_transient('eph-admin-notice-example', true, 5);
}

// Add admin notice
add_action('admin_notices', 'eph_admin_notice');

// Notice activation
function eph_admin_notice(){

    $html = "<p><strong>Configuration is needed</strong>. Go to <a href=" . admin_url('options-general.php?page=eph-export') . ">Settings -> EPH export</a> to confugire.</p>";

    if(get_transient('eph-admin-notice-example')){
        echo '<div class="updated notice is-dismissible">';
        printf(__('<p><strong>Configuration is needed</strong>. Go to <a href="%s">Settings -> EPH export</a> to confugire.</p>', 'eph-export'), admin_url('options-general.php?page=eph-export'));
        echo '</div>';
        delete_transient('eph-admin-notice-example');
    }
}
