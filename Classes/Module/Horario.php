<?php
// Namespace
namespace Module;

/**
 * Horarios UAI para vina y santiago desde api salas uai
 *
 * @package WhatsAppBot
 * @subpackage Module
 * 
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
		$i=0;
		$separator=null;
		while ($i < strlen($ramo->name)) {
		$separator = '_'.$separator;
		$i++;
		}
		if($ramo->section){$ramo->section="-";}
		$data="\t\t🕐".$ramo->module."🕐\t\n🎓".
						mb_strtoupper($ramo->name,'UTF-8')."🎓\n📚Sec:".$ramo->section."\n👤".
						ucwords($ramo->teacher)."\n🚪".
						$ramo->classroom."\n".$separator."\n".
						$data;
		}
		if (strlen($data)<=3028){
		$this->say($data);
		}
		else {
		$this->say("Salas UAI: Utiliza un criterio mas especifico. Muchos resultados.");
		}
		}
		else{
			$this->say('SalasUAI: ⚠No encontre ningun ramo :(');
			$this->say('SalasUAI: Revisa http://www.salasuai.com');
			$this->say('Ejemplo de Uso: horario contabilidad, horario electro');
			return;
		}
	}
}