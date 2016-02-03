<?php
namespace Korobochkin\CurrencyConverter\Admin;

use Korobochkin\CurrencyConverter\Plugin;

class Admin {

	public static function run() {
		// Register all scripts & styles
		add_action( 'admin_enqueue_scripts', array( '\Korobochkin\CurrencyConverter\Admin\Service\ScriptStyles', 'register' ) );

		/**
		 * Scripts for /wp-admin/widgets.php page
		 */
		add_action( 'admin_enqueue_scripts', array( '\Korobochkin\CurrencyConverter\Admin\Pages\Widgets', 'admin_enqueue_scripts' ) );

		add_action( 'customize_controls_enqueue_scripts', array( '\Korobochkin\CurrencyConverter\Admin\Pages\Customizer', 'enqueue_scripts' ) );


		/**
		 * Инлайн JS наше все. Если пихать JS внешним файлом, то он почему-то не работает!!!!1111
		 */
		//add_action( 'customize_controls_enqueue_scripts', array( '\Korobochkin\CurrencyConverter\Admin\Pages\Widgets', 'admin_enqueue_scripts' ) );

		add_action( 'load-settings_page_' . Plugin::NAME .'-general', array( '\Korobochkin\CurrencyConverter\Admin\Settings\General\Pages\General\Page', 'update_rates_on_load' ) );

		Settings\Loader::init();

		add_filter( 'plugin_action_links_' . plugin_basename( $GLOBALS['CurrencyConverterPlugin']->plugin_path ), array( '\Korobochkin\CurrencyConverter\Admin\Pages\Plugins', 'add_action_links' ) );
	}
}
