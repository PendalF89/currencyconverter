<?php
namespace Korobochkin\Currency;

class Plugin {

	const NAME = 'currency';

	public $plugin_path = NULL;

	public function __construct( $run_from_file ) {
		$this->plugin_path = dirname( plugin_basename( $run_from_file ) );
	}

	public function run() {
		register_activation_hook( $this->plugin_path, array( '\Korobochkin\Currency\Activation', 'run' ) );

		add_action( 'plugins_loaded', array( 'Korobochkin\Currency\Translations', 'load_translations' ) );

		if ( is_admin() ) {

		}
	}
}
