<?php
namespace Hedeqiang\UMeng\notification\android;

use Hedeqiang\UMeng\notification\AndroidNotification;

class AndroidListcast extends AndroidNotification {
	function __construct() {
		parent::__construct();
		$this->data["type"] = "listcast";
		$this->data["device_tokens"] = NULL;
	}

}