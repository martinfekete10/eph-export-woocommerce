<?php

/**
 * @package   Woo to EPH export
 * @author    Martin Fekete
 * @license   GPLv2 or later
 * @link      https://github.com/martinfekete10/eph-export-woocommerce
 * @copyright 2020 Martin Fekete
 *
 * ----------------------------------------------
 * User setting page, located in Settings->EPH export
 * Wordpress Settings API used 
 * 
 */

// -------------------------------

// Created options page, added element into the Settings menu
function eph_add_settings_page() {
    add_options_page(__('Woocommerce to EPH', 'eph-export'), 'EPH export', 'manage_options', 'eph-export', 'eph_plugin_settings_page' );
}
add_action('admin_menu', 'eph_add_settings_page');

// Settings page layout
function eph_plugin_settings_page() {
    _e('<h1>Woocommerce to EPH Export</h1>', 'eph-export');
    ?>
    <form action="options.php" method="post">
        <?php 
        settings_fields('eph_plugin_options');
        do_settings_sections('eph_plugin'); ?>
        <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e(__('Save', 'eph-export')); ?>" />
    </form>
    <?php
}

// Settings API input fields
function eph_register_settings() {
    register_setting('eph_plugin_options', 'eph_plugin_options', 'eph_plugin_options_validate');
    add_settings_section('eph_settings', __('Consignor information', 'eph-export'), 'eph_plugin_section_text', 'eph_plugin');

    add_settings_field('eph_plugin_setting_name', __('Name', 'eph-export'), 'eph_plugin_setting_name', 'eph_plugin', 'eph_settings');
    add_settings_field('eph_plugin_setting_surname', __('Surname', 'eph-export'), 'eph_plugin_setting_surname', 'eph_plugin', 'eph_settings');
    add_settings_field('eph_plugin_setting_company', __('Company', 'eph-export'), 'eph_plugin_setting_company', 'eph_plugin', 'eph_settings');
    add_settings_field('eph_plugin_setting_street', __('Street and conscription number', 'eph-export'), 'eph_plugin_setting_street', 'eph_plugin', 'eph_settings');
    add_settings_field('eph_plugin_setting_city', __('City', 'eph-export'), 'eph_plugin_setting_city', 'eph_plugin', 'eph_settings');
    add_settings_field('eph_plugin_setting_postcode', __('Postcode', 'eph-export'), 'eph_plugin_setting_postcode', 'eph_plugin', 'eph_settings');
    add_settings_field('eph_plugin_setting_mobile', __('Mobile', 'eph-export'), 'eph_plugin_setting_mobile', 'eph_plugin', 'eph_settings');
    add_settings_field('eph_plugin_setting_email', __('Email', 'eph-export'), 'eph_plugin_setting_email', 'eph_plugin', 'eph_settings');
    add_settings_field('eph_plugin_setting_iban', __('IBAN', 'eph-export'), 'eph_plugin_setting_iban', 'eph_plugin', 'eph_settings');
}
add_action('admin_init', 'eph_register_settings');


// -------------------------------
// Setting fields created in the settings page

function eph_plugin_section_text() {
    _e('<p>Fill out all the fields important for the EPH</p>', 'eph-export');
}

function eph_plugin_setting_name() {
    $options = get_option('eph_plugin_options');
    echo "<input id='eph_plugin_setting_name' name='eph_plugin_options[name]' type='text' value='" . $options['name'] . "'/>";
}

function eph_plugin_setting_surname() {
    $options = get_option('eph_plugin_options');
    echo "<input id='eph_plugin_setting_surname' name='eph_plugin_options[surname]' type='text' value='" . $options['surname'] . "'/>";
}

function eph_plugin_setting_company() {
    $options = get_option('eph_plugin_options');
    echo "<input id='eph_plugin_setting_company' name='eph_plugin_options[company]' type='text' value='" . $options['company'] . "'/>";
}

function eph_plugin_setting_street() {
    $options = get_option('eph_plugin_options');
    echo "<input id='eph_plugin_setting_street' name='eph_plugin_options[street]' type='text' value='" . $options['street'] . "'/>";
}

function eph_plugin_setting_city() {
    $options = get_option('eph_plugin_options');
    echo "<input id='eph_plugin_setting_city' name='eph_plugin_options[city]' type='text' value='" . $options['city'] . "'/>";
}

function eph_plugin_setting_postcode() {
    $options = get_option('eph_plugin_options');
    echo "<input id='eph_plugin_setting_postcode' name='eph_plugin_options[postcode]' type='text' value='" . $options['postcode'] . "'/>";
}

function eph_plugin_setting_mobile() {
    $options = get_option('eph_plugin_options');
    echo "<input id='eph_plugin_setting_mobile' name='eph_plugin_options[mobile]' type='text' value='" . $options['mobile'] . "'/>";
}

function eph_plugin_setting_email() {
    $options = get_option('eph_plugin_options');
    echo "<input id='eph_plugin_setting_email' name='eph_plugin_options[email]' type='text' value='" . $options['email'] . "'/>";
}


function eph_plugin_setting_iban() {
    $options = get_option('eph_plugin_options');
    echo "<input id='eph_plugin_setting_iban' name='eph_plugin_options[iban]' type='text' value='" . $options['iban'] . "'/>";
}
