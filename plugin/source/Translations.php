<?php
namespace Korobochkin\CurrencyConverter;

class Translations {
	public static function load_translations() {
		load_plugin_textdomain(
			Plugin::NAME,
			false,
			basename(dirname($GLOBALS['CurrencyConverterPlugin']->plugin_path)) . '/languages'
		);
	}
}
