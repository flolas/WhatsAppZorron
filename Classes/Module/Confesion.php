<?php
// Namespace
namespace Module;

/**
 * Modulo para obtener confesion desde confesion UAI Facebook
 *
 * @package WhatsApp
 * @subpackage Module
 * @author Felipe Lolas <flolas@alumnos.uai.cl>
 */
class Confesion extends \Library\WhatsApp\Module\Base {

	/**
	 * The command's help text.
	 *
	 * @var string
	 */
	protected $help = '!confesion <#confesion o tema>';

	/**
	 * The number of arguments the command needs.
	 *
	 * @var integer
	 */
	protected $numberOfArguments = -1;
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
    	$profile_id = "261714223969633";
    	
    	//App Info, needed for Auth
    	$app_id = "481755348556778";
    	$app_secret = "10cf7c4070fa6e0fffaece8c69e66aec";
    	
    	//Retrieve auth token
    	$authToken = $this->fetch("https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id={$app_id}&client_secret={$app_secret}");
    	$limit=40;
    	$json_object = $this->fetch("https://graph.facebook.com/{$profile_id}/feed?fields=message&limit={$limit}&{$authToken}");
    	$feedarray = json_decode($json_object);
    	$feedarray=$feedarray->data;
    	$feedarray=(Array)$feedarray[rand(1,$limit-1)];
   			if(isset($feedarray['message'])){
   				$this->say($feedarray['message']);
   			}
   			else{
   				$this->say("Intentalo nuevamente :( Me enrede");
   			}
    }
}