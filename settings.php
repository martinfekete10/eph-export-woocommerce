<?php

/**
 * User setting page.
 * 
 * @package eph_plugin
 */


function eph_add_settings_page() {
    add_options_page('Woocommerce do EPH', 'EPH export', 'manage_options', ‘eph-plugin’, 'eph_plugin_settings_page' );
}
add_action('admin_menu', 'eph_add_settings_page');


function eph_plugin_settings_page() {
    ?>
    <h1>Woocommerce do EPH - nastavenia</h1>
    <form action="options.php" method="post">
        <?php 
        settings_fields('eph_plugin_options');
        do_settings_sections('eph_plugin'); ?>
        <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
    </form>
    <?php
}


function eph_register_settings() {
    register_setting('eph_plugin_options', 'eph_plugin_options', 'eph_plugin_options_validate');
    add_settings_section('eph_settings', 'Vaše údaje', 'eph_plugin_section_text', 'eph_plugin');

    add_settings_field('eph_plugin_setting_name', 'Meno', 'eph_plugin_setting_name', 'eph_plugin', 'eph_settings');
    add_settings_field('eph_plugin_setting_surname', 'Priezvisko', 'eph_plugin_setting_surname', 'eph_plugin', 'eph_settings');
    add_settings_field('eph_plugin_setting_company', 'Firma', 'eph_plugin_setting_company', 'eph_plugin', 'eph_settings');
    add_settings_field('eph_plugin_setting_street', 'Ulica a popisné číslo', 'eph_plugin_setting_street', 'eph_plugin', 'eph_settings');
    add_settings_field('eph_plugin_setting_city', 'Mesto', 'eph_plugin_setting_city', 'eph_plugin', 'eph_settings');
    add_settings_field('eph_plugin_setting_postcode', 'PSČ', 'eph_plugin_setting_postcode', 'eph_plugin', 'eph_settings');
    add_settings_field('eph_plugin_setting_mobile', 'Telefónne číslo', 'eph_plugin_setting_mobile', 'eph_plugin', 'eph_settings');
    add_settings_field('eph_plugin_setting_email', 'Email', 'eph_plugin_setting_email', 'eph_plugin', 'eph_settings');
    add_settings_field('eph_plugin_setting_iban', 'IBAN', 'eph_plugin_setting_iban', 'eph_plugin', 'eph_settings');
}
add_action('admin_init', 'eph_register_settings');


function eph_plugin_section_text() {
    echo '<p>Tu vyplňte všetky vaše údaje dôležité pre EPH</p>';
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
