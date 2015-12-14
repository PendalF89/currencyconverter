<?php
namespace Korobochkin\Currency\Admin\Settings;

class Loader {

	/**
	 * Register all WordPress settings pages.
	 */
	public static function init() {
		add_action( 'admin_menu', array( '\Korobochkin\Currency\Admin\Settings\General\Pages', 'register_pages' ) );
		//add_action( 'admin_init', array( '\Korobochkin\Memories\Admin\Settings\General\Sections\Keys', 'init' ) );
	}
}
