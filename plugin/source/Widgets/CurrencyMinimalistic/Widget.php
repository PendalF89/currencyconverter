<?php
namespace Korobochkin\CurrencyConverter\Widgets\CurrencyMinimalistic;

use Korobochkin\CurrencyConverter\Models\Currency;
use Korobochkin\CurrencyConverter\Models\PluginDeveloper;
use Korobochkin\CurrencyConverter\Plugin;
use Korobochkin\CurrencyConverter\Service\Text;

class Widget extends \WP_Widget {

	public function __construct() {
		parent::__construct(
			'currencyconverter_minimalistic',
			__( 'Currency Converter. Minimalistic', Plugin::NAME ),
			array(
				'classname' => 'widget_currencyconverter_minimalistic',
				'description' => __( 'Light minimalistic widget with solid, clean colors and gradients.', Plugin::NAME ),
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

		if(
			!empty( $instance['currency_list'] )
			&&
			!empty( $instance['base_currency'] )
		) {
			$instance['currency_list'] = str_replace( ' ', '', $instance['currency_list'] );
			$instance['currency_list'] = explode( ',', $instance['currency_list'] );

			if( !empty( $instance['currency_list'] ) ) {
				echo '<div class="currencyconverter-minimalistic-container">';
				foreach( $instance['currency_list'] as $currency_ticker ) {
					$currency_obj = new Currency( $instance['base_currency'], $currency_ticker );
					if( $currency_obj->is_available() ) {
						$currency_data_filtered = Text::currency_info_for_round( $currency_obj, 2 );
						?>
						<div class="currencyconverter-minimalistic-single-currency">
							<div class="currencyconverter-minimalistic-row">
								<span class="currencyconverter-minimalistic-currency-price"><?php echo number_format_i18n( $currency_data_filtered['rate'], 2); ?></span>
							</div>
							<div class="currencyconverter-minimalistic-row">
								<span class="currencyconverter-minimalistic-inline-list">
									<span class="currencyconverter-minimalistic-inline-list-item currencyconverter-minimalistic-ticker">
										<?php echo $currency_ticker; ?>
									</span><span class="currencyconverter-minimalistic-inline-list-item currencyconverter-minimalistic-change-percentage">
										<?php printf(
											/* translators: %s - currency change number (digit) in percentage. %% - one percentage symbol (typed twice for escape in printf() func.) */
											__( '%s<span class="currencyconverter-percentage-symbol">%%</span>', Plugin::NAME ), Text::number_format_i18n_plus_minus( $currency_data_filtered['change_percentage'], 2 )
											); ?>
									</span><?php
										if( $currency_data_filtered['per'] > 1 ) {
											/* translators: Some of currencies (units) are very small. For example 1 US dollar (USD) = 0.0026528435830000001 bitcoins (BTC). Sometimes we round this to 0.00 by round() func. To avoid this small currencies (units) recalculated by multiplying "small" number by 1000 or 1000000. And after this: 1000 USD = 0.26 BTC (0.26 BTC per 1000 USD). */
											$per_value = '<span class="currencyconverter-minimalistic-inline-list-item currencyconverter-minimalistic-per">' . esc_html( sprintf( __( 'Per %s', Plugin::NAME ), number_format_i18n( $currency_data_filtered['per'] ) ) ) . '</span>';
											echo $per_value;
										}
                                    ?>
								</span>
							</div>
						</div>
						<?php
					}
				}
				echo '</div>';
			}
		}

		if( $instance['caption_status'] ) {
			$plugin_developer = new PluginDeveloper();
			$plugin_developer->set_base_currency($instance['base_currency']);
			if( $plugin_developer->is_valid() ) {
				echo '<p class="currencyconverter-support-info-container">' . $plugin_developer->get_caption_with_base_currency_link() .  '</p>';
			}
		}

		$this->print_gradiented_styles( '#' . $args['widget_id'], $instance );
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

		<h3><?php _e( 'Background color', Plugin::NAME ); ?></h3>

		<p><?php _e( 'Predefined color schemes:', Plugin::NAME ); ?></p>

		<?php
			$default_presets = Defaults::get_default_color_schemes();
			echo '<ul class="currencyconverter-minimalistic-widget-settings-palettes">';
			foreach( $default_presets as $default_key => $default_preset ) {
				$id = $this->get_field_id( 'palettes-' . $default_key );

				?><li id="<?php echo esc_attr($id);?>" class="color-grid color-grid-gradient currencyconverter-color-grid-<?php echo esc_attr( $default_key ); ?>" data-currency-converter-palettes-switcher="true">
					<span class="currencyconverter-minimalistic-container" <?php echo $this->_generate_html_attrs($default_preset, $id); ?>>Abc</span>
				</li><?php
				$this->_generate_switch_color_scheme_scripts( $id );
			}
			echo '</ul>';
		?>


		<p>
			<label for="<?php echo $this->get_field_id( 'bg_color_1' ); ?>"><?php _e( 'First background color:', Plugin::NAME ); ?></label>
			<div>
				<input class="widefat" id="<?php echo $this->get_field_id( 'bg_color_1' ); ?>" name="<?php echo $this->get_field_name( 'bg_color_1' ); ?>" type="text" value="<?php echo esc_attr( $instance['bg_color_1'] ); ?>" size="6" data-currency-converter-minimalistic-palette-color="true">
			</div>
		</p>


		<p>
			<label for="<?php echo $this->get_field_id( 'bg_color_2' ); ?>"><?php _e( 'Second background color:', Plugin::NAME ); ?></label>
			<div>
				<input class="widefat" id="<?php echo $this->get_field_id( 'bg_color_2' ); ?>" name="<?php echo $this->get_field_name( 'bg_color_2' ); ?>" type="text" value="<?php echo esc_attr( $instance['bg_color_2'] ); ?>" size="6" data-currency-converter-minimalistic-palette-color="true">
			</div>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'color' ); ?>"><?php _e( 'Font color:', Plugin::NAME ); ?></label>
			<div>
				<input class="widefat" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" type="text" value="<?php echo esc_attr( $instance['color'] ); ?>" size="6" data-currency-converter-minimalistic-palette-color="true">
			</div>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'separator_color' ); ?>"><?php _e( 'Separator line color:', Plugin::NAME ); ?></label>
			<div>
				<input class="widefat" id="<?php echo $this->get_field_id( 'separator_color' ); ?>" name="<?php echo $this->get_field_name( 'separator_color' ); ?>" type="text" value="<?php echo esc_attr( $instance['separator_color'] ); ?>" size="6" data-currency-converter-minimalistic-palette-color="true">
			</div>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'separator_opacity' ); ?>"><?php _e( 'Separator line opacity:', Plugin::NAME ); ?></label>
			<input class="" id="<?php echo $this->get_field_id( 'separator_opacity' ); ?>" name="<?php echo $this->get_field_name( 'separator_opacity' ); ?>" type="text" value="<?php echo esc_attr( $instance['separator_opacity'] ); ?>" size="6">&nbsp;%
		</p>

