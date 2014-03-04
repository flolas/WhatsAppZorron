<?php
// Namespace
namespace Module;

/**
 * Sends IMDB Info to channel.
 *
 * @package WhatsAppBot
 * @subpackage Module
 * @author NeXxGeN (https://github.com/NeXxGeN)
 * @author flolas <flolas@alumnos.uai.cl>
 */
class Horario extends \Library\WhatsApp\Module\Base {
	/**
	 * The command's help text.
	 *
	 * @var string
	 */
	protected $help = "\nSantiago: horario <ramo a buscar>\n Vina: horario <ramo a buscar> vina";


	/**
	 * The number of arguments the command needs.
	 *
	 * @var integer
	 */
	protected $numberOfArguments = -1;

	/**
	 * Search for IMDB Data, and give response to channel
	 *
	 * IRC-Syntax: PRIVMSG Movie title
	 */
	public function command()
	{
		if(count($this->arguments) == 0){
		$this->say("Con este comando puedes buscar salas.\nUsa:".$this->help);
		return;
		}
		$message = implode(' ', $this->arguments);
		$this->say('Salas UAI: Buscando horarios ️');
		$args = $this->arguments;
		if(stristr((string)$message,'viña') !== FALSE || stristr((string)$message,'vina') !== FALSE) {
		 $l='vina';
		 $message = str_replace("vina", "", $message);
		 $message = str_replace("viña", "", $message);
		}
		else {
		 $l='santiago';
		}
		$getJson = $this->fetch("http://api.salasuai.com/units/location/".urlencode($l)."/search/".urlencode($message));
		$ramos = json_decode($getJson);
		if($ramos){
		$data = "";
		$separator = "";
		foreach($ramos as $ramo){
		while ($i++ < strlen($ramo->name) + 5) {
		$separator = '_'.$separator;
		}
		$data="\t\t️".$ramo->module."️️\t\n".
						mb_strtoupper($ramo->name,'UTF-8')."\n👤".
						ucwords($ramo->teacher)."\n📍".
						$ramo->classroom."\n".$separator."\n".
						$data;
		}
		//if (strlen($data)<=3028){
		$this->say($data);
		//}
		//else {
		//$this->say("Salas UAI: Utiliza un criterio mas especifico. Muchos resultados.");
		//}
		}
		else{
			$this->say('Salas UAI: ⚠No encontre ningun ramo :(');
			$this->say('SalasUAI: Revisa http://www.salasuai.com');
			return;
		}
	}
}