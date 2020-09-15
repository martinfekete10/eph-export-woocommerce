=== Slovak Post EPH Export ===
Contributors: (martinfekete)
Donate link: https://cutt.ly/eph-export
Tags: WooCommerce, EPH, Slovenska Posta
Requires at least: 4.5.0
Tested up to: 5.4.2
Stable tag: 1.0.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Wordpress plugin for exporting Woocommerce orders accepted by Slovak Post online service.

== Description ==
Wordpress plugin for exporting orders into XML file accepted by EPH (Slovak Post online system).

== Installation ==
Can by done in 2 ways:

a) Uploading in WordPress Dashboard
1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select 'eph-export.zip' from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

b) Using FTP
1. Download 'eph-export.zip'
2. Extract the 'eph-export' directory to your computer
3. Upload the 'eph-export' directory to the '/wp-content/plugins/' directory
4. Activate the plugin in the Plugin dashboard

== Frequently Asked Questions ==

= How do I use the plugin? =

You simply select the orders you want to export and then choose "Export to EPH" in the bulk selection menu.

= How do I add my adress to the XML? =

Go to Settings -> EPH export and fill out all your information.

== Screenshots ==

1. Settings where you must fill out all your info
2. Usage example

== Changelog ==

= 1.1.0 =
* Added weight of the order to the XML file which enables online payment in the EPH system
* Woocommerce order ID is now used a variable symbol in the EPH COD payment

= 1.0.0 =
* Startup version

== Upgrade Notice == 

= 1.1.0 =
Added weight of the order to the XML file which enables online payment in the EPH system. Woocommerce order ID is now used a variable symbol in the EPH COD payment.

= 1.0.0 =
Startup version