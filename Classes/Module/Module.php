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
class Module extends \Library\WhatsApp\Module\Base {

	/**
	 * The command's help text.
	 *
	 * @var string
	 */
	protected $help = 'module <module name> <action> <password>';

	/**
	 * The number of arguments the command needs.
	 *
	 * @var integer
	 */
	protected $numberOfArguments = 3;
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
    $args = $this->arguments;
    $args[0]=ucfirst($args[0]);
    	if($args[2]==MPASS){
    		$config = include(ROOT_DIR . '/config.php');
    			foreach($config['modules'] as $_moduleName => $_args){
    				if($_moduleName=="Module\\".$args[0]){
    					$moduleName=$_moduleName;
    					$arg= $_args;
    					break;
    				}
    			}
    		if (!isset($moduleName)){
    			$this->say("Error de comando");
    			return;
    		}
 			switch($args[1]) {
 				case 'load':
 						foreach($this->bot->modules as $module=>$argss) {
							if($moduleName == "Module\\".$module){
								$this->say('El modulo ya esta cargado, cueck.');
								return;
							}
 						}
 					$this->say("Cargando modulo ".$args[0]);
 						if(!class_exists($moduleName)){
								require(__DIR__."/".substr($moduleName,7).".php");
						}
 					$reflector = new \ReflectionClass($moduleName);
					$module = $reflector->newInstanceArgs($arg);
					$this->bot->addModule($module);
 				break;
 			
 				case 'unload':
 					foreach($this->bot->modules as $modules=>$argsss){
 						if($moduleName == "Module\\".$modules){
 							$this->say("Desactivando modulo ".$args[0]);
 							$reflector = new \ReflectionClass($moduleName);
							$module = $reflector->newInstanceArgs($arg);
 							$this->bot->deleteModule($module);
 							$_unloaded=TRUE;
 						}
 					}
 				if(!isset($_unloaded)){
 						$this->say('El modulo no esta cargado, cueck');
 						}
 				break;
 				
 				default:
 				$this->say("Error de comando.");
 			}
 		}
    	else
    	{
    		$this->bot->log("Unauthorized access from {$this->name}<{$this->source}>");
    		$this->say("No puedes hacer esto pequeno zorron.");
    	}
   		
	}
}