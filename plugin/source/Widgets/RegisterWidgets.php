<?php
namespace Korobochkin\Currency\Widgets;

class RegisterWidgets {
	public static function register() {
		register_widget( 'Korobochkin\Currency\Widgets\CurrencyTable\Currency_Table' );
	}
}
