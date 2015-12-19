<?php
namespace Korobochkin\Currency;

class Activation {
	function run() {
		/**
		 * Cron task for update currency rates each hour.
		 */
		Cron\UpdateCurrency::register_task();

		/**
		 * Надо сразу попытаться загрузить цены для дефолтного поставщика данных.
		 */
		Service\UpdateCurrency::update();
	}
}
