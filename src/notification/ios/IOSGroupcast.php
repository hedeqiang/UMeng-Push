<?php
namespace Hedeqiang\UMeng\notification\ios;

use Hedeqiang\UMeng\notification\IOSNotification;

class IOSGroupcast extends IOSNotification {
	function  __construct() {
		parent::__construct();
		$this->data["type"] = "groupcast";
		$this->data["filter"]  = NULL;
	}
}