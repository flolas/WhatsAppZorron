<?php
// Namespace
namespace Module;

/**
 * Sends IMDB Info
 *
 * @package WhatsAppBot
 * @subpackage Module
 * @author NeXxGeN (https://github.com/NeXxGeN)
 * @author flolas <flolas@alumnos.uai.cl>
 */
class Imdb extends \Library\WhatsApp\Module\Base {
	/**
	 * The command's help text.
	 *
	 * @var string
	 */
	protected $help = '!imdb [titulo de la pelicula]';

	private $apiUri = 'http://www.omdbapi.com/?t=%s&';

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
		
		$imdbTitle = implode(' ', $this->arguments);
		$imdbTitle = preg_replace('/\s\s+/', ' ', $imdbTitle);
		$imdbTitle = trim($imdbTitle);
		$imdbTitle = urlencode($imdbTitle);

		if (!strlen($imdbTitle)) {
			$this->say(sprintf('Ingresa el nombre de una pelicula. (Usa: !imdb [nombre pelicula])'));
			return;
		}
		$this->say('IMDB: Buscando pelicula...');
		$apiUri  = sprintf($this->apiUri, $imdbTitle);
		$getJson = $this->fetch($apiUri);

		$json = json_decode($getJson, true);

		$title     = $json['Title'];
		$plot     = $json['Plot'];
		$rating    = $json['imdbRating'];
		$imdbUrl   = "http://www.imdb.com/title/".$json['imdbID'];

		/*
		 * Check if response is given
		*/
		if (!strlen($title)) {
			$this->say('IMDB: Error de la pagina.');
			return;
		}

		$this->say(sprintf('Titulo: %s | Rating: %s | %s', $title, $rating, $imdbUrl));
	}
}