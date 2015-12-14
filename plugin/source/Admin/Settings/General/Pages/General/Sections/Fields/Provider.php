<?php
namespace Korobochkin\Currency\Admin\Settings\General\Pages\General\Sections\Fields;

use \Korobochkin\Currency\Plugin;

class Provider {

	public static function register() {
		add_settings_field(
			'provider_name',
			__( 'Provider', Plugin::NAME ),
			array( __CLASS__, 'render' ),
			Plugin::NAME . 'general',
			'data_provider',
			array(
				'label_for' => Plugin::NAME . '__[provider_name]'
			)
		);
	}

	public static function render() {
		$options = get_option( Plugin::NAME );
		?>
		<input id="<?php echo Plugin::NAME; ?>__[provider_name]" name="<?php echo Plugin::NAME; ?>[provider_name]" value="<?php echo esc_attr( $options['provider_name'] ); ?>" type="text" class="regular-text" autocomplete="off">
		<?php
	}
}
