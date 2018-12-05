<?php
namespace Hedeqiang\UMeng\notification\android;

use Hedeqiang\UMeng\notification\AndroidNotification;

class AndroidGroupcast extends AndroidNotification {
	function  __construct() {
		parent::__construct();
		$this->data["type"] = "groupcast";
		$this->data["filter"]  = NULL;
	}
}