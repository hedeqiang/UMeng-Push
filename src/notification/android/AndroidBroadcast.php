<?php
namespace Hedeqiang\UMeng\notification\android;

use Hedeqiang\UMeng\notification\AndroidNotification;

class AndroidBroadcast extends AndroidNotification {
	function  __construct() {
		parent::__construct();
		$this->data["type"] = "broadcast";
	}
}