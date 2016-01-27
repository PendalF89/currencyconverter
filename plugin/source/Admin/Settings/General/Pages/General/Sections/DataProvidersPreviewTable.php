<?php
namespace Korobochkin\CurrencyConverter\Admin\Settings\General\Pages\General\Sections;

use Korobochkin\CurrencyConverter\Plugin;

class DataProvidersPreviewTable {

	public static function init() {
		self::register_sections();
	}

	public static function register_sections() {
		add_settings_section(
			'providers_preview_table',
			__( 'Currency codes & countries table' ),
			array( __CLASS__, 'render' ),
			Plugin::NAME . 'general'
		);
	}

	public static function render( $info ) {
		// TODO: Вынести JS и CSS в отдельный файл

		if( ! class_exists( 'WP_List_Table' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
		}
		$table = new \Korobochkin\CurrencyConverter\Admin\Settings\General\Pages\General\Sections\DataProvidersPrevew\Table();
		$table->prepare_items();
		?>
		<p><?php esc_html_e( 'This table shows currencies and their ISO codes which can be used in Widgets.', Plugin::NAME ); ?></p>
		<div class="currencyconverter-currency-codes-countries-table">
			<?php $table->display(); ?>
			<style type="text/css">
				.tablenav {
					display: none;
				}
			</style>
		</div>
		<p>
		<input type="button" class="button button-primary currencyconverter-currency-codes-countries-table-toogler" value="<?php esc_attr_e( 'Show full table', Plugin::NAME ); ?>" data-value-toogle="<?php esc_attr_e( 'Hide full table', Plugin::NAME ); ?>" style="display: none;">
		</p>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('.currencyconverter-currency-codes-countries-table')
					.css('height', 225)
					.css('overflow', 'hidden');

				$('.currencyconverter-currency-codes-countries-table-toogler')
					.css('display', 'block')
					.click(function(e){
						var height = $('.currencyconverter-currency-codes-countries-table').css('height');
						if( height === '300px' ) {
							$('.currencyconverter-currency-codes-countries-table').css('height', 'auto');
						}
						else {
							$('.currencyconverter-currency-codes-countries-table').css('height', 225);
						}

						var temp_val = $(e.target).val();
						$(e.target).val( $(e.target).data('value-toogle') );
						$(e.target).data( 'value-toogle', temp_val );
					});
			}(jQuery));
		</script><?php
	}
}
