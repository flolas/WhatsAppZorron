<?php
// Namespace
namespace Module;

/**
 * Modulo para chistes
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
    protected $help = 'Chiste para un chiste aleatorio, Chiste <tu chiste> para mandar uno :)';

    /**
     * The number of arguments the command needs.
     *
     * @var integer
     */
    protected $numberOfArguments = 0;

    public function command() {

        $data = $this->fetch("http://api.icndb.com/jokes/random");

        // ICNDB has escaped slashes in JSON response.
        $data = stripslashes($data);

        $joke = json_decode($data);
		$this->say("Buscando un chiste fome en inglés...");
		//$this->say("¡Manda tu chiste! Simplemente escribe Chiste <tu chiste aca> para hacerlo.")
        if ($joke) {
            if (isset($joke->value->joke)) {
                $this->say(html_entity_decode($joke->value->joke));
                return;
            }
        }

        $this->say("Estoy triste, no estoy para chistes :(");
    }
}