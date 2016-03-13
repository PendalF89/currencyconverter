<?php
namespace Korobochkin\CurrencyConverter\Widgets;

class RegisterWidgets {
	public static function register() {
		register_widget( '\Korobochkin\CurrencyConverter\Widgets\CurrencyTable\Currency_Table' );
		register_widget( '\Korobochkin\CurrencyConverter\Widgets\CurrencyMinimalistic\Widget' );
		register_widget( '\Korobochkin\CurrencyConverter\Widgets\CurrencyMinimalistic2\Widget' );
	}
}
