<?php
namespace Korobochkin\CurrencyConverter\Admin\Service;

use Korobochkin\CurrencyConverter\Plugin;

class ScriptStyles {

	public static function register() {
		wp_register_style(
			'plugin-' . Plugin::NAME . '-widgets-settings',
			plugin_dir_url( $GLOBALS['CurrencyConverterPlugin']->plugin_path ) . 'styles/widgets-backend/main.css',
			array(),
			'0.0.0'
		);

		wp_register_script(
			'plugin-' . Plugin::NAME . '-widgets-currency-table-admin',
			plugin_dir_url( $GLOBALS['CurrencyConverterPlugin']->plugin_path ) . 'source/Widgets/CurrencyTable/admin-page-autocomplete.js',
			array( 'jquery-ui-autocomplete' ),
			'0.0.0',
			true
		);
	}
}
