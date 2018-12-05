<?php
namespace Hedeqiang\UMeng\notification\ios;

use Hedeqiang\UMeng\notification\IOSNotification;

class IOSUnicast extends IOSNotification {
	function __construct() {
		parent::__construct();
		$this->data["type"] = "unicast";
		$this->data["device_tokens"] = NULL;
	}

}