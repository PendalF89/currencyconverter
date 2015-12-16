<?php
namespace Korobochkin\Currency\Admin\Pages;

use Korobochkin\Currency\Plugin;

class Plugins {
	public static function add_action_links( $links ) {
		return array_merge( $links, array(
			'<a href="' . \Korobochkin\Currency\Admin\Settings\General\Pages\General\Page::get_url() . '">' . __( 'Settings', Plugin::NAME ) . '</a>'
		) );
	}
}
