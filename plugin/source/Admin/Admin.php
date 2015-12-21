<?php
namespace Korobochkin\CurrencyConverter\Admin;

use Korobochkin\CurrencyConverter\Plugin;

class Admin {

	public static function run() {
		// Register all scripts & styles
		Service\ScriptStyles::register();

		/**
		 * Scripts for /wp-admin/widgets.php page
		 */
		add_action( 'admin_enqueue_scripts', array( '\Korobochkin\CurrencyConverter\Admin\Pages\Widgets', 'admin_enqueue_scripts' ) );

		add_action( 'load-settings_page_' . Plugin::NAME .'-general', array( '\Korobochkin\CurrencyConverter\Admin\Settings\General\Pages\General\Page', 'update_rates_on_load' ) );

		Settings\Loader::init();

		add_filter( 'plugin_action_links_' . plugin_basename( $GLOBALS['CurrencyConverterPlugin']->plugin_path ), array( '\Korobochkin\CurrencyConverter\Admin\Pages\Plugins', 'add_action_links' ) );
	}
}
