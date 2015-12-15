<?php
namespace Korobochkin\Currency\Admin\Settings\General\Pages\General\Sections;

use Korobochkin\Currency\API\API;
use Korobochkin\Currency\Plugin;

class DataProvidersPreview {

	public static function init() {
		//self::register_settings();
		self::register_sections();
		//self::register_fields();
	}

	public static function register_sections() {
		$providers = \Korobochkin\Currency\Models\DataProviders::getInstance()->get_providers();

		foreach( $providers as $provider_name => $provider ) {
			if( !$provider['active'] ) {
				continue;
			}
			add_settings_section(
				$provider_name,
				$provider['name'],
				array( __CLASS__, 'render' ),
				Plugin::NAME . 'general'
			);
		}
	}

	public static function render( $info ) {
		$providers = \Korobochkin\Currency\Models\DataProviders::getInstance()->get_providers();
		if( !empty( $providers[$info['id']]['homepage'] ) ) {
			printf(
				'<p><a href="%1$s">%2$s</a></p>',
				esc_url( $providers[$info['id']]['homepage'] ),
				__( 'The official site of the provider', Plugin::NAME )
			);
		}

		// TODO: Тупейший механизм внутри. Надо переписать.

		$provider_currencies = get_transient( Plugin::NAME . '_provider_rates_' . $info['id'] );

		if( !$provider_currencies ) {

			$api = new API($providers[$info['id']]);
			$rates = $api->get_rates();

			if( is_wp_error( $rates ) ) {
				$error_messages = $rates->get_error_messages();
				?>
				<p><?php _e( 'Status: failed. Error message:', Plugin::NAME ); ?></p>
				<ol>
					<?php foreach( $error_messages as $error ) {
						echo '<li>' . esc_html($error) . '</li>';
					} ?>
				</ol>
				<?php
				return;
			}
			else {
				$prepare_transient = array();
				foreach( $rates[0]['rates'] as $rate_ticker => $rate_value ) {
					$prepare_transient[] = $rate_ticker;
				}
				$provider_currencies = $prepare_transient;
				set_transient( Plugin::NAME . '_provider_rates_' . $info['id'], $prepare_transient, 24 * HOUR_IN_SECONDS );
			}
		}

		if( $provider_currencies ) {
			?><p><?php _e( 'Status: ok. Available currencies:', Plugin::NAME ); ?></p><?php
			echo '<p><code>' . implode( '</code>, <code>', $provider_currencies ) . '</code>.</p>';
		}
	}
}
