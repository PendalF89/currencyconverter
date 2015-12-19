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
		$providers_previews = \Korobochkin\Currency\Models\DataProviders::getInstance()->get_providers_preview();

		if( $providers_previews[$info['id']]['status'] === 'ok' ) {
			//$status_title = _x( 'ok', 'Data provider status code.', Plugin::NAME );
			?><p><?php
			_ex( 'Status: <code>OK</code>. Available currencies:', 'Description of the data provider with status code OK that means that provider are available and ready to use.', Plugin::NAME );
			?></p>
			<p><?php echo '<p><code>' . implode( '</code>, <code>', $providers_previews[$info['id']]['currencies'] ) . '</code>.</p>';  ?></p>
			<?php
		}
		else {
			?><p><?php
			_ex( 'Status: <code>FAILED</code>. Error message(s):', 'Description of the data provider with status code FAILED that means that provider are not available and something happens when WordPress tried to fetch currency rates from this provider.', Plugin::NAME );
			?></p>
			<ol>
				<?php foreach( $providers_previews[$info['id']]['errors'] as $error ) {
					echo '<li>' . esc_html( $error ) . '</li>';
				} ?>
			</ol>
			<?php
		}
	}
}
