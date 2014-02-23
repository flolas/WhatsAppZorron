<?php
/**
 * IRC Bot
*
* LICENSE: This source file is subject to Creative Commons Attribution
* 3.0 License that is available through the world-wide-web at the following URI:
* http://creativecommons.org/licenses/by/3.0/.  Basically you are free to adapt
* and use this script commercially/non-commercially. My only requirement is that
* you keep this header as an attribution to my work. Enjoy!
*
* @license    http://creativecommons.org/licenses/by/3.0/
*
* @package IRCBot
* @subpackage Interface
*
* @encoding UTF-8
* @created 11.01.2012
*
* @author Daniel Siepmann <coding.layne@me.com>
*/

namespace Library\WhatsApp;

/**
 * Interface for irc connection.
 * Defines how to connect and communicate with the irc server.
 *
 * @package IRCBot
 * @subpackage Interface
 *
 * @author Daniel Siepmann <coding.layne@me.com>
 */
interface Connection {

	/**
	 * Establishs the connection to the server.
	 */
	public function connect();

	/**
	 * Disconnects from the server.
	 *
	 * @return boolean True if the connection was closed. False otherwise.
	*/
	public function disconnect();


}
?>