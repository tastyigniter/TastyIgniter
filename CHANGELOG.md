### v2.1.0

Release Date: May 2016

#### Added
* Customers model: new method `saveAddress()` to update/save/delete customer addresses
* URL Helper: new method `assets_url()` to return full URL (including segments) of the assets directory
* Location admin option to choose different delivery and collection hours or use same as opening hours, and  option to choose future days in advance
* Migration: added column `type` to `working_hours` table and update `type` column value to `opening` on existing rows
* Locations can now have opening, delivery and collection hours past midnight
* Location library methods `hasFutureOrders()` to check if location future order option is enabled or disabled in admin settings
* Location library methods `futureOrderDays()` to get the future days in advance location option value
* Location library methods `checkOrderType()` to check if delivery or collection order type is available open, and accepting orders
* Location library methods `checkOrderTime()` to check if order time is within delivery or collection open and close hour
* Improve `local_module` and `cart_module` to display and check opening, delivery and collection hours and status
* Affix categories sidebar (module) to page
* Migration: added column `order_date` to `orders` table to allow future orders
* Customer now redirects back to previous page after login when previous page is either checkout or reservation page
* Composer support, to enabled create a file `vendor/autoload.php` within the system folder and
* Location library method `deliveryCondition()` to return an array of the current location delivery conditions to be used within controller
* Capability to create a child theme and override any parent theme file or extension view file from within the child theme
* TI_url_helper theme_url() function to return the site theme URL
* Total cash payments to admin dashboard statistics and payment column to admin order list view
* New Stripe payment method to accept credit card payments through Stripe
* Mealtimes (breakfast, lunch, dinner, ...) to set what time of the day a menu item can be ordered by the customer
* Migration: add column `priority` to Menus table and column `default_value_id` to Menu Option table to sort the storefront menu list and choose an option value to be selected default in storefront
* Migration: new table `mealtimes` to hold `start_time` and `end_time` for mealtimes
* Improved Cart: new extension type `cart_total` to allow cart totals extension and priority from within cart module
* Event Hook: developers can add new cart total using `cart_module_before_cart_totals` hook point and 
* Cart library methods `add_total()`, `remove_total()` and `get_total()`
* Extensions_model method `getModule($module)` to return specified installed module
* Theme config item under partial_area `module_html` to customise each module html template displayed in storefront
* Extension config item `layout_ready` to tell system an extension can be configured as layout module and displayed in storefront

#### Changed
* Major UI improvements to local, cart and categories modules, local, locations and checkout pages
* Location library: MUST call `initialize()` method or `setLocation()` to load location library
* Improved `orderTimeRange()` method in Location Library to get future order dates and hours
* Removed `local_module` admin edit language text feature. Language text should be changed from language file instead.
* Location library methods `getOpeningType()`, `openingStatus()`, `openingHours()`, `checkDeliveryTime()` to `getWorkingType()`, `workingStatus()`, `workingHours()`, `checkOrderTime()`
* Improved Checkout future order (order for later) feature with option to select date and time for later delivery or collection
* Improved Admin Location settings whether customer must enter address to order or not
* Improved Cart Module alerts to display top screen on mobile devices
* Show order date instead of date added on admin & customer account order and checkout pages and display menu option on new line
* Improved get_remote_data method
* Pass entire module array into extension module index method instead of passing only the data array key value
* Improved banner module with admin options to allow multiple banners on different layouts
* Added option to enter billing address during checkout when authorize.net is selected as payment method
* Load Template library right after permalink library so the right modules can be loaded based on uri
* Improved messages view folders and delete functionality ( you might find some archived messages showing under 'all' folder but not in 'archive', fix by moving to archive again)
* Filter lost (blank status) orders from order list in admin by default
* Updated CI core files to version 3.0.6, TI system files and modular HMVC files
* Improved locations delivery area with conditions such as free delivery if total over certain amount
* Location library method `deliveryCharge()` and `minimumOrder()` now expect cart total as parameter
* Customer login function to login admin to any customer account without knowing the customer's password
* Replaced `_find_view()` with `_find_view_path()` in Template Library, use `_load_view()` instead of `_find_view()`
* Improved Template library to search for files `views, css, js` both in the active and parent theme `if the active theme is a child theme`
* Improved TI_Loader library `view()` method to search current (child and parent) theme folder for view file before modules, this allows extension view files to be overridden from within a child theme folder
* Improved Cart: moved cart validate methods from controller to new `Cart_module_lib` library
* Removed admin settings option Tax Title, so tax title can be set from within Cart Module
* Improved send message to all newsletter subscriber feature to include emails submitted via newsletter extension
* Improved Template Library to read new config item `layout_ready` and customise module based on `module_html` value in theme_config
* Improved Admin Layout edit page to drag and drop layout modules into partial areas, add title and position module to page

