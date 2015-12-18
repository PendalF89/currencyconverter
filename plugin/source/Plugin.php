<?php
namespace Korobochkin\Currency;

class Plugin {

	const NAME = 'currency';

	public $plugin_path = NULL;

	public function __construct( $run_from_file ) {
		$this->plugin_path = $run_from_file;
	}

	public function run() {
		add_action( 'plugins_loaded', array( 'Korobochkin\Currency\Translations', 'load_translations' ) );

		/**
		 * Update currency action.
		 */
		add_action(
			\Korobochkin\Currency\Plugin::NAME . \Korobochkin\Currency\Cron\UpdateCurrency::$action_name,
			array( '\Korobochkin\Currency\Service\UpdateCurrency', 'update' )
		);

		add_action( 'widgets_init', array( '\Korobochkin\Currency\Widgets\RegisterWidgets', 'register' ) );

		if ( is_admin() ) {
			\Korobochkin\Currency\Admin\Admin::run();
		}
	}
}
