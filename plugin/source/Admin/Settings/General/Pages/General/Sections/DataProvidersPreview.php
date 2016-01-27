<?php
namespace Korobochkin\CurrencyConverter\Admin\Settings\General\Pages\General\Sections;

use Korobochkin\CurrencyConverter\API\API;
use Korobochkin\CurrencyConverter\Plugin;

class DataProvidersPreview {

	public static function init() {
		//self::register_settings();
		self::register_sections();
		//self::register_fields();
	}

	public static function register_sections() {
		$providers = \Korobochkin\CurrencyConverter\Models\DataProviders::getInstance()->get_providers();

		foreach( $providers as $provider_name => $provider ) {
			if( !$provider['active'] ) {
				continue;
			}
			$provider_title_section = '';
			if( !empty( $provider['homepage'] ) ) {
				$provider_title_section = sprintf( '<a href="%1$s" target="_blank">%2$s</a>', esc_url($provider['homepage']), esc_html( $provider['name'] ) );
			}
			else {
				$provider_title_section = esc_html( $provider['name'] );
			}
			add_settings_section(
				$provider_name,
				$provider_title_section,
				array( __CLASS__, 'render' ),
				Plugin::NAME . 'general'
			);
		}
	}

	public static function render( $info ) {
		$providers_previews = \Korobochkin\CurrencyConverter\Models\DataProviders::getInstance()->get_providers_preview();

		if( $providers_previews[$info['id']]['status'] === 'ok' ) {
			echo '<p>'
				. sprintf(
					/* translators: Description of the data provider with status code OK that means that provider are available and ready to use. %1$s - status code title (basically is "OK"). %2$s - the number represents available currencies. After the colon at the end will be shown a list of available currencies. */
					__( 'Status: <code>%1$s</code>. The number of currencies: %2$s. Available currencies:', Plugin::NAME ),
					/* translators: Data provider status code. "OK" means that the provider are available and ready to use. */
					__( 'OK', Plugin::NAME ),
					count( $providers_previews[$info['id']]['currencies'] )
				)
				. '</p>';

			echo '<p><code>' . implode( '</code>, <code>', $providers_previews[$info['id']]['currencies'] ) . '</code>.</p>';
		}
		else {
			echo '<p>'
				. sprintf(
					/* translators: Description of the data provider with status code FAILED that means that provider are not available and something happens when WordPress tried to fetch currency rates from this provider. %1$s - status code title (basically is "FAILED"). After the colon at the end will be shown a list of errors. */
					__( 'Status: <code>%1$s</code>. Error message(s):', Plugin::NAME ),
					/* translators: Data provider status code. "FAILED" means that the provider are not available. */
					__( 'FAILED', Plugin::NAME )
				)
				. '</p>';
			echo '<ol><li>'
				. implode( '</li><li>', $providers_previews[$info['id']]['errors'] )
				. '</li></ol>';
		}
	}
}
