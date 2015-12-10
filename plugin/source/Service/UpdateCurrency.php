<?php
namespace Korobochkin\Currency\Service;

class UpdateCurrency {
	static public $answerFromAPI = null;

	static function update( $show_warning_in_admin = true ) {
		self::$answerFromAPI = \Korobochkin\Currency\API\API::get_rates();
		if( !is_wp_error( self::$answerFromAPI ) ) {

		}
		//update_option( \Korobochkin\Currency\Plugin::NAME . '_rates', self::$answerFromAPI );
	}
}
