=== CurrencyConverter ===
Contributors: lb-company, korobochkin
Tags: currency converter, currencyconverter, currencies, currency, rates, exchange, converter, widgets, usd, dollar, eur, euro, foreign exchange conversion, fx rate converter, currency converter widget, money
Requires at least: 4.0.0
Tested up to: 4.4.2
Stable tag: 0.4.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

More than 170+ currency rates. The data about currency rates is free and updates each hour automatically.

== Description ==

More than 170+ currency rates. The data with currency rates is free and updates each hour automatically.

= Features =

1. Few widgets for showing currency rates. Each widget have multiple settings for customizing.
2. You can choose data provider.
3. No additional load to your site. Currency rates updated in background and cached.
4. Useful API for creating your custom widgets or showing exchange rates anywhere on your website.

= Data providers =

We are collect data from multiple data providers and store them on our server [exchangerate.guru](http://exchangerate.guru). This plugin retrieve data only from exchangerate.guru for all data providers (one request per hour by WordPress Cron). Our public API don't require any keys or passwords. Right now we have data from two data providers such as:

1. Open Exchange Rates (170+ currencies).
2. Central Bank of Russia (30+ currencies).

You can [suggest additional functionality or widget](https://github.com/korobochkin/currency/issues) for this plugin by posting your idea on Github. We will try to add functionality in future versions.

== Installation ==

= From your WordPress dashboard =

1. Visit 'Plugins > Add New'
2. Search for 'currencyconverter'
3. Activate CurrencyConverter from your Plugins page.
4. Add widgets on yourdomain.com/wp-admin/widgets.php page.

= From WordPress.org =

1. Download CurrencyConverter.
2. Upload the 'currencyconverter' directory to your '/wp-content/plugins/' directory, using your favorite method (ftp, sftp, scp, etc...).
3. Activate CurrencyConverter from your Plugins page.
4. Add widgets on yourdomain.com/wp-admin/widgets.php page.

== Screenshots ==

1. Minimalistic widget.
2. Table widget.
3. Minimalistic widget in dark colors.
4. Minimalistic widget in colorful theme.
5. Easy plugin settings.

== Frequently Asked Questions ==

= Does my theme support this plugin? =

Yes! This plugin enqueue additional styles for widgets only if some widgets active. Theme developers can use `add_theme_support ('plugin-currency-converter')` for creating styles manually inside `style.css` file.

= What requests to remote server sends this plugin? =

The plugin makes only one request per hour and caches the result with currencies exchange rates. In requests we only send the data provider name as parameter and that's all.

== Changelog ==

= 0.4.0 =

* Support small currency units in widgets.
* Now widgets correctly work in Theme Customizer.
* Unified prefix in CSS classes.

= 0.3.0 =

* Improved plugin uninstaller.
* Improved context of translations.
* Currencies ISO codes table in plugin settings.

= 0.1.0 =

* Custom update rates link for Central Bank of Russia.
* Enqueue script & styles the right way.
* Code improvements.

= 0.0.0 =

* First release.

== Upgrade Notice ==

= 0.4.0 =

Support WordPress 4.4.2 and Theme Customizer, support small currency units in widgets.

= 0.3.0 =

Improved uninstaller, plugin settings screen and supporting of translations.

= 0.1.0 =

Small fixes and better code inside.

= 0.0.0 =

First release.