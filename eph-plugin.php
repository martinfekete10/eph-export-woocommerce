<?php

/**
 * @package eph-plugin
 */

/*
Plugin Name: EPH Export
Plugin URI: http://FakeAssURI.com
Description: Export customer details into Slovak postal service XML format.
Version: 1.0.0
Author: Martin Fekete
Author URI: https://github.com/martinfekete10
License: GPLv2 or later
Text Domain: eph-plugin
*/

// File for storing exported data
$file = "eph-export.txt";

// Adding to admin order list bulk dropdown a custom action 'export_eph'
add_filter('bulk_actions-edit-shop_order', 'eph_export_action', 20, 1);
function eph_export_action( $actions ) {
    $actions['export_eph'] = __( 'Export to EPH', 'woocommerce' );
    return $actions;
}

// Make the action from selected orders
add_filter('handle_bulk_actions-edit-shop_order', 'handle_export_eph_action', 30, 3);
function handle_export_eph_action($redirect_to, $action, $post_ids) {
    
    // Exit
    if ( $action !== 'export_eph' ) return $redirect_to;

    global $directory, $file;

    // Open file for writing the output
    $myfile = fopen($file, "w");
    
    $processed_ids = array();

    // Iterate through all the orders selected
    foreach ($post_ids as $post_id) {
        $order = wc_get_order( $post_id );
        $order_data = $order->get_data();

        // Write to file
        fwrite($myfile, $order->get_billing_city().'/n');
        
        $processed_ids[] = $post_id;
    }

    fclose($myfile);

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

?>