<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* translators: %1$s - url to homepage with base currency. %2$s - base currency ticker (ISO code). %3$s - date of update currency rate in regional format (only month, date and year available right now). Available date variables - http://php.net/manual/en/function.date.php. */
__( 'Currency exchange rates in <a href="%1$s" class="currencyconverter-base-currency-link">%2$s</a> on %3$s', 'currencyconverter' );
