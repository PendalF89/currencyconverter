<?php
namespace Korobochkin\CurrencyConverter\Admin\Service;

use Korobochkin\CurrencyConverter\Plugin;

class ScriptStyles {

	public static function register() {
		wp_register_style(
			'plugin-' . Plugin::NAME . '-widgets-settings',
			plugin_dir_url( $GLOBALS['CurrencyConverterPlugin']->plugin_path ) . 'styles/backend/backend.css',
			array(),
			'0.5.1'
		);

		wp_register_script(
			'plugin-' . Plugin::NAME . '-widgets-currency-table-admin',
			plugin_dir_url( $GLOBALS['CurrencyConverterPlugin']->plugin_path ) . 'source/Widgets/CurrencyTable/admin-page-autocomplete.js',
			array( 'jquery-ui-autocomplete' ),
			'0.5.1',
			true
		);

		wp_register_script(
			'plugin-' . Plugin::NAME . '-widgets-currency-minimalistic-settings',
			plugin_dir_url( $GLOBALS['CurrencyConverterPlugin']->plugin_path ) . 'scripts/widgets/CurrencyMinimalistic/settings.min.js',
			array( 'jquery', 'iris' ),
			'0.5.1',
			true
		);
	}
}
