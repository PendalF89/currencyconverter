<?php
namespace Korobochkin\Currency\Admin;

class Admin {

	public static function run() {
		/**
		 * Scripts for /wp-admin/widgets.php page
		 */
		add_action( 'admin_enqueue_scripts', array( '\Korobochkin\Currency\Admin\Pages\Widgets', 'admin_enqueue_scripts' ) );

		Settings\Loader::init();

		add_filter( 'plugin_action_links_' . plugin_basename( $GLOBALS['CurrencyPlugin']->plugin_path ), array( '\Korobochkin\Currency\Admin\Pages\Plugins', 'add_action_links' ) );
	}
}
