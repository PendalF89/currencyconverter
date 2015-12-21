<?php
namespace Korobochkin\CurrencyConverter\Admin\Settings\General;

use Korobochkin\CurrencyConverter\Plugin;

class Pages {

	/**
	 * Register pages in General menu section.
	 */
	public static function register_pages() {
		// General Settings
		add_submenu_page(
			'options-general.php',
			__( 'Currency', Plugin::NAME ),
			__( 'Currency', Plugin::NAME ),
			'manage_options',
			Plugin::NAME . '-general',
			array( '\Korobochkin\CurrencyConverter\Admin\Settings\General\Pages\General\Page', 'render' )
		);
	}
}
