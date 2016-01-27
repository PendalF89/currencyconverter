<?php
namespace Korobochkin\CurrencyConverter\Admin\Settings\General\Pages\General\Sections;

use HtmlTableGenerator\Table;
use Korobochkin\CurrencyConverter\Models\Country;
use Korobochkin\CurrencyConverter\Plugin;

class DataProvidersPreviewTable {

	public static function init() {
		self::register_sections();
	}

	public static function register_sections() {
		add_settings_section(
			'providers_preview_table',
			__( 'Currency codes', Plugin::NAME ),
			array( __CLASS__, 'render' ),
			Plugin::NAME . 'general'
		);
	}

	public static function render( $info ) {
		// TODO: Вынести JS и CSS в отдельный файл

		$table = new Table();

		$table->set_heading( array(
			__( 'Country flag', Plugin::NAME ),
			__( 'Currency ISO code', Plugin::NAME ),
			__( 'Currency', Plugin::NAME ),
			__( 'Country', Plugin::NAME )
		) );

		$table_raw_values = \Korobochkin\CurrencyConverter\Models\Currencies\Currencies::get_currencies_as_numeric_array();

		$country = new Country();

		foreach( $table_raw_values as $key => $value ) {
			$country->set_country_by_currency( $value['currency_iso'] );

			$flag = $country->get_flag_url( 32 );
			$flag = '<img src="' . esc_url( $flag ) . '">';
			$value['flag'] = $flag;

			$table_raw_values[$key] = array(
				$value['flag'],
				'<code>' . esc_html( $value['currency_iso'] ) . '</code>',
				esc_html( $value['currency_name'] ),
				esc_html( $value['country_name'] )
			);
		}

		$table->_set_from_array( $table_raw_values );

		?>
		<p><?php esc_html_e( 'This table shows currencies and their ISO codes which can be used in Widgets.', Plugin::NAME ); ?></p>
		<div class="currencyconverter-currency-codes-countries-table">
			<?php echo $table->generate(); ?>
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
						e.preventDefault();
						var height = $('.currencyconverter-currency-codes-countries-table').css('height');
						if( height === '225px' ) {
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
