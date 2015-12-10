<?php
namespace Korobochkin\Currency\Cron;

class UpdateCurrency {

	public static $action_name = '_update_currency';

	public static function register_task() {
		wp_schedule_event( time(), 'hourly', \Korobochkin\Currency\Plugin::NAME . self::$action_name );
	}
}
