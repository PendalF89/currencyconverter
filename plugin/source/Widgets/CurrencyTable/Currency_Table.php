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
		$table->parameters = array(
			'base_currency' => 'RUB',
			'currency_list' => array(
				'USD',
				'EUR',
				'RUB',
			)
		);
		echo $table->get_table();

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = sanitize_text_field( $instance['title'] );
		$base_currency = sanitize_text_field( $instance['base_currency'] );
		$currency_list = sanitize_text_field( $instance['currency_list'] );
		?>

		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', Plugin::NAME ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"></p>

		<p><label for="<?php echo $this->get_field_id( 'base_currency' ); ?>"><?php _e( 'Base currency:', Plugin::NAME ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'base_currency' ); ?>" name="<?php echo $this->get_field_name( 'base_currency' ); ?>" type="text" value="<?php echo esc_attr( $base_currency ); ?>"></p>
		<p class="description"><?php _e( 'The currency in which will be settled other currencies.', Plugin::NAME ); ?></p>

		<p><label for="<?php echo $this->get_field_id( 'currency_list' ); ?>"><?php _e( 'Currencies list:', Plugin::NAME ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'currency_list' ); ?>" name="<?php echo $this->get_field_name( 'currency_list' ); ?>" type="text" value="<?php echo esc_attr( $currency_list ); ?>"></p>
		<p class="description"><?php _e( 'The currencies which will be displayed in table. Separate by commas.', Plugin::NAME ); ?></p>
		<?php
	}
}
