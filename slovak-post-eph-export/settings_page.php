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
function spephe_add_settings_page() {
    add_options_page(__('Woocommerce to EPH', 'slovak-post-eph-export'), 'EPH export', 'manage_options', 'slovak-post-eph-export', 'spephe_settings_page' );
}
add_action('admin_menu', 'spephe_add_settings_page');

// Settings page layout
function spephe_settings_page() {
    _e('<h1>Woocommerce to EPH Export</h1>', 'slovak-post-eph-export');
    ?>
    <form action="options.php" method="post">
        <?php 
        settings_fields('spephe_plugin_options');
        do_settings_sections('eph_plugin'); ?>
        <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e(__('Save', 'slovak-post-eph-export')); ?>" />
    </form>
    <?php
}

// Settings API input fields
function spephe_register_settings() {
    register_setting('spephe_plugin_options', 'spephe_plugin_options', 'eph_plugin_options_validate');
    add_settings_section('eph_settings', __('Consignor information', 'slovak-post-eph-export'), 'spephe_plugin_section_text', 'eph_plugin');

    add_settings_field('spephe_setting_name', __('Name', 'slovak-post-eph-export'), 'spephe_setting_name', 'eph_plugin', 'eph_settings');
    add_settings_field('spephe_setting_surname', __('Surname', 'slovak-post-eph-export'), 'spephe_setting_surname', 'eph_plugin', 'eph_settings');
    add_settings_field('spephe_setting_company', __('Company', 'slovak-post-eph-export'), 'spephe_setting_company', 'eph_plugin', 'eph_settings');
    add_settings_field('spephe_setting_street', __('Street and conscription number', 'slovak-post-eph-export'), 'spephe_setting_street', 'eph_plugin', 'eph_settings');
    add_settings_field('spephe_setting_city', __('City', 'slovak-post-eph-export'), 'spephe_setting_city', 'eph_plugin', 'eph_settings');
    add_settings_field('spephe_setting_postcode', __('Postcode', 'slovak-post-eph-export'), 'spephe_setting_postcode', 'eph_plugin', 'eph_settings');
    add_settings_field('spephe_setting_mobile', __('Mobile', 'slovak-post-eph-export'), 'spephe_setting_mobile', 'eph_plugin', 'eph_settings');
    add_settings_field('spephe_setting_email', __('Email', 'slovak-post-eph-export'), 'spephe_setting_email', 'eph_plugin', 'eph_settings');
    add_settings_field('spephe_setting_iban', __('IBAN', 'slovak-post-eph-export'), 'spephe_setting_iban', 'eph_plugin', 'eph_settings');
}
add_action('admin_init', 'spephe_register_settings');


// -------------------------------
// Setting fields created in the settings page

function spephe_plugin_section_text() {
    _e('<p>Fill out all the fields important for the EPH</p>', 'slovak-post-eph-export');
}

function spephe_setting_name() {
    $options = get_option('spephe_plugin_options');
    echo "<input id='spephe_setting_name' name='spephe_plugin_options[name]' type='text' value='" . $options['name'] . "'/>";
}

function spephe_setting_surname() {
    $options = get_option('spephe_plugin_options');
    echo "<input id='spephe_setting_surname' name='spephe_plugin_options[surname]' type='text' value='" . $options['surname'] . "'/>";
}

function spephe_setting_company() {
    $options = get_option('spephe_plugin_options');
    echo "<input id='spephe_setting_company' name='spephe_plugin_options[company]' type='text' value='" . $options['company'] . "'/>";
}

function spephe_setting_street() {
    $options = get_option('spephe_plugin_options');
    echo "<input id='spephe_setting_street' name='spephe_plugin_options[street]' type='text' value='" . $options['street'] . "'/>";
}

function spephe_setting_city() {
    $options = get_option('spephe_plugin_options');
    echo "<input id='spephe_setting_city' name='spephe_plugin_options[city]' type='text' value='" . $options['city'] . "'/>";
}

function spephe_setting_postcode() {
    $options = get_option('spephe_plugin_options');
    echo "<input id='spephe_setting_postcode' name='spephe_plugin_options[postcode]' type='text' value='" . $options['postcode'] . "'/>";
}

function spephe_setting_mobile() {
    $options = get_option('spephe_plugin_options');
    echo "<input id='spephe_setting_mobile' name='spephe_plugin_options[mobile]' type='text' value='" . $options['mobile'] . "'/>";
}

function spephe_setting_email() {
    $options = get_option('spephe_plugin_options');
    echo "<input id='spephe_setting_email' name='spephe_plugin_options[email]' type='text' value='" . $options['email'] . "'/>";
}

function spephe_setting_iban() {
    $options = get_option('spephe_plugin_options');
    echo "<input id='spephe_setting_iban' name='spephe_plugin_options[iban]' type='text' value='" . $options['iban'] . "'/>";
}
