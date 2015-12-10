<?php
namespace Korobochkin\Currency\Cron;

class UpdateCurrency {
	public static function register_task() {
		wp_schedule_event( time(), 'hourly', \Korobochkin\Currency\Plugin::NAME . '_update_currency' );
	}
}