		<p><input id="<?php echo $this->get_field_id('caption_status'); ?>" name="<?php echo $this->get_field_name('caption_status'); ?>" type="checkbox" <?php checked($instance['caption_status'] ); ?>>&nbsp;<label for="<?php echo $this->get_field_id('caption_status'); ?>"><?php _e('Show last update date of currency exchange rate.', Plugin::NAME); ?></label></p>

		<?php
		if( $first ) {
			/**
			 * Print color palettes styles only one time (they similar for all widgets).
             */
			foreach( $default_presets as $default_key => $default_preset ) {
				$this->print_gradiented_styles( '.currencyconverter-color-grid-' . $default_key, $default_preset );
			}

			// TODO: Добавить динамическое изменение ширины для Iris
			/**
			 * JS Init see http://wordpress.stackexchange.com/a/212676/46077
			 */
			?>
			<script type="text/javascript">
				(function($){

					function init(widget) {
						widget.find('*[data-currency-converter-minimalistic-palette-color="true"]').wpColorPicker( {
							change:
								(typeof _ !== 'undefined') ?
									_.throttle(function() {
										$(this).trigger('change');
									}, 1000 )
									: function(){},
							width: 246
						});
					}

					$(document).on('widget-added widget-updated', function(event, widget) {
						init(widget);
					});

					$(document).ready(function() {
						$('#widgets-right .widget').each(function() {
							init($(this));
						});
					});
				}(jQuery));
			</script>
			<?php
			$first = false;
		}
	}

	private function _merge_instance_with_default_instance( $instance ) {
		$def_settings = array(
			'title' => __( 'Currency exchange rate', Plugin::NAME ),
			'base_currency' => __( 'USD', Plugin::NAME ),
			'currency_list' =>
				/* translators: Default currencies list in widget. Use most popular currencies in your region. WARNING: always use commas as separator */
				__( 'CAD, AUD, GBP', Plugin::NAME ),
			'bg_color_scheme' => '',
			'bg_color_1' => '#ffa200',
			'bg_color_2' => '#ff5a00',
			'color' => '#ffffff',
			'separator_color' => '#ffffff',
			'separator_opacity' => 30,
			'caption_status' => true,
		);
		return wp_parse_args($instance, $def_settings);
	}

	private function print_gradiented_styles( $selector, $instance ) {
		foreach( $instance as $key => $value ) {
			if( is_string( $value ) ) {
				$instance[$key] = esc_html( $value );
			}
		}
		?><style type="text/css">
			<?php echo $selector; ?> .currencyconverter-minimalistic-container {
				border: 0;
				background-image: -webkit-linear-gradient(top, <?php echo $instance['bg_color_1']; ?> 0%, <?php echo $instance['bg_color_2']; ?> 100%);
				background-image: -o-linear-gradient(top, <?php echo $instance['bg_color_1']; ?> 0%, <?php echo $instance['bg_color_2']; ?> 100%);
				background-image: -webkit-gradient(linear, left top, left bottom, from(<?php echo $instance['bg_color_1']; ?>), to(<?php echo $instance['bg_color_2']; ?>));
				background-image: linear-gradient(to bottom, <?php echo $instance['bg_color_1']; ?> 0%, <?php echo $instance['bg_color_2']; ?> 100%);
				color: <?php echo $instance['color']; ?>;
			}

			<?php echo $selector; ?> .currencyconverter-minimalistic-single-currency {
				border-top-color: rgba(<?php echo \Korobochkin\CurrencyConverter\Service\Colors::hex2rgba($instance['separator_color'], $instance['separator_opacity']); ?>);
			}
		</style><?php
	}

	private function _generate_html_attrs( $attributes, $id, $prefix = 'data' ) {
		$attributes_string = '';
		if( is_array( $attributes )) {
			foreach( $attributes as $key => $value ) {
				$attributes[$key . '-target-id'] = $this->get_field_id($key);
			}
			foreach( $attributes as $key => $value ) {
				$attributes_string .= $prefix .'-' . esc_attr( $key ) . '="' . esc_attr( $value ) . '" ';

			}
		}
		return $attributes_string;
	}

	private function _generate_switch_color_scheme_scripts( $default_key ) {
		?><script type="text/javascript">
			jQuery(document).ready(function($){

				$('#widgets-right [data-currency-converter-palettes-switcher="true"] .currencyconverter-minimalistic-container').click(function(event){

					if (typeof $(event.target).data('bg_color_1') !== 'undefined') {
						$(   '#' + $(event.target).data('bg_color_1-target-id')   )
							.val( $(event.target).data('bg_color_1') )
							.iris('color', $(event.target).data('bg_color_1'));
					}

					if (typeof $(event.target).data('bg_color_2') !== 'undefined') {
						$(   '#' + $(event.target).data('bg_color_2-target-id')   )
							.val( $(event.target).data('bg_color_2') )
							.iris('color', $(event.target).data('bg_color_2'));
					}

					if (typeof $(event.target).data('color') !== 'undefined') {
						$(   '#' + $(event.target).data('color-target-id')   )
							.val( $(event.target).data('color') )
							.iris('color', $(event.target).data('color'));
					}

					if (typeof $(event.target).data('separator_color') !== 'undefined') {
						$(   '#' + $(event.target).data('separator_color-target-id')   )
							.val( $(event.target).data('separator_color') )
							.iris('color', $(event.target).data('separator_color'));
					}

					if (typeof $(event.target).data('separator_opacity') !== 'undefined') {
						$(   '#' + $(event.target).data('separator_opacity-target-id')   )
							.val( $(event.target).data('separator_opacity') );
					}

				});

			}(jQuery));
		</script><?php
	}

	public function wp_enqueue_script_style() {
		// Enqueue styles if theme don't support our plugin and widget is active.
		if( !current_theme_supports( 'plugin-' . Plugin::NAME ) && is_active_widget( false, false, $this->id_base ) ) {
			wp_enqueue_style( 'plugin-' . Plugin::NAME . '-widgets' );
			wp_enqueue_style( 'plugin-' . Plugin::NAME . '-fonts' );
		}
	}
}
