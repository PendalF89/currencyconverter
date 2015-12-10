<?php
namespace Korobochkin\Currency;

class Activation {
	function run() {
		/**
		 * Update currency rates each hour.
		 */
		Cron\UpdateCurrency::register_task();
	}
}
