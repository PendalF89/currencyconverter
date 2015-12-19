<?php
namespace Korobochkin\Currency\Admin\Pages;

use Korobochkin\Currency\Plugin;

class Widgets {

	public static function admin_enqueue_scripts( $hook ) {
		if( 'widgets.php' != $hook ) {
			return;
		}
		wp_enqueue_script( 'plugin-' . Plugin::NAME . '-widgets-currency-table-admin' );
		wp_enqueue_style( 'plugin-' . Plugin::NAME . '-widgets-settings' );
	}
}
