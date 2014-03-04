<?php
// Namespace
namespace Module;
/**
 * Misc
 *
 * @package WhatsApp
 * @subpackage Module
 * @author Felipe Lolas <flolas@alumnos.uai.cl>
 */
class Misc extends \Library\WhatsApp\Module\Base {
	/**
	 * The number of arguments the command needs.
	 *
	 * @var integer
	 */
	
	protected $numberOfArguments = -1;
    /**
     * This module recieves all data when the user dont send the command prefix.
     * $this->source = phone
     * $this->message = message recieved 
     * $this->type = type of msg(voice,msg,attach,etc..)
     * $this->from = name of the sender
     * $this->say($msg) for response [DONT USE CHAR Á]
     * $this->log($msg,$kind) for log [$kind]$msg on console
     */
    public function command() {
    	$data = include(ROOT_DIR . '/Misc.data.php');
    	$message =$this->message;
    	foreach($data as $key=>$m){
		    	$patterns = $m['msgs'];
				    	foreach ($patterns as $pattern) {
				    		if (stristr($message, $pattern)) {
				    			$this->say($m['responses'][array_rand($m['responses'])]);
				    			if($key=='saludar'){sleep(0.05);$this->say("Escribe ayuda para ver que puedo hacer por ti :)");}
				    			break;
				    		}
				    	}
    	}
    }
}