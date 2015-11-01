=== Easy Appointments ===
Contributors: loncar
Donate link: http://nikolaloncar.com/donate/
Tags: appointment, appointments, booking, calendar, plugin, reservation, reservations, wordpress, wp appointment
Requires at least: 3.7
Tested up to: 4.3
Stable tag: 1.6.0
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easy Appointments Wordpress plugin. Add Booking system to your WordPress site and manage Appointments with ease. Extremely flexible time management.

== Description ==

Add Booking Appointments system to your WordPress site and manage Appointments with ease. Extremely flexible time management. Multiple location, services and workers. Email notifications. 

Can be used for : <strong>Lawyers</strong>, <strong>Salons</strong>, <strong>Mechanic</strong>, <strong>Cleaning services</strong>, <strong>Doctors</strong>, <strong>Spas</strong>, <strong>Personal trainers </strong>, <strong>Private Lessons</strong>, etc,

= Features =

1. Multiple location
2. Multiple services
3. Multiple workers
4. Extremely flexible time table
5. Email notifications
6. Responsive Bootstrap Layout for Appointment form  - new shorcode `[ea_bootstrap]`
7. Internationalization - support for translations
8. Localization of datepicker for 77 different languages
9. Two column layout for bootstrap form
10. **NEW** Custom form fields (input, select, textarea)

= Live Demo =
<a href="http://nikolaloncar.com/demo/easy-appointments/">**Standard Appointment form**</a><br>
<a href="http://nikolaloncar.com/demo/easy-appointments-bootstrap/">**Bootstrap responsive Appointment form**</a>

= Doc =
http://nikolaloncar.com/easy-appointments-wordpress-plugin/easy-appointments-documentacion/

= HomePage =
http://nikolaloncar.com/easy-appointments-wordpress-plugin/

== Installation ==

= Install process is quite simple : =

– After getting plugin ZIP file log onto WP admin page.
– Open Plugins >> Add new.
– Click on “Upload plugin” beside top heading.
– Drag and drop plugin zip file.

= Shorcode =
In order to have Appointments form in your Page or Post insert following shortcode
<code>
[ea_standard]
</code>

For **NEW** bootstrap version :
<code>
[ea_bootstrap]
</code>

Options :

width : default value 400px
scroll_off : default value off
layout_cols : default value 1

example : [ea_bootstrap width="800px" scroll_off="true" layout_cols="2"]

== Frequently Asked Questions ==

= How to hide service / location / worker in front end part of form? =

To do this you must create one location / worker or service and set Name that starts with underscore. For example : *_dummy*, *_location*...

= In admin panel all pages from plugin are blank? =

You have probably turned on option in PHP called asp_tags, you need to turn it off in order to plugin work properly.

= I can't edit or delete any settings? =

Your hosting is probably blocking HTTP PUT and DELETE method. You must mark option called 'Compatibility mode' in settings.

= How to set multiple slots for one combination of location, service, worker? =

To add more slots per (location, service, worker) combination just clone the existing one. For two slots you need to
have that connection twice.

= How to insert Easy Appointments widget on Page/Post? =

Place following shortcode into your Page/Post content:

<code>
[ea_standard]
</code>
OR
<code>
[ea_bootstrap]
</code>

For bootstrap there are options :
width : default value 400px
scroll_off : default value off
layout_cols : default value 1

Example :
`[ea_bootstrap width="800px" scroll_off="true" layout_cols="2"]`

= How to set form in two columns? =

You can set bootstrap form in two columns with `layout_cols` option. Example :

<code>
[ea_bootstrap width="800px" scroll_off="true" layout_cols="2"]
</code>

== Screenshots ==

1. **NEW** Responsive front end shortcode `[ea_bootstrap]` - part1
2. **NEW** Responsive front end shortcode `[ea_bootstrap]` - part2
3. Standard front end form for Appointment `[ea_standard]` - part1
4. Standard front end form for Appointment `[ea_standard]` - part2
5. Admin panel - Appointments list
6. Admin panel - Settings Location. Define your Locations
7. Admin panel - Settings Services. Define your Services
8. Admin panel - Settings Workers. Define your Workers
9. Admin panel - Settings Connection. Set single combination for location, service, worker
10. Admin panel - Customize - Email notifications
11. Admin panel - Customize - Label customization
12. Admin panel - Report - Time table overview