#### Fixed
* Issue with payment and confirm button changing incorrectly on checkout page
* Issue with lost orders, this way a new order is not created after payment fails
* Issue with displaying form validation error for payment methods
* Issue where previous successfully placed order is overwritten when placing new order as guest
* Issue where class selector passed into get_partial method is ignored
* Issue with storefront menu list and sidebar modules widths
* Missing category module admin fixed position settings
* Default language from being deleted accidentally
* Issue where core modules are not displaying on fresh install
* Storefront multi-level categories list to have more than one level
* Issue with clearing images and removed required validation rule to make field optional
* Issue to allow duplicate permalink slug

### v2.0.0 (stable)

Release Date: January 2016 (postponed: 15 March 2016)

#### Added
* Setup now generates a random alpha-numeric 9 length string for database table prefixes
* Admin option to select a page for checkout and registration terms and condition.
* Missing extension meta title item and extension permission rules to config
* Version number to extension metadata and themes config for version control and automatic update feature
* Featured Menus module to display selected featured menu on homepage or anywhere on the storefront
* New admin setting option to set site date/time format
* Location image gallery: option to add multiple images to be displayed on local storefront
* New mail templates to send emails to admin on new customer registration and admin password reset
* Second parameter to both `subject()` and `message()` method of Email library to parse data into mail template
* New mail templates variables (site_logo, site_url, staff_name, staff_username, status_name, status_comment)
* Authorize.Net (AIM) Payment gateway
* Template Library function `getActiveThemeOptions()` to retrieve admin theme customizer options and `get_theme_options()` helper function to use within theme files
* Google analytics tracking code and social links theme options to tastyigniter-orange theme
* New mail templates to send emails to notify customer of order or reservation status update
* Dynamic menu navigation from nav_menu array in theme config, so that menu items can be easily managed
* Location Library `orderTimeRange()` function to retrieve location order time ranges
* Customer Library `updateCart()` function to keep track of cart so customer can login to continue later
* New admin setting option to enable or disable new customer review entry and display of existing reviews on storefront
* Invoicing: option to generate invoice number w/ prefix automatically or manually, view invoice from admin order page
* New admin setting option to set invoice prefix and auto or manual invoicing
* New admin setting option to set status to mark order as processing so system can start stock reduction and coupon redemption
* New admin setting option to display or hide stock warning messages
* New admin setting option to allow customers to still checkout if the menu they are ordering is not in stock
* Taxation: option to enable or disable calculating taxes based on set percentage and whether to apply on menu prices or as included with menu prices
* New option to add latitude and longitude manually or fetch automatically in Locations
* New mail template variable `{order_payment}` to display the payment method in order email sent to customer and admin
* Custom error views: override default error views within custom theme by copying the errors folder into the themes/your-custom-theme/ folder
* Themes: option to add and delete theme in the admin backend plus template helper new method `delete_theme`
* Local Module: option to enable or disable single or multi location search mode and selected location for single mode, where orders will be sent.
* Config helper to write configuration value like encryption key into config file
* System Events: hooks to allow you integrate your custom modifications into various points within TastyIgniter’s execution
* Categories: status field to enable or disable selected category in storefront
* Location library `setDeliveryArea()` and `getAreaId()` method to update location delivery area when customer delivery address changes
* Extension library `latestMigration()` method to migrate module migrations to the current version
* Added new parameter to time_elapsed to filter the time diff returned
* User library `isStrictLocation` method to check if staff's group has Strict Location enabled or disabled
* Auto update functionality: updates core files (default controllers, languages, themes, and extensions). ** still in beta mode
* `Site.Updates` permission rule to control staff permission to Update system
* Installer Library `getSysInfo()` function to retrieve current system info, such as ti version, php and mysql version
* Installer Library `upgrade()` function to install database migration and update core version after updating core files
* Added TastyIgniter news feed to admin dashboard, also added Feed_parser library to read and parse the RSS feed XML
* Added missing `getStaffEmail()` to retrieve currently logged staff email
* New mail template variable `{order_comment}`, `{reservation_comment}` and `{telephone}` to display the order comment and customer telephone in emails

