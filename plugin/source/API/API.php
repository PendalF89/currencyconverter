<?php
namespace Korobochkin\Currency\API;

use Korobochkin\Currency\Plugin;

class API {

	public $answerFromAPI = null;

	public $parsedAnswer = null;

	public function get_rates() {
		self::get_rates_raw();

		$is_valid = self::validate_answer();

		if( is_wp_error( $is_valid ) ) {
			return $is_valid;
		}

		$is_valid = null;
		$is_valid = self::parse_answer();

		if( is_wp_error( $is_valid ) ) {
			return $is_valid;
		}
		else {
			return self::$parsedAnswer;
		}
	}

	public function get_rates_raw() {
		self::$answerFromAPI = wp_remote_get(
			self::get_api_url()
		);
	}

	public function get_api_url() {
		return __( 'http://api.exchangerate.guru/', Plugin::NAME );
	}

	public function validate_answer() {
		/**
		 * Call get_* method first.
		 */
		if( !self::$answerFromAPI ) {
			return new \WP_Error(
				'call_get_method_first',
				__( 'It seems that you have not tried to get a response from remote server via get_* method first.', Plugin::NAME )
			);
		}
		/**
		 * If we have WP_Error obj during remote get request
		 */
		elseif( is_wp_error( self::$answerFromAPI ) ) {
			return self::$answerFromAPI;
		}

		/**
		 * Checkout object and response code.
		 */
		if( self::$answerFromAPI['response'] === 200 ) {

			/**
			 * Checkout response body.
			 */
			if( !empty( self::$answerFromAPI['body'] ) ) {
				return true;
			}
			else {
				return new \WP_Error(
					'remote_server_return_empty_answer',
					__( 'Remote server return empty answer.', Plugin::NAME )
				);
			}
		}
		else {
			return new \WP_Error(
				'remote_answer_wrong',
				__( 'Remote server return not supported response code.', Plugin::NAME )
			);
		}
	}

	public function parse_answer() {
		self::$parsedAnswer = json_decode( self::$answerFromAPI['body'], true );
		if( is_null( self::$parsedAnswer ) ) {
			return new \WP_Error(
				'invalid_json_inside_answer',
				__( 'Remote server return invalid JSON object.', Plugin::NAME )
			);
		}
	}
}
