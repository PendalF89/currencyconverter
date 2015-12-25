<?php
namespace Korobochkin\CurrencyConverter\Models;

use Korobochkin\CurrencyConverter\Plugin;

class Flag {

	private $flag_name;

	private $flag_extension = 'png';

	private $flag_style = 'flat';

	public function set_flag_by_currency( $currency ) {
		$this->flag_name = substr( $currency, 0, 2 );
	}

	public function set_flag_style( $style ) {
		switch( $style ) {
			case 'flat':
			default:
				$this->flag_style = 'flat';
				break;

			case 'shiny':
				$this->flag_style = 'shiny';
				break;
		}
	}

	public function set_flag_extension( $ext ) {
		switch( $ext ) {
			case 'png':
			default:
				$this->flag_extension = 'png';
				break;
			/**
			 * Other formats not supported right now.
			 */
		}
	}

	public function get_flag( $size = 16 ) {
		if( !$this->flag_name ) {
			return new \WP_Error( 'empty_flag_name', __( 'Empty flag name', Plugin::NAME ) );
		}
		$url = plugin_dir_url( $GLOBALS['CurrencyConverterPlugin']->plugin_path ) . 'libs/flags/flags-iso/';

		switch( $size ) {
			case 16:
			default:
				$url .= '16';
				break;

			case 24:
				$url .= '24';
				break;

			case 32:
				$url .= '32';
				break;

			case 48:
				$url .= '48';
				break;

			case 64:
				$url .= '64';
				break;
		}

		$url .= '/' . $this->flag_name . $this->flag_extension;
		return $url;
	}
}
