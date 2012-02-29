=== Feedburner Circulation ===
Contributors: valendesigns
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=accounts@valendesigns.com&item_name=Feedburner+Circulation
Tags: feedburner, feed, circulation, count
Requires at least: 2.7
Tested up to: 3.0.2
Stable tag: 1.2

Returns your Feedburner Circulation Count. Reduces the Feedburner API calls by updating hourly and serving a database cached result in between.

== Description ==

Returns a database stored Feedburner Circulation Count in plain text or number format. Reduces the Feedburner API calls by only updating the circulation count hourly and serving a database cached result in between. The account you're attempting to get a "Circulation Count" from must have the awareness API turned on.

You can use the function `<?php circulation_count( $ids, $default, $echo, $format ); ?>` in your theme files. The following is an explanation of the parameters the function excepts.

* @param array $ids an array of Feedburner Feed IDs
* @param int $default your fallback circulation count during a zero result: default 0
* @param bool $echo return or echo: default true (echo)
* @param bool $format return as plain integer or number formatted: default true (number format)

For example, if I was Psdtuts+ and wanted to echo out a circulation count that had a fallback or default circulation count in the unlikely event nothing is stored in the database or there is a weird zero result returned, I would do the follow.
`<?php circulation_count( 'psdtuts', 15000 ); ?>`

If I wanted to save the count to a variable as a plain integer that I could add to another count or something similar I would do this.
`<?php $circulation_count = circulation_count( 'psdtuts', 15000, false, false ); ?>`

If I wanted to echo a formatted count form an array of $ids with a fallback, I would do this.
`<?php circulation_count( array('psdtuts', 'nettuts'), 200000 ); ?>`

== Installation ==

1. Upload `feedburner-circulation` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Does this plugin require any certain PHP functions? =
Yes! Your server must have `simplexml_load_file()` available or the plugin will fail to work properly. Basically, you server needs to be running PHP 5.

== Changelog ==

= 1.2 =
* Added the ability to pass in an array of feed IDs
* More code optimization & clean up
* Added default count
* Added the choice to echo or return
* Added the choice to return plain or formatted number
* Changed the function names
* Deprecated `get_feedburner_circulation_text()`
* Deprecated `feedburner_circulation_text()`

= 1.1 =
* Complete code overhaul and optimization
* Goes a step further to fix the zero result issue
* Uses `set_transient()` to save the count instead of a dedicated feedburner table

= 1.0.1 =
* Fixed Feedburner returning a zero result

= 1.0.0 =
* Feedburner API is limited to 1 call per hour
* Saved to your WordPress database
* Test for an http_code equal to 200 else returns 0 (important if server is down so no xml error is thrown)

== Upgrade Notice ==

= 1.2 =
* Allows a default result in the off chance Feedburner returns a zero result
* Update your theme to use the new improved functions (Deprecated ones still work)

= 1.1 =
* A much more optimized codebase and should not return a zero result.