<?php
namespace Korobochkin\Currency\Service;

use Korobochkin\Currency\Plugin;

class ScriptStyles {

	public static function register() {
		wp_register_style(
			'plugin-' . Plugin::NAME . '-widgets',
			plugin_dir_url( $GLOBALS['CurrencyPlugin']->plugin_path ) . 'styles/widgets/main.css',
			array(),
			'0.0.0'
		);
	}
}
