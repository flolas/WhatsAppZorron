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
class Ayuda extends \Library\WhatsApp\Module\Base {
 /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = 'ayuda';

    /**
     * The number of arguments the command needs.
     *
     * @var integer
     */
    protected $numberOfArguments = 0;

    /**
     * Sends the arguments to the channel. A random joke.
     *
     * IRC-Syntax: PRIVMSG [#channel]or[user] : [message]
     */
    public function command() {
    	$this->say("Conmigo puedes ver en que sala te toca un ramo, reservar deportes, ver asistencias, etc..");
        $this->say("Puedes decirme:\n!". strtolower(implode( "\n",array_keys($this->bot->modules ))));        
    }
}