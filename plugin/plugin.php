<?php
namespace Korobochkin\CurrencyConverter;
/*
Plugin Name: CurrencyConverter
Plugin URI: https://wordpress.org/plugins/currencyconverter/
Description: Currency widgets for any needs.
Author: LB company
Author URI: http://exchangerate.guru
Version: 0.1.0
Text Domain: currencyconverter
Domain Path: /languages/
Requires at least: 4.0.0
Tested up to: 4.4.0
License: GPLv2 or later
*/

/**
 * Autoloader for all classes.
 *
 * @since 0.0.0
 */
require_once 'vendor/autoload.php';
$GLOBALS['CurrencyConverterPlugin'] = new Plugin( __FILE__ );
$GLOBALS['CurrencyConverterPlugin']->run();

/**
 * Activation process. Running only once.
 */
register_activation_hook( __FILE__, array( '\Korobochkin\CurrencyConverter\Activation', 'run' ) );

//\Korobochkin\Currency\Service\UpdateCurrency::update();
