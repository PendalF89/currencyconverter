<?php
namespace Korobochkin\CurrencyConverter\Admin\Pages;

use Korobochkin\CurrencyConverter\Plugin;

class Plugins {
	
	public static function add_action_links( $links ) {
		$add = array(
			sprintf(
				'<a href="%1$s">%2$s</a>',
				esc_url( \Korobochkin\CurrencyConverter\Admin\Settings\General\Pages\General\Page::get_url() ),
				esc_html( __( 'Settings', Plugin::NAME ) )
			)
		);

		return array_merge( $links, $add );
	}
}
