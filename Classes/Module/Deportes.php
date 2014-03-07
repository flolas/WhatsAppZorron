<?php
// Namespace
namespace Module;

/**
 * Modulo para reservar deportes UAI
 *
 * @package WhatsAppBot
 * @subpackage Module
 * 
 * @author flolas <flolas@alumnos.uai.cl>
 */
class Deportes extends \Library\WhatsApp\Module\Base {
	/**
	 * The command's help text.
	 *
	 * @var string
	 */
	protected $help = "Primero debes decirme: deportes key <usuario sin @alumnos.uai.cl> <clave>\n\nEsto te dara una clave que debes guardar y utilizar para reservar deportes :)\ndeportes asistencias <key>\ndeportes ver <key>\ndeportes reservar <Id> <key>\ndeportes cancelar <Id> <key>\ndeportes renovar <Id> <key>\ndeportes estado <key>\n";


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
		if(count($this->arguments) == 0){
		$this->say("Con este comando puedes reservar deportes.\nUsa:".$this->help);
		return;
		}
		if( stristr('asistencias',$args[0]) !== FALSE){
			$r = json_decode($this->fetch('http://api.salasuai.com/sports/assists/key/'.urlencode($args[1])));
			$target_assists=0;
			$this->say("Debes llevar ".$target_assists." asistencias");
				if(isset($r->count_assists)){
					$this->say("Llevas ".$r->count_assists." asistencia a la fecha.");
						if($target_assists == $r->count_assists){
							$this->say("Felicitaciones! vas bien con tus asistencias :)");
						}
				}
				else{
					$this->say("Error :(");
				}
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
			$this->say("Reservando deporte...");
			$r = json_decode($this->fetch('http://api.salasuai.com/sports/reserve/sport/'.urlencode($args[1]).'/key/'.urlencode($args[2])));
			if($r->message ){
				$this->say("No se ha reservado, disculpa :(");
			}
			elseif($r->name){
				$this->say("Deporte:".$r->name."\n".
						"Inicio:".$r->start_time."\n".
						$r->grace_time."\n");
			}
			return;
		}
		
		elseif(stristr('cancelar',$args[0]) !== FALSE) {
			$this->say("Cancelando deporte...");
			$r = json_decode($this->fetch('http://api.salasuai.com/sports/cancel/sport/'.urlencode($args[1]).'/key/'.urlencode($args[2])));
			if($r->message ){
				$this->say("Se cancelo la reserva");
			}
			elseif($r->name){
				$this->say("No se pudo cancelo la reserva :(");
			}
			return;
		}
		elseif(stristr('renovar',$args[0]) !== FALSE) {
			$this->say("Renovando deporte...");
			$r = json_decode($this->fetch('http://api.salasuai.com/sports/renovate/sport/'.urlencode($args[1]).'/key/'.urlencode($args[2])));
				if($r->message ){
					$this->say("No se ha reservado, disculpa :(");
				}
				elseif($r->name){
					$this->say("Deporte:".$r->name."\n".
							"Inicio:".$r->start_time."\n".
							$r->grace_time."\n");
				}
			return;
		}
		elseif(stristr('ver',$args[0]) !== FALSE) {
			$r = json_decode($this->fetch('http://api.salasuai.com/sports/get/key/'.urlencode($args[1])));
			if(!$r->name){
				$this->say("Para reservar el deporte que deseas ahora escribe deportes reservar <Id Deporte> <key>");
			foreach($r as $deporte){
				$this->say("Id:".$deporte->id."\n".
						   "Deporte:".$deporte->name."\n".
						   "Prof:".$deporte->teacher."\n".
						   "Hora:".$deporte->module."\n".
						   "Cupo:".$deporte->quota."\n");
			}
			}
			elseif($r->name){
				$this->say("No hay deportes disponibles para reservar");
			}
			elseif($r->error){
				$this->say("Error :( Intentalo nuevamente o utiliza http://www.salasuai.com/deportes.php");
			}
			return;
		}
		elseif(stristr('estado',$args[0]) !== FALSE) {
			$r = json_decode($this->fetch('http://api.salasuai.com/sports/status/key/'.urlencode($args[1])));
			if($r->message ){
				$this->say("No tienes una reserva activa");
			}
			elseif($r->name){
			$this->say("Deporte:".$r->name."\n".
					   "Inicio:".$r->start_time."\n".
					   $r->grace_time."\n");
			}
			return;
		}
		else{
			$r = $this->help;
			return;
		}
		}
	}
