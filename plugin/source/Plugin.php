<?php
namespace Korobochkin\CurrencyConverter;

class Plugin {

	const NAME = 'currencyconverter';

	public $plugin_path = NULL;

	public function __construct( $run_from_file ) {
		$this->plugin_path = $run_from_file;
	}

	public function run() {
		add_action( 'plugins_loaded', array( 'Korobochkin\CurrencyConverter\Translations', 'load_translations' ) );

		/**
		 * Register Script & Styles
		 */
		add_action( 'wp_enqueue_scripts', array( '\Korobochkin\CurrencyConverter\Service\ScriptStyles', 'register' ) );

		/**
		 * Update currency action.
		 */
		add_action(
			\Korobochkin\CurrencyConverter\Plugin::NAME . \Korobochkin\CurrencyConverter\Cron\UpdateCurrency::$action_name,
			array( '\Korobochkin\CurrencyConverter\Service\UpdateCurrency', 'update' )
		);

		add_action( 'widgets_init', array( '\Korobochkin\CurrencyConverter\Widgets\RegisterWidgets', 'register' ) );

		if ( is_admin() ) {
			\Korobochkin\CurrencyConverter\Admin\Admin::run();
		}
	}
}
