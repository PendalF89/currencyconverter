<?php
namespace Korobochkin\CurrencyConverter\Cron;

class UpdateCurrency {

	public static $action_name = '_update_currency';

	public static function register_task() {
		wp_schedule_event( time(), 'hourly', \Korobochkin\CurrencyConverter\Plugin::NAME . self::$action_name );
	}
}
