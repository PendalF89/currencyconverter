<?php
namespace Korobochkin\CurrencyConverter\Widgets\CurrencyTable;

use Korobochkin\CurrencyConverter\Models\Currency;
use Korobochkin\CurrencyConverter\Models\PluginDeveloper;
use Korobochkin\CurrencyConverter\Plugin;

class Currency_Table extends \WP_Widget {

	public function __construct() {
		parent::__construct(
			'currencyconverter_table',
			__( 'Currency Converter. Table', Plugin::NAME ),
			array(
				'classname' => 'widget_currencyconverter_table',
				'description' => __( 'A table with currency rates.', Plugin::NAME )
			)
		);

		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_script_style' ) );
	}

	public function widget( $args, $instance ) {
		$instance = $this->_merge_instance_with_default_instance($instance);
		echo $args['before_widget'];

		/**
		 * Title
		 */
		$title = apply_filters(
			'widget_title',
			empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base
		);
		if( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		/**
		 * Table
		 */
		if( !empty( $instance['currency_list'] ) ) {
			$instance['currency_list'] = str_replace( ' ', '', $instance['currency_list'] );
			$instance['currency_list'] = explode( ',', $instance['currency_list'] );

			if( !empty( $instance['currency_list'] ) ) {

				if( !empty( $instance['base_currency'] ) ) {

					$table = new \Korobochkin\CurrencyConverter\Service\CurrencyTable();
					$table->parameters = array(
						'base_currency' => $instance['base_currency'],
						'currency_list' => $instance['currency_list'],
						'flag_size' => (int)$instance['flag_size'],
						'table_headers_currencies' => $instance['table_headers_currencies'],
						'table_headers_price' => $instance['table_headers_price'],
						'table_headers_change' => $instance['table_headers_change']
					);
					echo $table->get_table();
				}
			}
		}

		if( $instance['caption_status'] ) {
			$plugin_developer = new PluginDeveloper();
			$plugin_developer->set_base_currency($instance['base_currency']);
			if( $plugin_developer->is_valid() ) {
				echo '<p class="currencyconverter_support-info-container">' . $plugin_developer->get_caption_with_base_currency_link() .  '</p>';
			}
		}

		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $this->_merge_instance_with_default_instance( $new_instance );

		// Basic stuff
		$instance_to_save['title'] = sanitize_text_field( $instance['title'] );

		$instance_to_save['base_currency'] = strtoupper( sanitize_text_field( $instance['base_currency'] ) );

		// Вероятно, это надо сохранять в виде массива
		$instance_to_save['currency_list'] = strtoupper( sanitize_text_field( $instance['currency_list'] ) );

		$instance_to_save['flag_size'] = (int)sanitize_text_field( $instance['flag_size'] );

		// Table headers
		$instance_to_save['table_headers_currencies'] = sanitize_text_field( $instance['table_headers_currencies'] );
		$instance_to_save['table_headers_price'] = sanitize_text_field( $instance['table_headers_price'] );
		$instance_to_save['table_headers_change'] = sanitize_text_field( $instance['table_headers_change'] );

		// Если галочна снята, то переменной нет вообще и она вставляеся из дефолтных значений
		if( $instance['caption_status'] === true && !isset( $new_instance['caption_status'] ) ) {
			$instance_to_save['caption_status'] = false;
		}
		else {
			$instance_to_save['caption_status'] = true;
		}

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
			?><p><?php printf( __( 'Select data provider in <a href="%1$s">plugin settings</a>.', Plugin::NAME ), esc_url( \Korobochkin\CurrencyConverter\Admin\Settings\General\Pages\General\Page::get_url() ) ); ?></p><?php
			return;
		}
		unset( $currency );

		$instance = $this->_merge_instance_with_default_instance($instance);
		$rates = get_option( \Korobochkin\CurrencyConverter\Plugin::NAME . '_rates' );
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

		<p><label for="<?php echo $this->get_field_id( 'flag_icons' ); ?>"><?php _e( 'Flag icons:', Plugin::NAME ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'flag_size' ); ?>" name="<?php echo $this->get_field_name( 'flag_size' ); ?>">
			<option value="0"><?php _e( 'No flag icon', Plugin::NAME ); ?></option>
			<?php
			$flags_sizes = new \Korobochkin\CurrencyConverter\Models\Flags();
			foreach( $flags_sizes->sizes as $size ) {
				printf(
					'<option value="%s"%s>%s</option>',
					esc_attr( $size ),
					selected( $size, $instance['flag_size'], false ),
					esc_html( $size . ' px' )
				);
			}
			?>
		</select>
		</p>

		<h3><?php _e( 'Table headers', Plugin::NAME ); ?></h3>

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

		<p><input id="<?php echo $this->get_field_id('caption_status'); ?>" name="<?php echo $this->get_field_name('caption_status'); ?>" type="checkbox" <?php checked($instance['caption_status'] ); ?>>&nbsp;<label for="<?php echo $this->get_field_id('caption_status'); ?>"><?php _e('Show last update date of currency exchange rate.', Plugin::NAME); ?></label></p>
		<?php
		$first = false;
	}

	private function _merge_instance_with_default_instance( $instance ) {
		$def_settings = array(
			'title' => __( 'Exchange table', Plugin::NAME ),
			'base_currency' => __( 'USD', Plugin::NAME ),
			'currency_list' =>
				/* translators: Default currencies list in widget. Use most popular currencies in your region. WARNING: always use commas as separator */
				__( 'CAD, AUD, GBP', Plugin::NAME ),
			'flag_size' => 16,
			'table_headers_currencies' => __( 'Currencies', Plugin::NAME ),
			'table_headers_price' => __( 'Rate', Plugin::NAME ),
			'table_headers_change' => __( 'Change %', Plugin::NAME ),
			'caption_status' => true
		);
		return wp_parse_args($instance, $def_settings);
	}

	public function wp_enqueue_script_style() {
		// Enqueue styles if theme don't support our plugin and widget is active.
		if( !current_theme_supports( 'plugin-' . Plugin::NAME ) && is_active_widget( false, false, $this->id_base ) ) {
			wp_enqueue_style( 'plugin-' . Plugin::NAME . '-widgets' );
		}
	}
}
