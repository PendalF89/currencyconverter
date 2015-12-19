<?php
namespace Korobochkin\Currency\Admin\Settings\General\Pages\General\Sections;

use Korobochkin\Currency\Plugin;

class DataProvider {

	public static function init() {
		self::register_settings();
		self::register_sections();
		self::register_fields();
	}

	public static function register_settings() {
		register_setting(
			Plugin::NAME . 'general',
			\Korobochkin\Currency\Models\Settings\General::$option_name,
			array( __CLASS__, 'sanitize' )
		);
	}

	public static function register_sections() {
		add_settings_section(
			'data_provider',
			__( 'Data provider', Plugin::NAME ),
			array( __CLASS__, 'render' ),
			Plugin::NAME . 'general'
		);
	}

	public static function register_fields() {
		Fields\Provider::register();
	}

	public static function sanitize( $values ) {
		$filtered_values = array();

		if( isset( $values['data_provider_name'] ) ) {
			$providers = \Korobochkin\Currency\Models\DataProviders::getInstance()->get_providers();

			if( array_key_exists( $values['data_provider_name'], $providers ) ) {
				$filtered_values['data_provider_name'] = sanitize_text_field( $values['data_provider_name'] );
			}
		}

		// А если мы накладываем дефолтные настройки, то все равно некоторые значения могут «затереться»

		/**
		 * Идея фикс.
		 * 1) Получаем опции из БД (какие есть).
		 * 2) Мерджим их с дефолтными (тем самым дополняя к бдшным те, что появились в новой версии плагина и т п).
		 * 3) Мерджим отфильтрованные опции с теми, что получили в пункте 2).
		 *
		 * Проблема: если мы не выполняем сохранение настроек, то при обновлении структуры опций есть шанс опять иметь в БД не все дефолтные настройки.
		 */

		// Получаем настройки из бд и добавляем к ним дефолтные
		$current_options = get_option( \Korobochkin\Currency\Models\Settings\General::$option_name, array() );
		$current_options = wp_parse_args( $current_options, \Korobochkin\Currency\Models\Settings\General::get_defaults() );

		// Соединяем дефолотные (и предыдущие) с теми, что были введены сейчас
		$filtered_values = wp_parse_args( $filtered_values, $current_options );

		return $filtered_values;
	}

	public static function render() {
		echo '<p>';
		_e( 'Different data providers may provide different sets of currencies and their prices. We recommend you to select local provider data.',  Plugin::NAME );
		echo '</p>';
	}
}
