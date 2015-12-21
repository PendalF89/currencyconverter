<?php
namespace Korobochkin\CurrencyConverter\Admin\Settings;

class Loader {

	/**
	 * Register all WordPress settings pages.
	 */
	public static function init() {
		add_action( 'admin_menu', array( '\Korobochkin\CurrencyConverter\Admin\Settings\General\Pages', 'register_pages' ) );
		add_action( 'admin_init', array( '\Korobochkin\CurrencyConverter\Admin\Settings\General\Pages\General\Page', 'init' ) );
	}
}
