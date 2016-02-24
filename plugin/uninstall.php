<?php
namespace Korobochkin\CurrencyConverter;

// If uninstall is not called from WordPress, exit
if( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

/**
 * Autoloader for all classes.
 *
 * @since 0.0.0
 */
require_once 'vendor/autoload.php';

delete_option( \Korobochkin\CurrencyConverter\Models\Settings\General::$option_name );

// TODO: Maybe delete this option by name from variable, not directly by name.
delete_option( \Korobochkin\CurrencyConverter\Plugin::NAME . '_rates' );

delete_transient( \Korobochkin\CurrencyConverter\Models\DataProviders::getInstance()->get_transient_name() );

wp_clear_scheduled_hook( \Korobochkin\CurrencyConverter\Plugin::NAME . \Korobochkin\CurrencyConverter\Cron\UpdateCurrency::$action_name );
