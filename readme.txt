=== WPCargo Track & Trace===
Contributors: WPTaskforce
Donate link: https://wpcargo.com/
Tags: transportation management, status tracking, shipment tracking, order tracking, delivery tracking, tracking system, package tracking, courier tracking, order management, order status, order shortcode, order management system, order tracking system, status tracking system, status tracking software, delivery tracking system
Tested up to: 5.4.1
Stable tag: 6.x.x
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

WPCargo is a track &amp; trace system for courier, courier script, parcel, shipment and transportation management system, ideal solution for freight forwarder, customs broker, balikbayan forwarder, importer, exporter, supplier, shipper, overseas agent, transporter, &amp; warehouse operator.​​ WPCargo helps manage operations, customers, drivers, quotation, form, branch, and employees. 

== Description ==

[Main Site](https://www.wpcargo.com/) | [Documentation](https://www.wpcargo.com/knowledgebase/) | [Showcase](https://www.wpcargo.com/features/) | [Premium Addons](https://www.wpcargo.com/purchase) | [Demo](https://www.wpcargo.com/demo-login/)

WPCargo is a WordPress plug-in designed to provide ideal technology solution for your freight forwarding, transportation & logistics operations. Whether you are an exporter, freight forwarder, importer, supplier, customs broker, overseas agent, or warehouse operator, WPCargo helps you increase the visibility, efficiency, and quality services of your cargo and shipment business.

WPCargo helps manage operations, customers, drivers, quotation, form, branch, and employees. The latest version is flexible that can be used and utilised as transport management, project management or other status tracking management system.

= Core Plugin Features =

* Shipment Track Form
* Manage Shipment 
* Shipment Settings
* Search & Sorting of Shipment List
* Email Notification - Client & Admin
* Auto Generate Tracking Number 
* Client Account - shortcode for user created shipment 
* Multilingual Support
* Support Barcode
* Shipment History - track location , date and status of the cargo
* Print Label
* Generate Report
* Multiple Packages

= Premium Features =

* [Fully customizable form fields](https://www.wpcargo.com/product/wpcargo-custom-field-add-ons/)
* [Add Signature in custom field manager](https://www.wpcargo.com/product/wpcargo-signature-add-ons/)
* [SMS Notification](https://www.wpcargo.com/product/wpcargo-sms-add-ons/)
* [Allow user to manage thier shipment](https://www.wpcargo.com/product/wpcargo-client-accounts-add-ons/) - Merge in free version
* [User Front-end Manager](https://www.wpcargo.com/product/wpcargo-frontend-manager/)
* [CSV Import/Export](https://www.wpcargo.com/product/wpcargo-importexport-add-ons/)
* [Online Booking](https://www.wpcargo.com/product/wpcargo-pick-management-add-ons/)
* [Address Book](https://www.wpcargo.com/product/wpcargo-address-book-add-ons/)
* [Proof of Delivery - allow driver or delivery to sign by reciever  and add images as a proof that the cargo has been delivered](https://www.wpcargo.com/product/wpcargo-proof-delivery/)
* Vehicle Manager can assign the delivery to your driver or vehicle - Merge in Proof of Delivery
* [Detrack.com Integration](https://www.wpcargo.com/product/wpcargo-detrack-integration-add-ons/)
* [Branch Manager](https://www.wpcargo.com/product/wpcargo-branch-manager-add-ons/)
* [Shipment Container](https://www.wpcargo.com/product/wpcargo-shipment-container-add-ons/)
* [Multi Receiver](https://www.wpcargo.com/product/wpcargo-multi-receivier-add-ons/)
* [Request Quotes with  Woocommerce integration](https://www.wpcargo.com/product/wpcargo-parcel-quotation-add-ons/)
* [Woocommerce Order Tracking Integration](https://www.wpcargo.com/product/wpcargo-woocommerce-order-integration/)
* Delivery Calculator - Customization
* Collection Point - Customization
* Ability to track shipment from other company (Fedex , USPS) - Discontinue 
* [Shipment Consolidation](https://www.wpcargo.com/demo-login/)
* [Shipping Rates with Woocommerce integration](https://www.wpcargo.com/product/wpcargo-shipping-rate/)
* [POS](https://www.wpcargo.com/product/wpcargo-woocommerce-pos-add-on/)
* [Barcode Reader Status Update](https://www.wpcargo.com/product/wpcargo-receiver-add-ons/)
* [Service API](https://www.wpcargo.com/product/wpcargo-api-addon/)

= Demos =

[View Our Demos](https://www.wpcargo.com/demo-login/)

[View More features](https://www.wpcargo.com/features/)

Contact Skype: arni.cinco

== Installation ==

1. Upload `WPCargo.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently asked questions ==

- How can I add the Pages for Track Form and Track Result?

First thing to do is to create a pages and setup the Track Form and Track Result under the WPCargo Settings->Page Settings

- How can I add options on each fields?

In WPCargo Settings Page add the option that you needed on each fields.(New line on each option)

Example on Add Shipment Status section:

On-Hold,Pending,Delivered

- How to add an Agent?

Add a new user and change the role into "Agent".

- What is the shortcode to use?

Single Page with results:[wpcargo_trackform]

2 Page with results:

[wpcargo_trackform id=page id of results]

[wpcargo_trackresults]

[wpcargo_account]

== Screenshots ==

1. All Shipments
2. Track Shipment
3. Shipment Results

== Changelog ==

= 6.4.10 =

- Fixed shipment history error undefined index
- Remove user meta for the wpcargo user information (Depreciated) 

= 6.4.9 =

- Fixed error on local time
- Fixed error of undefined index in shipment results template

= 6.4.8 =

- Fixed translations of the following languages: Arabic, Italian, French(France), French(Canada), Spanish, Russian, Romanian

= 6.4.7 =

- Fixed shipment status settings not showing when custom field add on installed and activated
- Add Registered Shipper filter for reports

= 6.4.6 =

- Fixed error google autocomplete when no API is found
- Fixed the assign employee meta key based on the frontent end manager meta key for the assign employee
- Add auto search for the report page

= 6.4.5 =

- Fixed date data undefined to other language
- Fixed Color Picker script error on add new page
- Update email footer devider to be removable through hook

= 6.4.4 =

- Fixed error of Russian translation of WPCargo menu on wp-admin
- Add Italian language translation

= 6.4.3 =

- Add class attribute in the shipment history table row and data
- Add class attribute in the packages table row and data

= 6.4.2 =

- Fixed error on removing shipment history.
- Updated wpcargo_field_generator function to include checkbox and radio button type with array as option
- Fixed invoice layout

= 6.4.1 =

- Updated array format of getting meta data for reports fields.

= 6.4.0 =

- Fixed error on reports features when WPCargo Custom Field Add-ons is activated
- Fixed error on search form and results when WPCargo Custom Field Add-ons is activated

= 6.3.9 =

- Additional hook to add setting option for disabling emails when branch manager and pod is installed
- Updated wpcargo_field_generator to identify required fields
- Add translation for Russian language
- Fix translation of French(France) language

= 6.3.8 =

- Add translation for French(France) language

= 6.3.7 =

- Fix error in reports form.
- Add translation for Arabic and Spanish(Spain) language

= 6.3.6 =

- Fixed error of saving status when status field is empty.

= 6.3.5 =

- Adjust width of dimensions in package table
- Fixed error on after package data shows even multiple package is disabled
- Update description for package table to textarea
- Use wpcargo fullname function on assigning users dropdown
- Fixed layout of track result page
- Add setting to enable/disable sending of emails to assigned users
- Removed print track result on frontend until layout will be fixed
- Fixed login form layout
- Deprecate [wpc-ca-account] and [wpcargo_trackresults] shortcodes
- Changed Add Shipment Country to Add Shipment Location in General Settings

= 6.3.4 =

- Additional hook to disable sending of email to assigned employee, agent and client.

= 6.3.3 =

- Additional field for map setting to set specific country for auto complete results.

= 6.3.2 =

- Additional map setting to set default location.

= 6.3.1 =

- Fixed error on assign user to shipment email notification.
- Fixed track result nonce error with woocommerce installed.
- Fixed track result show parameter not working.

= 6.3.0 =

- Fix error of map not showing on results.

= 6.2.9 =

- Fix error of saving an empty status.

= 6.2.8 =

- Fixed Admin packages table repeater functionality not working error.

= 6.2.7 =

- Return missing print label Account's Copy

= 6.2.6 =

- Added functionality that enables user to customize print label on wp-admin through child theme

= 6.2.5 =

- Fix issue of status not saving

= 6.2.4 =

- Added email notification when assigning shipments to employee, agent and client

= 6.2.3 =

- Fixed change common class with prefix wpcargo conflict

= 6.2.2 =

- Fixed error on email notification

= 6.2.1 =

- Updated history fields to be dynamic on quick edit shipment
- Fixed width of fields on package table
- Fixed issue on map API
- Fixed issue on saving status
- Fixed issue on auto populate of time and date in history fields ( Admin Page )

= 6.2.0 =

- Additional filter for modifying history fields
- Removed package details on print label
- Changes on the function to display map
- Removed function wpcargo_shipment_history_map_callback and replace it on wpcargo_gmap_library function
- Added Datetime Picker library to be used on all plugins
- Removed timepicker library

= 6.1.8 =

- Fix Package details missing on track form
- Remove demo section on settings

= 6.1.7 =

- Fixed print label and invoice errors with custom sections
- Fixed packages field display error
- Fixed packages volume calculation errors

= 6.1.6 =

- Remove Client Account Settings
- Remove dropdown fields for Registered Shipper and Registered Receiver
- Fix error of bulk edit of shipments
- Removed required attribute from client and employee dropdown in wp-admin

= 6.1.5 =

- Removed required attribute from client and employee dropdown in wp-admin

= 6.1.4.1 =

- Fixed error of non-existing callback

= 6.1.4 =

- Fixed shipment metabox errors
- Fixed error for non-numeric value encountered
- Disabled wp-admin top bar for client login
- Restrict Client access to wp-admin
- Added employee role as default when plugin is activated

= 6.1.3 =

- Fixed wordpress plugin version compatibility

= 6.1.2 =

- Restrict access of Client user on wp-admin
- Additional Assign Shipment to metabox for respective designations
- Added user role Employee
- Added default page Account for Client
- Updated user capabilities of Agent
- Fix bugs on repeater field for packages

= 6.1.1 =

- Fixed the shipment bulk update.

= 6.1.0 =

- Fixed SMS hook error.
- Update the shipment multiple package templates and add volumetric and actual weight calcualtion.
- Add some hooks and filters for easy customization.
- Changed "Invoice" print button label into "Print".
- Add defualt settings value during plugin activation.

= 6.0.9 =

- Update track result template and add new section for the shipment status.
- Update shipment details section into 3 column layout
- Update track result font family into google font "Roboto"

= 6.0.8 =

- Add new settings for the TAX in percentage.
- Checked plugin error for wordpress version 5.2.

= 6.0.7 =

- Add new parameter on the "wpcargo_trackform" shortcode "show", this parameter will allow user to either to display the track form after form submission or not. This paramter will accept 1 or 0, the default value is 1.
- Fixed the pagination styles
- Add Hook "wpcargo_before_shipment_details" for the track result template.
- Fixed the "wpcargo_get_postmeta" function for the URL form field display format.
- Add filter "wpcargo_track_result_shipment_number" for customizing track result shipment number label.
- Add filter "wpcargo_print_invoice_label" for customizing track result print invoice button label.

= 6.0.6 =

- Add new settings for the Shipment Map for "Map Type" and "Zoom Level"

= 6.0.5 =

- Fixed shipment history map display in print invoice page.
- Fixed date format display based on general settings.

= 6.0.4 =

- Add new option for the shipment history map to display in result page.

= 6.0.3 =

- Fixed display shipment serialize value.
- Create plugin based CSS based on Bootstrap template to fix CSS compatibility with Bootstrap 3.x.x and below.
- Fixed popup close button for view shipment NOT clickable.
- Update plugin button classes.

= 6.0.2 =

- Fixed track form mobile reposive layout.

= 6.0.1 =

- Fixed pre display track result data.
- Update CSS compatibility with Bootstrap 3.x.x and below
- Add new filter for the registered shipper query
- Fixed Shipment status error on save.
- Fixed WPCargo Client role missing on Client account plugin deactivation.
- Fixed registered shipper data missing on shipment update.
- Add Bulk update for registered shipper.

= 6.0.0 =

- Fixed language translation.
- Fixed duplicate create shipment number.
- Merge client account add on function.
- Add admin shipment status email notification.
- Update plugin style with bootstrap based styles.
- Fixed date and time format for the date and time picker fields.
- Add new shotcode [wpcargo_account] for the client front end dashboard.
- Add new user role "WPCargo Client".
- Fixed email notification header error.
- Add new filter for the shipment owner in the shipment table list.
- Fixed email shortcodes for the {site_name}, {site_url}, and {admin_email} errors.
- Update the Email shotcode tags into actual shipment meta keys.
- Fixed SMS add ons hook error.
- Add new settings for the shipment number suffix.
- Update the track result template and fixed mobile responsive layout.

= 5.3.1 =

- Fixed autogenerate Shipment Number bug when updating shipment.

= 5.3.0 =

- Add new function to allow admin to decide the number of digits for the Shipment Title number.
- Allow auto generate shipment number even without shipment prefix.
- Fixed language translation in track form placeholder.

= 5.2.3 =

- Fixed Shipment History bug when no Wpcargo Settings is available.
- Add Shipment History Map Tab in WPCargo settings navigation.
- Fixed Navigation Tab wpcargo base color.

= 5.2.2 =

- Fixed the Email notification BCC and CC using shortcode.
- Add shipment filter for shipment category in shipment table
- Add class to shipment status for CSS customization
- Add class to shipment history class for CSS customization
- Fixed shipment history WPML comaptibility
- Fixed error on Shipment history Map

= 5.2.1 =

- Fixed the User timezone bug
- Create new user fields to set specific user timezone

= 5.2.0 =

- Newly added feature for Shipment History Google Map Tracker
- Add bulk and quick edit functionality in Shipment table
- Fixed minor bugs

= 5.1.0 =

- Add filters to shipment history and multiple package section header
- Fixed the Shipment history delete button bug
- Update the shipment status section, Remove the required attribute by default in all form fields and make it required when the shipment status option is not empty.

= 5.0.7 =

- Add option to enable User Timezone in general settings

= 5.0.6 =

- Fixed the script error on admin edit.php page
- Update the date and time default value based on current user localization.

= 5.0.5 =

- Add new Email settings for the Email Cc and Bcc.

= 5.0.4 =

- Fixed CSV format to SLYK format issue in exporting shipment data.
- Fixed the Select Option auto save bug in export shipment form.
- Add pre field value for the shipment history fields for the date, time and location.

= 5.0.3 =

- Fixed email notification bug.
- Add new email notification setting "Select Shipment Status to send email Notification"
- Fixed Color theme in report page
- Fixed Shipment History Shipment Status option bug

= 5.0.2 =

- Fixed the shipment history table list error when no settings are set.
- Remove the duplication of the Carrier field data.
- Update Styles for mobile responsive
- Update the Report Select option data to be form label.

= 5.0.1 =

- Fixed the shipment history display settings error.

= 5.0.0 =

- Add print label functionaly for the shipment.
- Add some styling for the data display consistency.
- Add option to Display Shipment History in result Page (General Settings).
- Update Shipment hitory template. Removed the add shipment history and add admin restriction for the user role to update shipment history (General Settings).
- Remove the Shipment Status in the Shipment fields.
- Merge the Shipment Status with the Shipment History form fields ( note: Add shipment History form above Publish Button ).
- Fixed bug with the Custom Field add on compatibilty
- Add the followig Filters for shipment data customization
- "wpcargo_status_option" - accepts one parameter ( must be array value ). this will affect the wpcargo status options.
- "wpc_shipper_name_table_data" - accept string ( metakey ). This will replace the Shipper name column in the Shipment table.
- "wpc_receiver_name_table_data" - accept string ( metakey ). This will replace the Receiver name column in the Shipment table.
- "wpc_report_search_shipper_name_metakey" - accept string ( metakay ). This will change the shipment metakey to be search in Senders name in Report page.
- "label_template_url" - Accept file Path. This will replace the Shipment label template.

= 4.2.2 =

- Fix array if empty in customfield manager

= 4.2.1 =

- Fix shipping history to get the colum header column in the settings

= 4.2.0 =

- Added settings for changing background color of column  and button colour in admin

= 4.1.2 =

- Fix shipment history  error in  fresh install

= 4.0.9 =

- Fix the default email template responsive

= 4.0.8 =

- Fix issues on shipment history (duplicating shipment history)

= 4.0.7 =

- Fix Templates on Shipment History

- Fix Styles on Shipment History

= 4.0.6 =

- Fixed issue on Shipment History Frontend

= 4.0.4 =

- Fixed issue on Shipment History Admin section

= 4.0.3 =

- Added sortable column on admin (Agent, Shipper Name, Receiver Name, Date)
- Default sort is order by date

= 4.0.2 =

- Fix issues on filter
- Added "Updated By" Column on Shipment History

= 4.0.1 =

- Update Admin Styles

= 4.0.0 =

- Added Shipment History
- Added Reports
- Added Filters for Reports(shipper name, status, date, category)
- Update Email Notification
- Fix issues on filter on admin dashboard

= 3.2.0 =

- Update the Email Notification Template at the frontend - http://www.wpcargo.com/email-settings/
- Added WPCargo Merge Tags Notification
- Update Email Notification for WPCargo Shipment History Add-ons
- Added Email Settings

= 3.1.9 =

- Changed the lists of Shipment Table (Tracking Number, Agent, Shipper Name, Receiver Name, Date, Status, Actions)
- Added Filter by Agent, Shipper and Receiver on Lists of Shipment

= 3.1.8 =

- Fix Bugs on metabox for the Client Accounts Add-ons

= 3.1.7 =

- Remove other styles

= 3.1.6 =

- Update Mobile Responsive in results
- Update Mobile Responsive in shipment admin dashboard

= 3.1.5 =

- Update the date format on frontend
- Update the time format of shipment based on WordPress(General Settings)
- Added Filter by Status on Admin
- Update Multiple Package Mobile Responsive

= 3.1.4 =

- Update the date format of shipment based on WordPress(General Settings)

= 3.1.3 =

- Fix Issues on Multiple Package Frontend and Backend

= 3.1.2 =

- Fix Issue of Multple Package at the shipment results
- Added Enable and Disable Settings for Multiple Package

= 3.1.1 =

- Added Multiple Packages

= 3.1.0 =

- Fix Issue on saving shipments

= 3.0.10 =

- Fix Issue/bugs on Email
- Fix Error on Email Settings
- Fix Error on Headers after activation

= 3.0.8 =

- Improve GUI on front-end and back-end

= 3.0.7 =

- Fix issue on print

= 3.0.6 =

- Fix CSS conflict on other theme's

= 3.0.5 =

- Fix Email Update Notification
- Fix jQuery Date Format
- Add Settings for the barcode to display at the frontend

= 3.0.4 =

- Improve Internationalization
- Improve Mobile Responsive

= 3.0.3 =

- Remove Flush Rewrite Rules Function
- Add Priority Parameter on Registering Custom Post Type

= 3.0.2 =

- Remove "wp_verify_nonce" to avoid conflict on other themes

= 3.0.1 =

- Added Print on Admin Shipments
- Added Developer Hooks on Print
- Fix Email Notification
- Fix Issue on Date and Time on Firefox Browser
- Added Filters

= 3.0.0 =

- Added Developer Hooks
- Fix jQuery Bugs
- Add Template Folder
- Add Language Folder
- Add Localization
- Enhance Script
- Update Styles
- Create Separate Settings
- Add Title Prefix Settings
- Organize Scripts and Directories
- Add Print on result page
- Add Email Notification when updating shipments

= 2.0.1 =

- Remove tabs
- Remove jQuery Bugs
- Fix Admin Notice Bugs
- Additional Settings for the WPCargo Title Prefix
- Add Functionality for the auto generation of the title

= 2.0.0 =

- Update the Track Form and Track Result to one(1) page
- Add a search functionality on "No results found"
- Add Filter on Forms
- Update for SMS Settings (Twilio Gateway)
- Update for WPCargo Email Add-ons

= 1.0.5 =

- Add Filter to edit other titles - http://www.wpcargo.com/added-apply-filter-on-version-1-0-5/
- Fix conflicts between the filter of the post and wpcargo
- Fix Print Layout on Result Page

= 1.0.4 =

- Fix the div tags closing on track result page

= 1.0.3 =

- Fix Error on Filter
- Add the Add-ons Settings (Email Settings, SMS Settings)
- Add details on Add-ons Page (WPCargo Email Add-ons, WPCargo SMS Add-ons)

= 1.0.2 =

- Fix bugs in inserting/updating into database

= 1.0.1 =

- Removed License Manager
- Fixed bugs for the add-ons
- Fixed the Shipment Status
- Change other strings to make it readable for developers
- Add Add-ons Page that might help you
- Fixed jQuery conflicts

= 1.0.0 =

- Add Filter by Shipment Status
- Add Filter by Shipment Category

== Upgrade Notice ==

Just upgrade via Wordpress.