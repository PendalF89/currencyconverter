<?php
namespace Korobochkin\Currency\Models;

class Country {

	private $flagObj;

	public function __construct() {

	}

	public function setFlagObj($flag) {
		$this->flagObj = $flag;
	}

	public function getFlagObj($flag) {
		return $this->flagObj;
	}
}
