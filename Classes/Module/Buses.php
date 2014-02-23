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
class Buses extends \Library\WhatsApp\Module\Base {

	/**
	 * The command's help text.
	 *
	 * @var string
	 */
	protected $help = '!buses <hacia/desde> <Lugar>\n
					   !buses <hacia/desde> proximos\n
					   Para Vina: !buses <Lugar> <hacia/desde> vina\n
							      !buses proximos <hacia/desde> vina\n';

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
		$args = $this->arguments;
		$l='santiago';
			if(stristr((string)$args[2],'vina') !== FALSE) {
				 $l='vina';
				 $args[2] = str_replace("vina", "", $args[2]);
			}
				if( stristr('proximo',$args[1]) !== FALSE){
						$getJson = $this->fetch("http://api.salasuai.com/buses/location/".$l."/".$args[0]."/upcoming/1000");
						$data=json_decode($getJson);
						$h="";
						foreach($data as $prox){
						$h="Un bus a las {$prox->static_time}. Tiempo de llegada:Ê{$prox->diff_time_min}";
						}
						$this->say("Buses\n".$h);
				}
				else{
						$getJson = $this->fetch("http://api.salasuai.com/buses/location/".$l."/".$args[0]."/".$args[1]);
						$data=json_decode($getJson);
						$h="";
						foreach($data as $hora){
						$h="\n".$hora.$h;
						}
						$this->say("Buses\n".$h);
				}
		
    }
}