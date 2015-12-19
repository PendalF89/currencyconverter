<?php
namespace Korobochkin\Currency\Widgets\CurrencyMinimalistic;

use Korobochkin\Currency\Plugin;

class Widget extends \WP_Widget {

	public function __construct() {
		parent::__construct(
			'currency_minimalistic',
			__( 'Currency Minimalistic', Plugin::NAME ),
			array(
				'classname' => 'widget_currency_minimalistic',
				'description' => __( 'Light minimalistic widget with solid and clean colors and gradients.', Plugin::NAME )
			)
		);

		// Enqueue styles if theme don't support our plugin and widget is active.
		if( !current_theme_supports( 'plugin-' . Plugin::NAME ) && is_active_widget( false, false, $this->id_base ) ) {
			wp_enqueue_style( 'plugin-' . Plugin::NAME . '-widgets' );
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $this->_merge_instance_with_default_instance( $new_instance );

		// Basic stuff
		$instance_to_save['title'] = sanitize_text_field( $instance['title'] );

		$instance_to_save['base_currency'] = strtoupper( sanitize_text_field( $instance['base_currency'] ) );

		// Вероятно, это надо сохранять в виде массива
		$instance_to_save['currency_list'] = strtoupper( sanitize_text_field( $instance['currency_list'] ) );

		/**
		 * Сохраняя лишь нужные переменные,
		 * мы убираем возможность (дырку) запихнуть что-либо ненужное в БД
		 */
		return $instance_to_save;
	}

	public function form( $instance ) {
		static $first = true;

		$currency = new Currency('USD', 'USD');
		if( !$currency->is_available() ) {
			?><p><?php printf( __( 'Select data provider in <a href="%1$s">plugin settings</a>.', Plugin::NAME ), esc_url( \Korobochkin\Currency\Admin\Settings\General\Pages\General\Page::get_url() ) ); ?></p><?php
			return;
		}
		unset( $currency );

		$instance = $this->_merge_instance_with_default_instance($instance);
		$rates = get_option( \Korobochkin\Currency\Plugin::NAME . '_rates' );

		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', Plugin::NAME ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"></p>

		<p><label for="<?php echo $this->get_field_id( 'base_currency' ); ?>"><?php _e( 'Base currency:', Plugin::NAME ); ?></label>
			<select class="widefat plugin__currency__select-autocomplete" id="<?php echo $this->get_field_id( 'base_currency' ); ?>" name="<?php echo $this->get_field_name( 'base_currency' ); ?>">
				<?php
				foreach( $rates[0]['rates'] as $key => $value ) {
					printf(
						'<option value="%s"%s>%s</option>',
						esc_attr( $key ),
						selected( $key , $instance['base_currency'], false ),
						esc_html( $key )
					);
				}
				?>
			</select>
		</p>
		<p class="description"><?php _e( 'The currency in which will be settled other currencies.', Plugin::NAME ); ?></p>

		<p><label for="<?php echo $this->get_field_id( 'currency_list' ); ?>"><?php _e( 'Currencies list:', Plugin::NAME ); ?></label>
			<input class="widefat plugin__currency__autocomplete" id="<?php echo $this->get_field_id( 'currency_list' ); ?>" name="<?php echo $this->get_field_name( 'currency_list' ); ?>" type="text" value="<?php echo esc_attr( $instance['currency_list'] ); ?>"></p>
		<p class="description"><?php _e( 'The currencies which will be displayed in table. Separate by commas.', Plugin::NAME ); ?></p>

		<script type="text/javascript">
			<?php
			if( !$first ) {
				$tickers = array();
				foreach( $rates[0]['rates'] as $key => $value ) {
					$tickers[] = $key;
				}
				/**
				 * TODO: Использовать wp_json_encode(), если решим поддерживать совместимость с версии больше 4.1.0
                 * Делать экранизацию не нужно, потому что см. https://codex.wordpress.org/Function_Reference/esc_js
                 */
				echo 'var currenciesTickersList =' . json_encode( $tickers ) . ';';
			}
			?>
		</script>

		<h3><?php _e( 'Background color', Plugin::NAME ); ?></h3>

		<p>
			<label for="<?php echo $this->get_field_id( 'table_headers_currencies' ); ?>"><?php _e( 'Currencies names col:', Plugin::NAME ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'table_headers_currencies' ); ?>" name="<?php echo $this->get_field_name( 'table_headers_currencies' ); ?>" type="text" value="<?php echo esc_attr( $instance['table_headers_currencies'] ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'table_headers_price' ); ?>"><?php _e( 'Price col:', Plugin::NAME ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'table_headers_price' ); ?>" name="<?php echo $this->get_field_name( 'table_headers_price' ); ?>" type="text" value="<?php echo esc_attr( $instance['table_headers_price'] ); ?>">
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'table_headers_change' ); ?>"><?php _e( 'Change col:', Plugin::NAME ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'table_headers_change' ); ?>" name="<?php echo $this->get_field_name( 'table_headers_change' ); ?>" type="text" value="<?php echo esc_attr( $instance['table_headers_change'] ); ?>">
		</p>
		<?php
		$first = false;
	}

	private function _merge_instance_with_default_instance( $instance ) {
		$def_settings = array(
			'title' => __( 'Currency exchange rate', Plugin::NAME ),
			'base_currency' => __( 'USD', Plugin::NAME ),
			'currency_list' => _x( 'CAD, AUD, GBP', 'WARNING: always use commas as separator', Plugin::NAME ),
			'bg_colorscheme' => '',
			'bg_color_1' => 'ffa200',
			'bg_color_2' => 'ff5a00'
		);
		return wp_parse_args($instance, $def_settings);
	}
}
