<?php
namespace Korobochkin\Currency;

class Translations {
	public static function load_translations() {
		load_plugin_textdomain(
			Plugin::NAME,
			false,
			$GLOBALS['CurrencyPlugin']->plugin_path . '/languages'
		);
	}
}
