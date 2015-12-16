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
			?>
		</form>
		</div><?php
	}

	public static function get_url() {
		return admin_url( 'options-general.php?page=currency-general' );
	}
}
