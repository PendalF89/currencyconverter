<?php
namespace Korobochkin\CurrencyConverter\Admin\Pages;

use Korobochkin\CurrencyConverter\Plugin;

class Plugins {
	public static function add_action_links( $links ) {
		return array_merge( $links, array(
			'<a href="' . \Korobochkin\CurrencyConverter\Admin\Settings\General\Pages\General\Page::get_url() . '">' . __( 'Settings', Plugin::NAME ) . '</a>'
		) );
	}
}
