<?php
namespace Korobochkin\Currency\Admin\Pages;

use Korobochkin\Currency\Plugin;

class Widgets {

	public static function admin_enqueue_scripts( $hook ) {
		if( 'widgets.php' != $hook ) {
			return;
		}
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script(
			'plugin__currency__currency-table__admin',
			plugin_dir_url( $GLOBALS['CurrencyPlugin']->plugin_path ) . 'source/Widgets/CurrencyTable/admin-page-autocomplete.js',
			array( 'jquery' ),
			'0.0.0',
			true
		);
	}
}
