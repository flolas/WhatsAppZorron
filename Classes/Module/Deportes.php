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
	protected $help = "Todavia no Implementado.
					   !deportes <asistencias>\n
					   !deportes <reservar> <rut> <#deporte>
					   !deportes <cancelar> <rut> <#deporte>
					   !deportes <ver> <rut>";


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
		
		$message = implode(' ', $this->arguments);
		if( stristr('asistencias',$this->arguments[0]) !== FALSE){
			$this->say('Debes llevar 0 asistencias. Perrito, estamos de vacaciones! :)');
			return;
		}
		elseif(stristr('reservar',$this->arguments[0]) !== FALSE) {			$this->say('Todavia no implementado.');
			return;}
		elseif(stristr('cancelar',$this->arguments[0]) !== FALSE) {			$this->say('Todavia no implementado.');
			return;}
		elseif(stristr('ver',$this->arguments[0]) !== FALSE) {			$this->say('Todavia no implementado.');
			return;}
		else{
			$this->say('Todavia no implementado.');
			return;
		}
		}
	}
