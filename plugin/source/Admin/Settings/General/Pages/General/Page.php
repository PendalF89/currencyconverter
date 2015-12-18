<?php
namespace Korobochkin\Currency\Admin\Settings\General\Pages\General;

use Korobochkin\Currency\Plugin;

class Page {

	public static function init() {
		Sections\DataProvider::init();
		Sections\DataProvidersPreview::init();
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
		return admin_url( 'options-general.php?page=currency-general' );
	}

	private static function thanks() {
		?>
		<hr>
		<h2><?php _e( 'Thanks', Plugin::NAME ); ?></h2>
		<p><?php _e( 'Этот плагин использует API и данные о валютах с сайта Open Exchange Rates. Спасибо его создателям.', Plugin::NAME ); ?></p>
		<?php
	}

	public static function update_rates_on_load($some) {
		// Настройки страницы обновляются
		// Значит нужно попробоывать получить ответ от API
		if( !empty( $_GET['settings-updated'] ) && $_GET['settings-updated'] === 'true' ) {
			$is_new_name = get_option( Plugin::NAME );
			\Korobochkin\Currency\Service\UpdateCurrency::update();
		}
	}
}
