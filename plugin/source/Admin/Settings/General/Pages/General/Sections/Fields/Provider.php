<?php
namespace Korobochkin\CurrencyConverter\Admin\Settings\General\Pages\General\Sections\Fields;

use \Korobochkin\CurrencyConverter\Plugin;

class Provider {

	public static function register() {
		add_settings_field(
			'data_provider_name',
			__( 'Provider', Plugin::NAME ),
			array( __CLASS__, 'render' ),
			Plugin::NAME . 'general',
			'data_provider',
			array(
				'label_for' => Plugin::NAME . '__[data_provider_name]'
			)
		);
	}

	public static function render() {
		$options = get_option( \Korobochkin\CurrencyConverter\Models\Settings\General::$option_name, array() );
		$options = wp_parse_args( $options, \Korobochkin\CurrencyConverter\Models\Settings\General::get_defaults() );

		$providersObj = \Korobochkin\CurrencyConverter\Models\DataProviders::getInstance();
		$providers = $providersObj->get_providers();
		?>
		<select id="<?php echo Plugin::NAME; ?>__[data_provider_name]" name="<?php echo Plugin::NAME; ?>[data_provider_name]">
			<?php
			foreach( $providers as $provider ) {
				printf(
					'<option value="%1$s" %2$s %3$s>%4$s</option>',
					esc_attr( $provider['abbreviated_name'] ),
					selected( $provider['abbreviated_name'], $options['data_provider_name'], false ),
					disabled( $provider['active'], false, false ),
					esc_html( $provider['name'] )
				);
			}
			?>
		</select>
		<?php
	}
}