== Changelog ==

= 1.6.0 =
* Fix issue with activating the plugin and error output
* UTF8 email encoding
* Option for turning of Location/Services/Worker by setting dummy records. Set name that starts with underscore (for example :*_dummy*).

= 1.5.2 = 
* Compatibility mode for hostings that are blocking PUT and DELETE methods

= 1.5.1 =
* Fix bug with sending email notification
* Fix bug with filtering appointments in Admin panel
* New options for worker, before free slots are calculated only for current service type. Now you can calculate free slots for all services for that worker

= 1.5.0 = 
* Custom form fields
* Fix bug with new year and date selection in calendar
* Fix issue with wrong time after creating appointment in admin panel

= 1.4.1 = 
* Fix bug with status change and email notification in admin panel

= 1.4.0 =
* Calendar in bootstrap form now shows the free days and days with out free slots
* Improved scroll to after cancel option
* Fix bug with clone button in settings/connection

= 1.3.0 =
* New options for cancel button and scroll
* I agree option for form

= 1.2.11 =
* Fix install

= 1.2.10 =
* Fix bug with fresh install and customize page of settings

= 1.2.9 =
* Fix for bug on editing location/service/worker that delete connection.
* New option is customize tab : custom css field
* Minor css improvement

= 1.2.8 =
* Option for sending user email after completing the form on frontend

= 1.2.7 = 
* Fix bug with Media item in menu
* Ajax spinner
* Added rows class attributes for overview on bootstrap form

= 1.2.6 =
* Bootstrap widget improvement: scroll_off option, two column layout, custom width value.

= 1.2.5 =
* Fix bootstrap issue that change style on whole page
* New tags for email notification
* Improved style of new appointment notification

= 1.2.4 =
* Localization of datepicker for 77 different languages
* Fix issue with phone that starts with 0

= 1.2.3 =
* Fix translations issue, not including mo files
* Fix bug with db update in 1.2.2 version

= 1.2.2 = 
* Fix timezone issue for current day
* Fix translations issue
* Price field in booking overview
* Database changes (force reference integrity)

= 1.2.1 =
* Included label translation functions
* Fix : init scroll

= 1.2.0 =
* New shortcode for bootstrap version of frontend form `[ea_bootstrap]`

= 1.1.1 =
* Fix : select all days in a week
* Improved styles

= 1.1 =
* Improved styles and overview form
* Translations : done message
* Notification to custom email on pending appointment
* Fix scroll for date/time change

= 1.0 =
* First release

== Upgrade Notice ==

= 1.6.0 =
* Please update if you are experiencing problems with AJAX naming collision

= 1.5.2 =
* If you can't edit or delete items on settings page please update this version. After update mark Compatibility mode option in settings.

= 1.5.1 = 
* Please update to new version, there are bugs on 1.5 with email notifications.

= 1.5.0 =
* Please check if there are all fields with appointments

= 1.4.1 =
* Please update plugin to fix bug with email notifications on status change

= 1.4.0 =
* Calendar in bootstrap form now shows the free days and days with out free slots
* Improved scroll to after cancel option
* Fix bug with clone button in settings/connection

= 1.3.0 =
* New options

= 1.2.11 =
* Fix install

= 1.2.10 = 
* If you have fresh install of 1.2.9 (not upgrade from previous versions), there is problem with customize page of settings. This version have fix for it.

= 1.2.9 =
* * Fix for bug on editing location/service/worker that delete connection

= 1.2.8 =
* Option for sending user email after completing the form on frontend

= 1.2.7 = 
* Fix bug with Media menu item that is missing

= 1.2.6 =
* Bootstrap widget improvement: scroll_off option, two column layout, custom width value.

= 1.2.5 =
* Please check bootstrap widget if you using it. There has been changes on style part.

= 1.2.4 =
* Localization of datepicker for 77 different languages
* Fix issue with phone that starts with 0

= 1.2.3 =
* Fix translation issue with mo files. In order to use localization, place *.mo files into languages dir inside plugin dir.
* Fix bug with db update in 1.2.2 version.

= 1.2.2 =
* Please take upgrade with great care. There has been database changes regarding reference integrity of data. So upgrade will remove appointments/connections that don't have some key value (location, worker, service).

= 1.2.1 = 
* Fixed init scroll

= 1.2.0 =
* New Responsive layout shortcode.