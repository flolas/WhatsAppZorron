<?php
// Namespace
namespace Module;

/**
 * Sends the joke to the user
 *
 * @package WhatsApp
 * @subpackage Module
 * @author Felipe Lolas <flolas@alumnos.uai.cl>
 */
class Quit extends \Library\WhatsApp\Module\Base {

	/**
	 * The command's help text.
	 *
	 * @var string
	 */
	protected $help = '!Restart <password>';

	/**
	 * The number of arguments the command needs.
	 *
	 * @var integer
	 */
	protected $numberOfArguments = 1;
    /**
     * Sends the arguments to the client. A random joke.
     * Example Module
     * $this->source = phone
     * $this->message = complete message recieved whitout command
     * $this->type = type of msg(voice,msg,attach,etc..)
     * $this->name = name of the sender
     * $this->say($msg) for response(autologged on console)
     * $this->log($msg,$kind) for log [$kind]$msg on console
     * $this->arguments = list of arguments after command(spaces)
     */
    public function command() {
    	if($this->arguments[0]==MPASS){
 		$this->bot->log("Shutting down bot from {$this->name}<{$this->source}>");
   		$this->say("Saliendo...");
   		exit();
    	}
    	else
    	{
    		$this->bot->log("Unauthorized access from {$this->name}<{$this->source}>");
    		$this->say("No puedes hacer esto pequeno zorron.");
    	}
   		
	}
}