<?php
namespace Korobochkin\CurrencyConverter\Admin\Pages;

class Customizer {

	public static function enqueue_scripts() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}
}
