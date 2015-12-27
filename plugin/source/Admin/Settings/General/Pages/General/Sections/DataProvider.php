<?php
namespace Korobochkin\CurrencyConverter\Admin\Settings\General\Pages\General\Sections;

use Korobochkin\CurrencyConverter\Plugin;

class DataProvider {

	public static function init() {
		self::register_settings();
		self::register_sections();
		self::register_fields();
	}

	public static function register_settings() {
		register_setting(
			Plugin::NAME . 'general',
			\Korobochkin\CurrencyConverter\Models\Settings\General::$option_name,
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

	/**
	 * Санитайзинг срабатывает каждый раз, когда вызывается update_option(),
	 * а не только когда сохранются настройки, поэтому надо чистить входные значения,
	 * иначе при update_option() мы затираем настройки (при сохранении приходит лишь 1 значение,
	 * а при update_option() могут прийти все значения.
	 *
	 * Способом, которым мы тут фильтруем, невозможно выкинуть старые настройки — они всегда остаются в опции,
	 * если когда-либо в нее попали.
	 *
	 * @param mixed $values New options.
	 *
	 * @return array New options merged with old (current) options.
	 */
	public static function sanitize( $values ) {
		/**
		 * Идея фикс.
		 * 1) Получаем опции из БД (какие есть).
		 * 2) Мерджим их с дефолтными (тем самым дополняя к бдшным те, что появились в новой версии плагина и т п).
		 * 3) Мерджим отфильтрованные опции с теми, что получили в пункте 2).
		 *
		 * Проблема: если мы не выполняем сохранение настроек, то при обновлении структуры опций есть шанс опять иметь в БД не все дефолтные настройки.
		 */

		// Получаем настройки из бд и добавляем к ним дефолтные
		$current_options = get_option( \Korobochkin\CurrencyConverter\Models\Settings\General::$option_name, array() );
		$current_options = wp_parse_args( $current_options, \Korobochkin\CurrencyConverter\Models\Settings\General::get_defaults() );

		if( isset( $values['data_provider_name'] ) ) {
			$providers = \Korobochkin\CurrencyConverter\Models\DataProviders::getInstance()->get_providers();

			if( !array_key_exists( $values['data_provider_name'], $providers ) ) {
				$values['data_provider_name'] = $current_options['data_provider_name'];
				//$filtered_values['data_provider_name'] = sanitize_text_field( $values['data_provider_name'] );
			}
		}

		// Соединяем дефолотные + текущие с теми, что были введены сейчас
		$values = wp_parse_args( $values, $current_options );

		return $values;
	}

	public static function render() {
		echo '<p>';
		_e( 'Different data providers may provide different sets of currencies and their prices. We recommend you select local data provider.',  Plugin::NAME );
		echo '</p>';
	}
}
