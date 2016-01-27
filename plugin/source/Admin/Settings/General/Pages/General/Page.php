<?php
namespace Korobochkin\CurrencyConverter\Admin\Settings\General\Pages\General;

use Korobochkin\CurrencyConverter\Plugin;

class Page {

	public static function init() {
		Sections\DataProvider::init();
		Sections\DataProvidersPreview::init();
		Sections\DataProvidersPreviewTable::init();
	}

	public static function render() {
		?><div class="wrap">
		<h2><?php _e( 'Currency', Plugin::NAME ) ?></h2>
		<form action="options.php" method="post">
			<?php
			settings_fields( Plugin::NAME . 'general' );
			do_settings_sections( Plugin::NAME . 'general' );
			submit_button();
			self::thanks();
			?>
		</form>
		</div><?php
	}

	public static function get_url() {
		return admin_url( 'options-general.php?page='. Plugin::NAME . '-general' );
	}

	private static function thanks() {
		?>
		<hr>
		<h2><?php _e( 'Thanks', Plugin::NAME ); ?></h2>
		<?php
		echo wpautop(
		__(
'Currency exchange rates: <a href="https://openexchangerates.org/" target="_blank">Open Exchange Rates</a>, <a href="http://www.cbr.ru/">Central Bank of Russia</a>.

<a href="https://github.com/gosquared/flags" target="_blank">Countries flags</a> by GoSquared.

Plugin created by <a href="http://exchangerate.guru/" target="_blank">exchangerate.guru</a>.', Plugin::NAME )
		); ?>
		<?php
	}

	public static function update_rates_on_load($some) {
		// Настройки страницы обновляются
		// Значит нужно попробоывать получить ответ от API
		if( !empty( $_GET['settings-updated'] ) && $_GET['settings-updated'] === 'true' ) {
			\Korobochkin\CurrencyConverter\Service\UpdateCurrency::update();
		}
	}
}
