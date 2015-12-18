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
			Plugin::NAME,
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
				// TODO: Надо как-то сразу же обновлять данные в БД для котировок
			}
		}

		return $filtered_values;
	}

	public static function render() {
		echo '<p>';
		_e( 'Different data providers may provide different sets of currencies and their prices. We recommend you to select local provider data.',  Plugin::NAME );
		echo '</p>';
	}
}
