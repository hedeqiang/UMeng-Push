<?php
namespace Hedeqiang\UMeng\notification\ios;

use Hedeqiang\UMeng\notification\IOSNotification;

class IOSBroadcast extends IOSNotification {
	function  __construct() {
		parent::__construct();
		$this->data["type"] = "broadcast";
	}
}