#### Changed
* LICENCE from Apache to GNU GPLv3
* Replaced file_get_contents with cURL to fix issue with google maps geocoding api request not being sent
* Renamed `loadPartial()` in Template Library to `loadView()` to load single views without header, footer and partials
* Renamed `addToStaffGroup()` in Permissions Model to `assignPermissionRule()` and moved into Staff groups Model
* Checkout and registration terms and condition pages to display in modal instead of new window
* Media Manager view and style adjustment
* Moved `getPayPalDetails()` method from deprecated Payments model into PayPalExpress extension Paypal model
* Pages: Removed page name redundancy so that only page title and heading are required when creating a new page
* Changed `updateExtension()` parameters in Extensions model to (type, name, data)
* Removed deprecated `setBackButton()` and `getBackButton()` in Template library, use `setButton()` and `getButton()` instead.
* Hard code return and cancel URI in paypal_express module
* Send HTML emails only, remove admin settings option to set TEXT as mail type format
* Improved `resize()` in image tool model so that original image is returned when width and height is not given
* Replaced existing mail templates into responsive HTML mail templates
* Replaced tinymce editor with summernote editor to reduce total source size
* Replaced fancybox with bootstrap modal to reduce total source size
* Restructured controllers so that post data are validated and sent to model at the beginning not end to optimize page load time
* Replaced `completed_order_status` admin setting input field to multiple select field
* Improved language files
* Re-arranged admin nav menu items and improved Template Library `buildNavMenu()` to show third level nav menu
* Improved Themes from listing admin themes on admin panel, this will allow focus only on storefront theme development
* Improved style and script tags so clearing browser cache is not required after upgrade, by appending query string to the URL
* Security: create encryption key and add to config file during setup and upgrade
* Update Page-level DocBlock in system files
* Improved database migration such that initial data schema can be inserted while migration is running instead of after. This fixes issue where mail templates data is not updated
* Improved system setup: added one additional step to system setup to confirm license agreement.
* Postcode no longer a required field for non-UK
* Database Maintenance: now saves database backup files into `tastyigniter/migrations/backups` instead of `assets/downloads/` as added security
* Moved `load_db_config()` method from `TI_Config` to `TI_Loader`, so that database config items are loaded earlier in the system
* Renamed admin, main and setup language file `english/english_lang.php` to `english/default_lang.php` to allow seamless translation
* Removed timezone and language settings from staff edit in admin panel
* CORE: use DIR_WRITE_MODE when creating directories.
* Improved add extension functionality: strict upload validation with feedback, renamed methods `Extensions_model::upload()` to `Extensions_model::extractExtension()` and `Extensions::uploadExtension` to `Extensions::addExtension`
* Improved storefront theme responsiveness on all devices
* Theme Customizer: added more options to easily customize the storefront
* Improved Migration capability to check and install module migrations 
* Removed acceptance testing test cases to be improved and replaced with Unit testing
* Improved currency: added left or right symbol placement, thousand & decimal sign and removed iso codes
* Cookie helper now using php native function to delete cookie
* Improved [local_module] strict location order and pre-order functions.
* Replaced system setting default address entry fields with locations dropdown list so that location details can be modified from one interface
* Disable admin from migrating database when system is in production environment
* Improved coupons redemption capability so that coupon is marked as redeemed after order status is updated to the selected processing order statuses
* Improved staff group strict location option and removed `setLocationAccess` method from User library
* Previous guest order now linked a to a newly created customer based on the customer email

