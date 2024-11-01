=== Plugin Name ===
Contributors: jakeob
Donate link: https://www.paypal.me/jakeobcz
Tags: FTP lister, directory lister, file lister, show files from ftp
Requires at least: 5.1
Tested up to: 5.7
Requires PHP: 7.2
Stable tag: 1.4.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Choose folder from FTP and display all its files and subfolders. Easy integration.

== Description ==

PLUGIN IS NO LONGER BEING DEVELOPED. IF YOU CAN, USE ANOTHER ACTIVELY MAINTAINED SOLUTION. I AM NO LONGER PROVIDING A SUPPORT FOR THE PLUGIN.

Plugin reads all files in folder and subfoldres and displays it on the website as clickable tree.

Plugin register path to folder within wordpress upload folder, therefore add only relative path to the folder you want to list.
When the path to folder is properly set, just copy the shortcode and past it anywhere to the page where you want to show the listing.

Please keep in mind that this plugin is not suitable for listing thousands of items since it loads all the information at once.

There are two layout available: horizontal (vertical on mobile) and vertical.

You can define path and layout within the shortcode to use the plugin in serveral places and list different folders: [simple-ftp-directory-lister layout="horizontal" path="/path-to-folder"]. More information in settings of the plugin.

== Installation ==

1. Upload simple-ftp-directory-lister folder` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to settings -> Simple FTP Directory Lister Settings
4. Set path to your folder within the wordpress upload directory and hit save
5. Choose layout
5. Copy the shortcode
6. Paste the shortcode to the page where you want to display listing of subfolders and files of the folder you defined in step 4.
7. Save the page with the shortcode and thats it. Listing will now display on that page.

== Frequently Asked Questions ==

= Can I choose any folder at FTP? =

No. For security reasons you may only choose folders within wordpress upload directory.

= Can I list multiple folders? =

Yes, you can define path within the shortcode to use the plugin in serveral places and listing different folders. See settings page of SFDL in your Wordpress.

= Can I define horizontal/vertical style within shortcode? =

Yes, together with path defined in shortcode you can also define its style. For more information see settings page of SFDL in your Wordpress.

= Can I define my own icons / overwrite default icons / add missing icons for file extensions? =

Yes, icons are now loaded as background in css, therefore its easy to overwrite them in your theme style file.
Also every file div wrapper has a class named as extension of the file. You can then target this class to change/add icons for the extension (example: .download-icon.pfd).

= Can disable/enable loading animation? =

Yes, you can disable/enable the animation in settings of the plugin. You can also disable it individually within shortcode by using loading_animation="disable" or loading_animation="enable"

= Can set different text for empty folders based on page language? =

Yes, you can define the text in CSS. You have to get the language from the page somewhere. For example if your theme writes language class to body tag the css will be: body.en_GB .sdfl-no-files-available-wrapper::after {content: "No files available at the moment.";}

= Can I completely change the styles your plugin is using? =

Yes, you can. To use your styles you need to create a folder called simple-ftp-directory-lister within your theme directory with a subfolder called css. From now on all the styles of the plugin will be loaded from this folder. Be aware that you should be using child theme in order to keep any theme changes after you update the theme. There are 5 different css files that controls styles. You need to copy these files from the plugin folder to the css folder you just created. Now change anything you want in these files, the plugin will be loading these and ignore its own css files. Example where you need to create the folder: /wp-content/themes/themeyouareusing/simple-ftp-directory-lister/css/"

== Screenshots ==
screenshot-1.png
screenshot-2.png
screenshot-3.png
screenshot-4.png

== Changelog ==
= 1.4.6, 1.4.7 =
Minor improvements
= 1.4.5 =
Added possibility to hide file extensions.
= 1.4.4 =
Added possibility to overtake styles.
= 1.4.3 =
Updated example of upload directory.
= 1.4.2 =
* Added icon and text if main folder is empty. (Usable mostly when calling script from ajax calls)
= 1.4.1 =
* Added loading animation.
= 1.4 =
* Adding advanced options - you can now set mobile layout breakpoint and add custom classes to main wrapper.
* Improved styles and calculations.
= 1.3 =
* Completely reworked design
* Ability to choose between vertical or horizontal style in option menu
* Ability to choose between vertical or horizontal style in shortcode (overrides menu option for the shortcode listing)
* Reworked icon handling - you can now define your own icons in CSS styles of your theme
* Improved PHP listing, completely reworked jQuery functions. Width of elements (horizontal layout) is now dynamically calculated, height of listing is now dynamically calculated.
= 1.2 =
* Small change in css and ensuring support for calling main function with ajax. You can now create own interactive listings with ajax.
= 1.1 =
* Adding support for defining path directly in shortcode, thus allowing multiple different listings across website
= 1.0 =
* Release
