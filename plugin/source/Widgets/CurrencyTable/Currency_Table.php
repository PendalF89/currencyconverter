<?php
namespace Korobochkin\Currency\Widgets\CurrencyTable;

use Korobochkin\Currency\Plugin;

class Currency_Table extends \WP_Widget {

	public function __construct() {
		parent::__construct(
			'currency_table',
			__( 'Currency Table', Plugin::NAME ),
			array(
				'classname' => 'widget_currency_table',
				'description' => __( 'A table with currency rates.', Plugin::NAME )
			)
		);
	}

	public function widget( $args, $instance ) {
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
		$table = new \Korobochkin\Currency\Service\CurrencyTable();
		$currency_list = explode( ', ', $instance['currency_list'] );

		if( !empty( $currency_list ) ) {
			$table->parameters = array(
				'base_currency' => empty( $instance['base_currency'] ) ? 'USD' : $instance['base_currency'],
				'currency_list' => $currency_list,
				'flag_size' => !empty( $instance['flag_size'] ) && $instance['flag_size'] > 0 ? $instance['flag_size'] : 0
			);
			echo $table->get_table();
		}

		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = sanitize_text_field( stripslashes( $new_instance['title'] ) );
		$instance['base_currency'] = sanitize_text_field( stripslashes( $new_instance['base_currency'] ) );
		$instance['currency_list'] = sanitize_text_field( stripslashes( $new_instance['currency_list'] ) );
		$instance['flag_size'] = sanitize_text_field( stripslashes( $new_instance['flag_size'] ) );
		return $instance;
	}

	public function form( $instance ) {
		static $first = true;

		if( !\Korobochkin\Currency\Service\Rates::is_available() ) {
			return;
		}

		$title = sanitize_text_field( $instance['title'] );
		$base_currency = sanitize_text_field( $instance['base_currency'] );
		$currency_list = sanitize_text_field( $instance['currency_list'] );
		$current_size = sanitize_text_field( $instance['flag_size'] );
		?>

		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', Plugin::NAME ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"></p>

		<p><label for="<?php echo $this->get_field_id( 'base_currency' ); ?>"><?php _e( 'Base currency:', Plugin::NAME ); ?></label>
		<input class="widefat plugin__currency__autocomplete" id="<?php echo $this->get_field_id( 'base_currency' ); ?>" name="<?php echo $this->get_field_name( 'base_currency' ); ?>" type="text" value="<?php echo esc_attr( $base_currency ); ?>"></p>
		<p class="description"><?php _e( 'The currency in which will be settled other currencies.', Plugin::NAME ); ?></p>

		<p><label for="<?php echo $this->get_field_id( 'currency_list' ); ?>"><?php _e( 'Currencies list:', Plugin::NAME ); ?></label>
		<input class="widefat plugin__currency__autocomplete" id="<?php echo $this->get_field_id( 'currency_list' ); ?>" name="<?php echo $this->get_field_name( 'currency_list' ); ?>" type="text" value="<?php echo esc_attr( $currency_list ); ?>"></p>
		<p class="description"><?php _e( 'The currencies which will be displayed in table. Separate by commas.', Plugin::NAME ); ?></p>

		<script type="text/javascript">
			<?php
			$rates = get_option( \Korobochkin\Currency\Plugin::NAME . '_rates' );
			$tickers = array();
			foreach( $rates[0]['rates'] as $key => $value ) {
				$tickers[] = $key;
			}
			if( !$first ) {
				echo 'var currenciesTickersList =' . wp_json_encode( $tickers ) . ';';
			}
			?>
		</script>

		<p><label for="<?php echo $this->get_field_id( 'flag_icons' ); ?>"><?php _e( 'Flag icons:', Plugin::NAME ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'flag_size' ); ?>" name="<?php echo $this->get_field_name( 'flag_size' ); ?>">
			<option value="0"><?php _e( 'No flag icon', Plugin::NAME ); ?></option>
			<?php
			$flags_sizes = new \Korobochkin\Currency\Models\Flags();
			foreach( $flags_sizes->sizes as $size ) {
				printf(
					'<option value="%s"%s>%s</option>',
					esc_attr( $size ),
					selected( $size, $current_size, false ),
					esc_html( $size . ' px' )
				);
			}
			?>
		</select>
		</p>
		<?php
		$first = false;
	}
}
