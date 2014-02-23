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
class Deportes extends \Library\WhatsApp\Module\Base {
	/**
	 * The command's help text.
	 *
	 * @var string
	 */
	protected $help = "Primero debes utilizar este comando: !deportes key <usr> <pwd>\n
					   \nEsto te dara una clave que debes guardar y utilizar para reservar deportes :)
					   !deportes asistencias <key>\n
					   !deportes ver <key>\n
					   !deportes reservar <#deporte> <key>\n
					   !deportes cancelar <#deporte> <key>\n
					   !deportes renovar <#deporte> <key>\n
					   !deportes estado <key>\n";


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
		$args = $this->arguments;
		if( stristr('asistencias',$args[0]) !== FALSE){
			$r = 'Debes llevar 0 asistencias. Perrito, estamos de vacaciones! :)';
			return;
		}
		elseif(stristr('key',$args[0]) !== FALSE) {
			$this->say("Obteniendo tu key...");
			$data = "usr=".$args[1]."&pwd=".$args[2];
			$ch = curl_init('http://api.salasuai.com/sports');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data))
			);
			$r = json_decode(curl_exec($ch));
			if(isset($r->key)){
				$this->say("Tu key es:");
				$this->say($r->key);
				sleep(1);
				$this->say("Guardala bien, pues se ocupa para reservar/cancelar deportes.\n Si se te pierde la puedes conseguir denuevo utilizando el mismo comando");
				$this->say("Escribe !deportes ver <tu key> para ver los deportes disponibles :).");
			}
			else {
				$this->say("Te equivocaste en tu usuario o clave :(");
			}
			
			return;
		}
		elseif(stristr('reservar',$args[0]) !== FALSE) {
			$r = $this->fetch('http://api.salasuai.com/sports/reserve/sport/'.urlencode($args[1]).'/key/'.urlencode($args[2]));
			return;
		}
		
		elseif(stristr('cancelar',$args[0]) !== FALSE) {
			$r = $this->fetch('http://api.salasuai.com/sports/cancel/sport/'.urlencode($args[1]).'/key/'.urlencode($args[2]));
			return;
		}
		elseif(stristr('renovar',$args[0]) !== FALSE) {
			$r = $this->fetch('http://api.salasuai.com/sports/renovate/sport/'.urlencode($args[1]).'/key/'.urlencode($args[2]));
			return;
		}
		elseif(stristr('ver',$args[0]) !== FALSE) {
			$r = json_decode($this->fetch('http://api.salasuai.com/sports/get/key/'.urlencode($args[1])));
			if(!$r->name){
			foreach($r as $deporte){
				$this->say($deporte->module."\n".
						   $deporte->id."\n".
						   $deporte->name."\n".
						   $deporte->teacher."\n".
						   $deporte->quota."\n");
			}
			}
			elseif($r->name){
				$this->say("No hay deportes disponibles para reservar");
			}
			else{
				$this->say("Error :(");
			}
			return;
		}
		elseif(stristr('estado',$args[0]) !== FALSE) {
			$r = json_decode($this->fetch('http://api.salasuai.com/sports/status/key/'.urlencode($args[1])));
			if($r->message ){
				$this->say("No tienes una reserva activa");
			}
			return;
		}
		else{
			$r = $this->help;
			return;
		}
		}
	}
