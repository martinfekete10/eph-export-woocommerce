<?php

/**
 * @package   Woo to EPH export
 * @author    Martin Fekete
 * @license   GPLv2 or later
 * @link      https://github.com/martinfekete10/eph-export-woocommerce
 * @copyright 2021 Martin Fekete
 * 
 * @wordpress-plugin
 * Plugin Name: Slovak Post EPH Export
 * Plugin URI: https://github.com/martinfekete10/eph-export-woocommerce
 * Description: Export customer details into Slovak Post online service (EPH) XML format.
 * Version: 1.2.0
 * Author: Martin Fekete
 * Author URI: https://github.com/martinfekete10
 * License: GPLv2 or later
 * Text Domain: slovak-post-eph-export
 * Domain Path: /languages/
 */

include 'xml_generator.php';
include 'settings_page.php';

// -------------------------
// spephe_ == (s)Slovak (p)Post (eph)EPH (e)Export
// Prefix used in order to prevent conflicts with other functions


// --------------------------
// Load language files
function spephe_plugin_init() {
    load_plugin_textdomain('slovak-post-eph-export', false, dirname(plugin_basename(__FILE__)).'/languages/');
}
add_action('plugins_loaded', 'spephe_plugin_init');


// --------------------------
// File for storing exported data
$file = WP_PLUGIN_DIR . "/slovak-post-eph-export/exports/eph-export.xml";

// Adding to admin order list bulk dropdown a custom action 'export_eph'
add_filter('bulk_actions-edit-shop_order', 'spephe_export_action', 20, 1);
function spephe_export_action($actions) {
    $actions['registered_letter'] = __('EPH export - Registered letter', 'slovak-post-eph-export');
    $actions['package'] = __('EPH export - Package', 'slovak-post-eph-export');
    $actions['express_courier'] = __('EPH export - Express courier', 'slovak-post-eph-export');
    return $actions;
}

// Generate XML based on seleciton from dropdown
// Either Express courier, Registered letter or Package services are supported
add_filter('handle_bulk_actions-edit-shop_order', 'spephe_handle_export_action', 30, 3);
function spephe_handle_export_action($redirect_to, $service, $post_ids) {
    global $directory, $file;
    
    // If not desired service
    if ($service !== 'registered_letter'
        && $service !== 'package'
        && $service !== 'express_courier') {
        return $redirect_to;
    }

    // Open file for writing the output
    $xml_file = fopen($file, "w");
    $processed_ids = array();

    // Generate EPH header
    spephe_generate_info_eph(count($post_ids), $service);

    // Iterate through all the orders selected
    foreach ($post_ids as $post_id) {
        $order = wc_get_order($post_id);

        // Write to file
        spephe_generate_zasielka($order);
        $processed_ids[] = $post_id;
    }

    // Save XML variable to $xml_file
    spephe_save_xml($xml_file);
    fclose($xml_file);

    return $redirect_to = add_query_arg(array(
                'export_eph' => '1',
                'processed_count' => count($processed_ids),
                'processed_ids' => implode(',', $processed_ids),
            ), $redirect_to);
}

// The results notice from bulk action on orders
add_action('admin_notices', 'spephe_export_admin_notice');
function spephe_export_admin_notice() {
    if (empty( $_REQUEST['export_eph'])) return;
    spephe_download_xml();
}

// Download the file
function spephe_download_xml() {
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

add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'spephe_add_plugin_page_settings_link');
function spephe_add_plugin_page_settings_link( $links ) {
    $links[] = '<a href="' . admin_url('options-general.php?page=slovak-post-eph-export') . '">' . __('Settings', 'slovak-post-eph-export') . '</a>';
    return $links;
}

// --------------------------
// Activation notice

register_activation_hook(__FILE__, 'spephe_export_activation_hook');
function spephe_export_activation_hook() {
    set_transient('eph-admin-notice-example', true, 5);
}

// Add admin notice
add_action('admin_notices', 'spephe_admin_notice');

// Notice activation
function spephe_admin_notice(){

    if(get_transient('eph-admin-notice-example')){
        echo '<div class="updated notice is-dismissible">';
        printf(__('<p><strong>Configuration is needed</strong>. Go to <a href=\'%s\'>Settings -> EPH export</a> to configure.</p>', 'slovak-post-eph-export'), admin_url('options-general.php?page=slovak-post-eph-export'));
        echo '</div>';
        delete_transient('eph-admin-notice-example');
    }
}
