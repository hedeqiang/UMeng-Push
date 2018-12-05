<?php
namespace Hedeqiang\UMeng\notification\android;

use Hedeqiang\UMeng\notification\AndroidNotification;

class AndroidUnicast extends AndroidNotification {
function __construct() {
    parent::__construct();
    $this->data["type"] = "unicast";
    $this->data["device_tokens"] = NULL;
}

}