<?php
namespace Korobochkin\Currency\Admin\Pages;

class Widgets {

	public static function admin_enqueue_scripts( $hook ) {
		if( 'widgets.php' != $hook ) {
			return;
		}
		wp_enqueue_script( 'jquery-ui-autocomplete' );
	}
}
