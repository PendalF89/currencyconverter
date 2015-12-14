<?php
namespace Korobochkin\Currency\API;

use Korobochkin\Currency\Plugin;

class API {
	/**
	 * TODO: Нужно реализовать нормальную работу плагина, если почему-то от API пришел кривой ответ или
	 * сохраненная версия провайдера данных недоступна и т. п.
	 */

	/**
	 * TODO: Нужно переписать так, чтобы можно было работать с разными провайдерами
	 */

	public $answerFromAPI = null;

	public $parsedAnswer = null;

	private $APIUrl;

	public function get_rates() {
		$this->get_remote();

		$is_valid = $this->validate_answer();

		if( is_wp_error( $is_valid ) ) {
			return $is_valid;
		}

		$is_valid = null;
		$is_valid = self::parse_answer();

		if( is_wp_error( $is_valid ) ) {
			return $is_valid;
		}
		else {
			$this->add_usd_to_rates();
			return $this->parsedAnswer;
		}
	}

	public function get_rates_raw() {
		self::get_remote();

		$is_valid = self::validate_answer();

		if( is_wp_error( $is_valid ) ) {
			return $is_valid;
		}

		return $this->answerFromAPI['body'];
	}

	public function get_remote() {
		$this->answerFromAPI = wp_remote_get(
			$this->get_api_url()
		);
	}

	public function get_api_url() {

		$providers = \Korobochkin\Currency\Models\DataProviders::getInstance()->get_providers();
		$settings = get_option( Plugin::NAME );

		if( empty($settings['data_provider_name'] ) ) {
			return \WP_Error('no_data_provider', __( 'Select data provider in admin settings.', Plugin::NAME ));
		}

		if( !array_key_exists( $settings['data_provider_name'], $providers ) || $providers[$settings['data_provider_name']]['active'] != true ) {
			return \WP_Error( 'data_provider_missed', __( 'Selected data provider disabled or no exists.', Plugin::NAME ) );
		}

		$url = add_query_arg(
			array(
				'source' => $providers[$settings['data_provider_name']]['abbreviated_name'],
			),
			'http://api.exchangerate.guru/'
		);

		$this->APIUrl = $url;

		return $this->APIUrl;
	}

	private function validate_answer() {
		/**
		 * Call get_* method first.
		 */
		if( !$this->answerFromAPI ) {
			return new \WP_Error(
				'call_get_method_first',
				__( 'It seems that you have not tried to get a response from remote server via get_* method first.', Plugin::NAME )
			);
		}
		/**
		 * If we have WP_Error obj during remote get request
		 */
		elseif( is_wp_error( $this->answerFromAPI ) ) {
			return $this->answerFromAPI;
		}

		/**
		 * Checkout object and response code.
		 */
		if( $this->answerFromAPI['response']['code'] === 200 ) {

			/**
			 * Checkout response body.
			 */
			if( !empty( $this->answerFromAPI['body'] ) ) {
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

	private function parse_answer() {
		$this->parsedAnswer = json_decode( $this->answerFromAPI['body'], true );
		if( is_null( $this->parsedAnswer ) ) {
			return new \WP_Error(
				'invalid_json_inside_answer',
				__( 'Remote server return invalid JSON object.', Plugin::NAME )
			);
		}
	}

	public function add_usd_to_rates() {
		$this->parsedAnswer[0]['rates']['USD'] = 1;
		$this->parsedAnswer[1]['rates']['USD'] = 1;
	}
}
