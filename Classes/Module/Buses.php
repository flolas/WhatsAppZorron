<?php
// Namespace
namespace Module;

/**
 * Buses UAI desde la api de salas UAI
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
	protected $help = "\nbuses hacia/desde <Lugar>\nbuses hacia/desde <Lugar> proximos\nPara Vina: buses <Lugar> hacia/desde vina\nbuses proximos hacia/desde vina\n";

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
    	if(count($this->arguments) == 0){
		$this->say("Con este comando puedes ver las horas de los buses.\nUsa:".$this->help);
		return;
		}
		$l='santiago';
			if(stristr((string)$args[2],'vina') !== FALSE && $args[3]) {
				 $l='vina';
				 $args[2] = str_replace("vina", "", $args[3]);
			}
			if($args[0]=='hacia' && $args[0]){
				$args[0]='to';
			}
			else{
				$args[0]='from';
			}
				if( stristr('proximos',$args[2]) !== FALSE && $args[1]){
						$getJson = $this->fetch("http://api.salasuai.com/buses/location/".$l."/".$args[0]."/".$args[1]."/upcoming/1000");
						$data=json_decode($getJson);
						$h="";
						foreach($data as $prox) {
						$h="🚍🕗".$prox->static_time."\n⌛Llega en ".$prox->diff_time_min." minutos \n ________________ \n.$h;
						}
						if($h=="\n" || $h==""){
							$this->say("No te entiendo :(. Ejemplo de uso: Buses hacia Grecia proximos");
							return true;
						}
						$this->say("Buses\n".$h);
    			}
				elseif ($args[0]){
						$getJson = $this->fetch("http://api.salasuai.com/buses/location/".$l."/".$args[0]."/".$args[1]);						$data=json_decode($getJson);
						$h="";
						foreach($data as $hora){
						$h="\n".$hora.$h;
						}
						if($h=="\n" || $h==""){
							$this->say("No te entiendo :(. Ejemplo de uso: Buses hacia Grecia");
							return true;
						}
						$this->say("Buses\n".$h);
				}
				else{
					$this->say("Error, intentalo nuevamente :(.");
				}
		
    }
}
