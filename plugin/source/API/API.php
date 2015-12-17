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

	private $provider;

	public function __construct( $provider ) {
		$this->provider = $provider;
	}

	public $answerFromAPI = null;

	public $parsedAnswer = null;

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

			// Пробуем отсортировать массивы валют по алфавиту
			$this->sort_rates_by_key();

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
		$this->answerFromAPI = wp_remote_get( $this->provider['api_url'] );
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

	private function sort_rates_by_key() {
		// Сортируем все валюты по алфавиту
		$filtered_array = $this->parsedAnswer;
		$filtered_array_valid[] = ksort( $filtered_array[0]['rates'] );
		$filtered_array_valid[] = ksort( $filtered_array[1]['rates'] );

		if( !in_array( false, $filtered_array_valid ) ) {
			$this->parsedAnswer[0]['rates'] = $filtered_array[0]['rates'];
			$this->parsedAnswer[1]['rates'] = $filtered_array[1]['rates'];
		}
	}
}