#### Fixed
* Bug where extra URL query is not appended after permalink slugs in URI reverse routing
* Bug where empty value is not updated in database by using `isset()` instead of `!empty()` in models INSERT/UPDATE
* Issue where duplicate head tags are added to `<head>` of Media manager
* Bug with undefined method `writeTheme()` in Themes that was replaced in previous version to helper function `save_theme_file()`
* Missing extensions admin language line
* Spelling error in admin setting option `complete_order_status` to `completed_order_status` and `new_order_status` to `default_order_status` and `new_reservation_status` to `default_reservation_status`
* Issue where payment method is not disabled when order total is below the payments minimum order total
* Issue where payment method is not displayed in admin and storefront order view
* Issue where duplicate order is added upon page redirect, also remove received order from user session
* Orders model from not displaying incomplete/lost orders in customer account
* Minor bugs fix
* Issue where site is not translated to default language
* Issue where view data variable collides with theme options variable in the main app.
* Issue with permission rule not being applied when updating individual modules
* Issue with day_elapsed() helper method where it only checks the day instead of checking day and month to determine today or yesterday
* Issue with delivery charge not based on delivery address (#107)
* Issue where cart rounds thousands to the nearest unit
* Issue with special menu status
* Issue with slide-show height in storefront
* Issue where child category menu items is not displaying

### v1.4.2-beta

Release Date: 16 September 2015

* [fixed] staff name in staff updated activity log (67e3fa6)
* [added] TI_DEBUG constant to enable / disable profiler, disabled by default (3a20c4e)
* [fixed] display no_photo.png when resizing an image that doesnt exist (da3d3a8)
* Minor theme fix (4c1ce6b & 01b4535)
* [replaced] theme preview and thumb files with screenshot.png (bb3cfa4)
* [added] Installer library to handle TI initial setup and version updates	(c5a5175)
* [replaced] INSERT SQL to REPLACE SQL in initial_schema and demo_schema (d0aa31c)



### v1.4.1-beta

Release Date: 09 September 2015

* Added support for acceptance testing
* Fixed php version backward-compatibility issues of empty()
* Changed google maps api request from http to https for location search
* Fixed adding comment to menu item added to cart
* Fixed issue with escaping htmlspecialchars when saving lanugaue line to database
* Fixed issue with saving state in customer and location addresses
* Added order restriction option to coupons. Coupon is restricted by order types
* Improved template library, and loading theme config file
* Improved extension update, install, uninstall, and loading extension config file.
* Added newsletter module to collect emails for marketing purposes



### v1.3-beta

Release Date: 18 May 2015

ADDED:

* Session library now using 'CI' files session
* root_url, page_url, admin_url, extension_url method to return site root url
* Themes customization:
	* New method to template library to load theme configuration file
	* theme_config.php configuration file is now required in theme root directory to install/customize themes.
	* 'customize' key required in $theme configuration array, in other to enable/load customization.
	* Section array items `('title', 'desc', 'icon', 'fields')`
	* fields array items `('id', 'type') ('type' => 'hidden|text|password|textarea|group|color|media|checkbox|radio|dropdown|upload')`
    * admin_theme_helper methods moved to Customizer class

* Menu Category hierarchy: with parent and as many child levels
* New column 'status' added to extensions table, to indicate whether extension is installed/uninstalled and to keep extension data in database after uninstallation.
* Cart Module: option to show or hide menu images and set sizes
* Migrations schemas:
	* create trigger (duplicatePermalink) to avoid duplicate permalink value in permalinks table
* Permalinks:
	* added controller attribute to improve routing
* Activities System: New database table schema for activities
* Added order and reservation status color
* Admin domain base controller property _permission_rules added can be overridden by admin domain controllers to set permission rules for the controller
* Extension:
    * New modules can be uploaded from backend
    * Modules and it files can be deleted after its been uninstalled
    * Extensions controllers now loads a mandatory config file on initialization in module_name/config/module_name.php


CHANGES:

* All controller methods visibility are accurately set
* Admin, Main and Setup now separated into apps and shares same system components
    * CI_Controller now has subclass Base_Controller
    * Base_Controller has subclasses Admin_Controller and Main_Controller
    * Both main and admin domain controllers now extends Admin_Controller and Main_Controller respectively instead of CI_Controller
* Application controllers now organized in folder, (this affects URI routing)
* Move encryption_key config item from database to config file.
* Move log_path config item from database to config file.
* modules_locations config item now set from index.php instead of config file
* Settings library now sets config items from database only if settings database table exists
* Base controller now checks if session database table exists before using database with session
* Add option to disable security question for customer
* Migration schemas:
    * table indexes now added in $fields array instead of the `dbforge->add_key` function
* Flash alerts and info now uses `$this->alert->success/danger/error` to add alert message and `$this->alert->display` to display
* Renamed assets/download to assets/downloads (notice the downloads)
* Improved informative database backup with number of rows and displayed
* Renamed template library method `regions()` to `setPartials()`
* Rename template library `setLinkTag()` to `setStyleTag()`
* Default admin_theme and main_theme config items now grouped into default_themes array
* Extensions root folder moved to root folder
* Extensions sub-folders structure re-arranged:
	* controllers/admin and controllers/main merged into controllers/
	* languages/admin and languages/main merged into languages/
	* views/admin and views/main merged into views/
* Extension class methods moved to Extension_model class and Extension class acts as a Facade
* Renamed permalink to USER-friendly slug also column in permalinks table
* Reviews can now be added on reservations and orders. column order_id changed to sale_id and new column sale_type added to differentiate order reviews from reservations reviews.
* Status History:
	* changed status_history database table column from assigned_id to assignee_id
	* changed reservations database table column from staff_id to assignee_id
	* added assignee_id column to orders database table
* Changed Activity library to Customer_online Library
* Customers Online:
    * settings item activity timeout changed to customers_online_timeout
    * settings item activity archive changed to customers_online_archive_timeout
    * IP blacklist removed, to be added back in next version
* Added referrer_url to ti_url_helper, which will return the user referral url.
* Changed `config('maintenance_page')` to `config('maintenance_message')` and use `show_error()` instead of loading controller.
* Improved banners and banners_module.... move dimension from banners and banners_module.
* Extracted categories, menu_options associated methods into separate models from menus_model
* Extracted banners associated methods into separate models from design_model and rename to layout_model
* Improved user permission functionality, permission can be set as rules within controllers.
* Removed duplicate admin domain controllers methods and models methods
* Improved site_url and `redirect()` uri re-routing
* Improved image manager styles responsiveness and remove irrelevant options
* Fixed models delete methods to accept array of ids
* Changed customer activity to customer_online
* Messages:
    * renamed messages controller method edit to compose
    * added messages controller methods all, draft, sent,
    * removed message type trash
    * Schema:
        * drop location_id, staff_id_to columns in messages table
        * drop staff_id, staff_email, customer_email, customer_id columns in message_recipients table
        * rename column staff_id_from to sender_id in messages table
        * added columns key and value to message_recipients table
* Improved user permissions
    * added permission database table and Permissions_model
    * added `restrict()` method to check user permission then redirect and show message to user if permission fails
    * improved `hasPermission()` method to check user permission and return TRUE on permitted or FALSE on restricted
* Permissions are a simple string made up of 3 parts:
    * Domain  - Typically the module name for application (e.g. Admin, Main, Module).
    * Context - The controller name (e.g. Menu, Order, Location, or Settings).
    * Action  - The permitted action (View, Manage, Add, Edit, Delete, etc.).
* Removed Setting Library, no longer used. (functionality moved to Base_Controller)
* Removed permission context (controller and view files), no longer needed. (Permission error message displayed using alerts)
* Add tastyigniter_helper to include `log_activity()` and other general helpers
* Activities:
    * Rename Notifications_model to Activities_model
    * add notifications from inside controllers instead of models
    * rename to `Activities_model->addNotification` to logActivity
    * create log_activity helper function to add activities to database and to be called from controllers
    * logActivity method accepts 4 args user_id, action, context and message
        * rename notifications database table to activities
        * rename actor_id to user_id and object to context
        * drop unused columns from notifications table: suffix, object_id, subject_id
        * add columns user, message, domain, context to activities table
* Database Migration from admin domain
    * Migrate database to latest version
    * Restore database from downloaded backup sql files and disabled uploading sql files
* Replaced reserve controller, language, view to reservation
* Location:
    * Added location image/logo
    * changed property reservation_interval, reservation_turn to reservation_time_interval and reservation_stay_time respectively
    * Move local search functionality from cart_module to local_module
    * removed location settings search by no needed getLatLng does not check search_by settings anymore
* Languages:
    * ensure main domain is completely internationalized
    * internationalized admin domain
    * ensure common and duplicate lang lines are moved to english_lang.php
    * prefix all language line keys with text_ label_ column_ error_ alert_ button_
    * added new language helper functions
    * added can_delete functionality to language edit
* Themes: move some themes_model functions to template_helper