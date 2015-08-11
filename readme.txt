=== DoctorLogic Components ===
Contributors: DoctorLogic 
Tags: doctors, medical, websites, reviews, galleries
Requires at least: 3.8
Tested up to: 4.2.4
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin creates the ability to publish Review & Before/After Galleries to 
WordPress websites powered by the DoctorLogic.com API.

== Description ==

DoctorLogic is a Medical Internet Software Development Company with many 
different Software as a Service (SaaS) products to help medical professionals 
market themselves on the internet.   
 
For more information, visit https://DoctorLogic.com.
 
This plugin will function only with an active account with DoctorLogic and 
access to its services.
 
DoctorLogic offers packages of services which may include different components.
This Plugin has access to all components, but will only work if the site has 
a license to use them.
 
All DoctorLogic components are powered by the DoctorLogic API and back-end tools.



== Installation ==

This section describes how to install the plugin and get it working.

In WordPress Admin:
1. Click Plugins
2. Click Add New
3. Search for "DoctorLogic Components"
4. Click Install Now

After Installing:
1. Activate the plugin through the 'Plugins' menu in WordPress
2. Click the Settings link from the Plugins page on the DoctorLogic Component plugin.
3. Complete configuration steps using the on-screen instructions.

== Frequently Asked Questions ==

= How do I obtain a DoctorLogic Site Key? =

This value was supplied to your customer on page 1 of the DoctorLogic Software 
Developer Kit (SDK).  Or contact DoctorLogic from the email address or phone number 
on the DoctorLogic settings screen in WordPress.

= Why do no Reviews or Galleries show up when I install the short code? =

The most likely cause is that your customer has not published in reviews or Galleries
yet. Contact DoctorLogic from the email address or phone number on the DoctorLogic 
settings screen in WordPress if you need help.

Some hosting environments block the ability to call web-services.  Make sure php.ini
has these settings:

allow_url_fopen = on
allow_url_include = On


== Screenshots ==

1. The DoctorLogic configuration screen in WordPress Admin.
2. This is how the [DoctorLogicReview] short code may look on a full-width page.

== Changelog ==
= 1.0 = 
* Initial release
= 1.1 = 
* Improved markup & CSS to work in more different WordPress Themes
= 1.2 = 
* Added modal popups to Review list.  Improved style sheet handling.
= 2.0 = 
* Added Gallery component 
= 2.1 = 
* Code tweaks for WordPress 4.3 changes
= 2.1.1 =
* Improved diagnostics, convenient link to pages containing main plugins


== Upgrade Notice ==
= 1.0 = 
* Initial Release
= 1.1 = 
* Improved markup & CSS to work in more different WordPress Themes
= 1.2 = 
* Added modal popups to Review list.  Improved style sheet handling.
= 2.0 = 
* Added Gallery component 
= 2.1 = 
* Code tweaks for WordPress 4.3 changes
= 2.1.1 =
* Improved diagnostics, convenient link to pages containing main plugins
