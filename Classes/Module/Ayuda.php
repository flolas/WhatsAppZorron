<?php
// Namespace
namespace Module;

/**
 * Help Module
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
        sleep(2);
        $modules_users=array_keys($this->bot->modules);
        unset($modules_users['Restart']);
        unset($modules_users['Misc']);
        unset($modules_users['Module']);
        unset($modules_users['Quit']);
        unset($modules_users['Ayuda']);
    	$this->say("Dime que necesitas! Esto puedes decirme:\n". strtolower(implode( "\n", $modules_users)));        
    }
}