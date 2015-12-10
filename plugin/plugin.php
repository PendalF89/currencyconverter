<?php
namespace Korobochkin\Currency;
/*
Plugin Name: Currency
Plugin URI: http://pokur.su/
Description: Currency widgets for any needs.
Author: Kolya Korobochkin
Author URI: http://korobochkin.com/
Version: 0.0.0
Text Domain: currency
Domain Path: /languages/
Requires at least: 4.4.0
Tested up to: 4.4.0
License: GPLv2 or later
*/

/**
 * Autoloader for all classes.
 *
 * @since 0.0.0
 */
require_once 'vendor/autoload.php';
$GLOBALS['CurrencyPlugin'] = new Plugin( __FILE__ );
$GLOBALS['CurrencyPlugin']->run();

/**
 * Activation process. Running only once.
 */
register_activation_hook( __FILE__, array( '\Korobochkin\Currency\Activation', 'run' ) );
