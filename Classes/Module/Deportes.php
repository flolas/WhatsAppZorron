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
			$data = "usr=".$args[1]."&pwd=".$args[2];
			$ch = curl_init('http://api.salasuai.com/sports');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data))
			);
			$r = curl_exec($ch);
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
			$r = $this->fetch('http://api.salasuai.com/sports/get/key/'.urlencode($args[1]));
			return;
		}
		elseif(stristr('estado',$args[0]) !== FALSE) {
			$r = $this->fetch('http://api.salasuai.com/sports/status/key/'.urlencode($args[1]));
			return;
		}
		else{
			$r = $this->help;
			return;
		}
		echo print_r(json_decode($r));
		$this->say(json_decode($r));
		}
	}
