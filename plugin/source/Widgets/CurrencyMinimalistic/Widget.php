<?php
namespace Korobochkin\CurrencyConverter\Widgets\CurrencyMinimalistic;

use Korobochkin\CurrencyConverter\Models\Currency;
use Korobochkin\CurrencyConverter\Plugin;
use Korobochkin\CurrencyConverter\Service\Text;

class Widget extends \WP_Widget {

	public function __construct() {
		parent::__construct(
			'currencyconverter_minimalistic',
			__( 'Currency Converter. Minimalistic', Plugin::NAME ),
			array(
				'classname' => 'widget_currencyconverter_minimalistic',
				'description' => __( 'Light minimalistic widget with solid and clean colors and gradients.', Plugin::NAME )
			)
		);

		// Enqueue styles if theme don't support our plugin and widget is active.
		if( !current_theme_supports( 'plugin-' . Plugin::NAME ) && is_active_widget( false, false, $this->id_base ) ) {
			wp_enqueue_style( 'plugin-' . Plugin::NAME . '-widgets' );
			wp_enqueue_style( 'plugin-' . Plugin::NAME . '-fonts' );
		}
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

		if(
			!empty( $instance['currency_list'] )
			&&
			!empty( $instance['base_currency'] )
		) {
			$instance['currency_list'] = str_replace( ' ', '', $instance['currency_list'] );
			$instance['currency_list'] = explode( ',', $instance['currency_list'] );

			if( !empty( $instance['currency_list'] ) ) {
				echo '<div class="currency-converter_minimalistic-container">';
				foreach( $instance['currency_list'] as $currency_ticker ) {
					$currency_obj = new Currency( $instance['base_currency'], $currency_ticker );
					if( $currency_obj->is_available() ) {
						?>
						<div class="currency-converter_minimalistic-single-currency">
							<div class="currency-converter_minimalistic-row">
								<span class="currency-converter_minimalistic-currency-price"><?php echo number_format_i18n( $currency_obj->get_rate(), 2); ?></span>
							</div>
							<div class="currency-converter_minimalistic-row">
								<span class="currency-converter_minimalistic-inline-list">
									<span class="currency-converter_minimalistic-inline-list-item">
										<?php echo $currency_ticker; ?>
									</span><span class="currency-converter_minimalistic-inline-list-item">
										<?php echo Text::number_format_i18n_plus_minus( $currency_obj->get_change_percentage(), 2 ); ?>
									</span>
								</span>
							</div>
						</div>
						<?php
					}
				}
				echo '</div>';
			}
		}

		$currencies_obj = new Currency( $instance['base_currency'], $instance['base_currency'] );
		if( $currencies_obj->is_available() ) {
			echo '<p class="currency-converter_support-info-container">' .
			     sprintf(
				     _x( '<a href="%1$s" class="currency-converter-update-data-link">Exchange rate</a> on %2$s', '%1$s - url to data provider website. %2$s - date of update currency rate in regional format.', Plugin::NAME ),
				     esc_url(
					     _x( 'http://exchangerate.guru/', 'Homepage URL of plugin developer.', Plugin::NAME )
				     ),
				     esc_html(
					     $currencies_obj->get_rate_datetime()->format(
						     _x( 'F j, Y', 'Local date/month/year date format. Available variables - http://php.net/manual/en/function.date.php. Note that the name of the month may be displayed on English language or wrong the ending of the word (падежное окончание). Например, для русского языка лучше использовать формат ДД-ММ-ГГГГ, потому что "21 декабрь 2015" выглядит не очень красиво.', Plugin::NAME )
					     )
				     )
			     )
			     . '</p>';
		}

		$this->_print_gradiented_styles( '#' . $args['widget_id'], $instance );
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $this->_merge_instance_with_default_instance( $new_instance );

		// Basic stuff
		$instance_to_save['title'] = sanitize_text_field( $instance['title'] );

		$instance_to_save['base_currency'] = strtoupper( sanitize_text_field( $instance['base_currency'] ) );

		// Вероятно, это надо сохранять в виде массива
		$instance_to_save['currency_list'] = strtoupper( sanitize_text_field( $instance['currency_list'] ) );

		$instance_to_save['bg_color_1'] = sanitize_text_field( $instance['bg_color_1'] );
		$instance_to_save['bg_color_2'] = sanitize_text_field( $instance['bg_color_2'] );
		$instance_to_save['color'] = sanitize_text_field( $instance['color'] );
		$instance_to_save['separator_color'] = sanitize_text_field( $instance['separator_color'] );

		$instance['separator_opacity'] = (int)sanitize_text_field( $instance['separator_opacity'] );
		if( $instance['separator_opacity'] > 0 && $instance['separator_opacity'] <= 100 ) {
			$instance_to_save['separator_opacity'] = sanitize_text_field( $instance['separator_opacity'] );
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

		<h3><?php _e( 'Background color', Plugin::NAME ); ?></h3>

		<p><?php _e( 'Predefined color schemes:', Plugin::NAME ); ?></p>

		<?php
			$default_presets = Defaults::get_default_color_schemes();
			echo '<ul class="currency-converter-minimalistic-widget-settings-palettes">';
			foreach( $default_presets as $default_key => $default_preset ) {
				$default_key = 'currency-conveter-minimalistic-widget-settings-color-grid-gradient-' . $default_key;
				?><li id="<?php echo esc_attr($default_key);?>" class="color-grid color-grid-gradient"><span class="currency-converter_minimalistic-container" <?php echo $this->_generate_html_attrs($default_preset); ?>>Abc</span></li><?php
				$default_key = '#' . $default_key;
				$this->_print_gradiented_styles($default_key, $default_preset);
				$this->_generate_switch_color_scheme_scripts( $default_key );
			}
			echo '</ul>';
		?>


		<p>
			<label for="<?php echo $this->get_field_id( 'bg_color_1' ); ?>"><?php _e( 'First background color:', Plugin::NAME ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'bg_color_1' ); ?>" name="<?php echo $this->get_field_name( 'bg_color_1' ); ?>" type="text" value="<?php echo esc_attr( $instance['bg_color_1'] ); ?>" size="6">
		</p>
		<script>
			jQuery(document).ready(function($){
				$('#<?php echo $this->get_field_id( 'bg_color_1' ); ?>').iris({
					width: 246,
					border: true,
					hide: false
				});
				// TODO: Добавить динамическое изменение ширины для Iris
			});
		</script>

		<p>
			<label for="<?php echo $this->get_field_id( 'bg_color_2' ); ?>"><?php _e( 'Second background color:', Plugin::NAME ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'bg_color_2' ); ?>" name="<?php echo $this->get_field_name( 'bg_color_2' ); ?>" type="text" value="<?php echo esc_attr( $instance['bg_color_2'] ); ?>" size="6">
		</p>
		<script>
			jQuery(document).ready(function($){
				$('#<?php echo $this->get_field_id( 'bg_color_2' ); ?>').iris({
					width: 246,
					border: true,
					hide: false
				});
				// TODO: Добавить динамическое изменение ширины для Iris
			});
		</script>

		<p>
			<label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php _e( 'Font color:', Plugin::NAME ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" type="text" value="<?php echo esc_attr( $instance['color'] ); ?>" size="6">
		</p>
		<script>
			jQuery(document).ready(function($){
				$('#<?php echo $this->get_field_id( 'color' ); ?>').iris({
					width: 246,
					border: true,
					hide: false
				});
				// TODO: Добавить динамическое изменение ширины для Iris
			});
		</script>

		<p>
			<label for="<?php echo $this->get_field_id( 'separator_color' ); ?>"><?php _e( 'Separator line color:', Plugin::NAME ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'separator_color' ); ?>" name="<?php echo $this->get_field_name( 'separator_color' ); ?>" type="text" value="<?php echo esc_attr( $instance['separator_color'] ); ?>" size="6">
		</p>
		<script>
			jQuery(document).ready(function($){
				$('#<?php echo $this->get_field_id( 'separator_color' ); ?>').iris({
					width: 246,
					border: true,
					hide: false
				});
				// TODO: Добавить динамическое изменение ширины для Iris
			});
		</script>

		<p>
			<label for="<?php echo $this->get_field_id( 'separator_opacity' ); ?>"><?php _e( 'Separator line opacity:', Plugin::NAME ); ?></label>
			<input class="" id="<?php echo $this->get_field_id( 'separator_opacity' ); ?>" name="<?php echo $this->get_field_name( 'separator_opacity' ); ?>" type="text" value="<?php echo esc_attr( $instance['separator_opacity'] ); ?>" size="6">&nbsp;%
		</p>
		<?php
		$first = false;
	}

	private function _merge_instance_with_default_instance( $instance ) {
		$def_settings = array(
			'title' => __( 'Currency exchange rate', Plugin::NAME ),
			'base_currency' => __( 'USD', Plugin::NAME ),
			'currency_list' => _x( 'CAD, AUD, GBP', 'WARNING: always use commas as separator', Plugin::NAME ),
			'bg_color_scheme' => '',
			'bg_color_1' => '#ffa200',
			'bg_color_2' => '#ff5a00',
			'color' => '#ffffff',
			'separator_color' => '#ffffff',
			'separator_opacity' => 30
		);
		return wp_parse_args($instance, $def_settings);
	}

	private function _print_gradiented_styles( $selector, $instance ) {
		$selector = esc_html( $selector );
		foreach( $instance as $key => $value ) {
			$instance[$key] = esc_html( $value );
		}
		?><style type="text/css">
			<?php echo $selector; ?> .currency-converter_minimalistic-container {
				border: 0;
				background-image: -webkit-linear-gradient(top, <?php echo $instance['bg_color_1']; ?> 0%, <?php echo $instance['bg_color_2']; ?> 100%);
				background-image: -o-linear-gradient(top, <?php echo $instance['bg_color_1']; ?> 0%, <?php echo $instance['bg_color_2']; ?> 100%);
				background-image: -webkit-gradient(linear, left top, left bottom, from(<?php echo $instance['bg_color_1']; ?>), to(<?php echo $instance['bg_color_2']; ?>));
				background-image: linear-gradient(to bottom, <?php echo $instance['bg_color_1']; ?> 0%, <?php echo $instance['bg_color_2']; ?> 100%);
				color: <?php echo $instance['color']; ?>;
			}

			<?php echo $selector; ?> .currency-converter_minimalistic-single-currency {
				border-top-color: rgba(<?php echo \Korobochkin\CurrencyConverter\Service\Colors::hex2rgba($instance['separator_color'], $instance['separator_opacity']); ?>);
			}
		</style><?php
	}
	private function _generate_html_attrs( $attributes, $prefix = 'data' ) {
		$attributes_string = '';
		if( is_array( $attributes )) {
			foreach( $attributes as $key => $value ) {
				$attributes_string .= $prefix .'-' . esc_attr( $key ) . '="' . esc_attr( $value ) . '" ';
			}
		}
		return $attributes_string;
	}

	private function _generate_switch_color_scheme_scripts( $default_key ) {
		// TODO: По клику на цветовые схемы в кастомайзере не обновляется страница, хотя все инпуты обновляются.
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($){

				jQuery('<?php echo esc_js($default_key); ?> .currency-converter_minimalistic-container').click(function(event){

					if (typeof $(event.target).data('bg_color_1') !== 'undefined') {
						$('#<?php echo esc_js( $this->get_field_id( 'bg_color_1' ) ); ?>')
							.val( $(event.target).data('bg_color_1') )
							.iris('color', $(event.target).data('bg_color_1'));
					}

					if (typeof $(event.target).data('bg_color_2') !== 'undefined') {
						$('#<?php echo esc_js( $this->get_field_id( 'bg_color_2' ) ); ?>')
							.val( $(event.target).data('bg_color_2') )
							.iris('color', $(event.target).data('bg_color_2'));
					}

					if (typeof $(event.target).data('color') !== 'undefined') {
						$('#<?php echo esc_js( $this->get_field_id( 'color' ) ); ?>')
							.val( $(event.target).data('color') )
							.iris('color', $(event.target).data('color'));
					}

					if (typeof $(event.target).data('separator_color') !== 'undefined') {
						$('#<?php echo esc_js( $this->get_field_id( 'separator_color' ) ); ?>')
							.val( $(event.target).data('separator_color') )
							.iris('color', $(event.target).data('separator_color'));
					}

					if (typeof $(event.target).data('separator_opacity') !== 'undefined') {
						$('#<?php echo esc_js( $this->get_field_id( 'separator_opacity' ) ); ?>')
							.val( $(event.target).data('separator_opacity') );
					}

				});

			}(jQuery));
		</script>
		<?php
	}
}
