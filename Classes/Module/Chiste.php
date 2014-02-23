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
class Chiste extends \Library\WhatsApp\Module\Base {
 /**
     * The command's help text.
     *
     * @var string
     */
    protected $help = '!chiste';

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

        $data = $this->fetch("http://api.icndb.com/jokes/random");

        // ICNDB has escaped slashes in JSON response.
        $data = stripslashes($data);

        $joke = json_decode($data);

        if ($joke) {
            if (isset($joke->value->joke)) {
                $this->say(html_entity_decode($joke->value->joke));
                return;
            }
        }

        $this->say("Estoy triste, no estoy para chistes :(");
    }
}