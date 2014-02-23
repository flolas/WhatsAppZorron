<?php
namespace Library\WhatsApp\Connection\WhatsAPI;

class onGetMessageEventListener extends WhatsAppEventListenerBase {
	private $data;
	function data(){
	if(isset($this->data)){
	$data=$this->data;
	unset($this->data);
	return $data;
	}
	}
    function onGetMessage(
        $phone, // The user phone number including the country code.
        $from, // The sender JID.
        $msgid, // The message id.
        $type, // The message type.
        $time, // The unix time when send message notification.
        $name, // The sender name.
        $message // The message.
    ) {
    	$this->data = $data;
    }
}
?>