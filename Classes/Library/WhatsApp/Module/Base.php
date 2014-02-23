<?php
namespace Library\WhatsApp\Module;
abstract class Base{

	/**
	 * Reference to the IRC Connection.
	 * @var \Library\IRC\Connection
	 */
	protected $connection = null;

	/**
	 * Reference to the IRC Bot
	 * @var \Lirary\IRC\Bot
	 */
	protected $bot = null;
	/**
	 * Contains all given arguments.
	 * @var array
	 */
	protected $arguments = array ( );
	/**
	 * The number of arguments the command needs.
	 *
	 * You have to define this in the command.
	 *
	 * @var integer
	 */
	protected $numberOfArguments = 0;

	/**
	 * The help string, shown to the user if he calls the command with wrong parameters.
	 *
	 * You have to define this in the command.
	 *
	 * @var string
	 */
	protected $help = '';
	/**
	 * Contains message
	 * @var string
	 */
	protected $message = null;
	/**
	 * Contains command
	 * @var string
	 */
	protected $type = null;
	/**
	 * Contains command
	 * @var string
	 */
	protected $from = null;
	/**
	 * Contains channel or user name
	 *
	 * @var string
	*/
	protected $source = null;

	/**
	 * Original request from server
	 *
	 * @var string
	 */
	private $data;
	public function __construct(){
	}

	/**
	 * Executes the command.
	 *
	 * @param array           $arguments The assigned arguments.
	 * @param string          $source    Originating request
	 * @param string          $data      Original data from server
	 */
	public function executeCommand( $source, $data,$arguments) {
		// Set source
		$this->source = $source;
		// Set data
		$this->from = $data['name'];
		$this->message=$data['message'];
		$this->type = $data['type'];
		if ($this->numberOfArguments != -1 && count($arguments) != $this->numberOfArguments) {
			// Show help text.
			$this->say('No te entiendo zorron. Usa: ' . $this->getHelp());
		}
		else {
			// Execute the command.
			$this->arguments = $arguments;
			$this->command();
		}
		}
		/**
		 * Sends PRIVMSG to source with $msg
		 *
		 * @param string $msg
		 */
		protected function say($msg) {

			$this->bot->log("<to:{$this->source}>{$msg}",$this->bot->getClassName($this));
			$this->connection->say($this->source,$msg);
		}
		/**
		 * Overwrite this method for your needs.
		 * This method is called if the command get's executed.
		 */
		public function command() {
			echo 'fail';
			flush();
			throw new Exception( 'You have to overwrite the "command" method and the "executeCommand". Call the parent "executeCommand" and execute your custom "command".' );
		}

		/**
		 * Set's the IRC Connection, so we can use it to send data to the server.
		 * @param \Library\IRC\Connection $ircConnection
		 */
		public function setWhatsAppConnection( \Library\WhatsApp\Connection $WhatsAppConnection ) {
			$this->connection = $WhatsAppConnection;
		}

		/**
		 * Set's the WhatsAppBot , so we can use it to send data to the server.
		 *
		 * @param \Library\WhatsApp\Bot $WhatsAppBot 
		 */
		public function setWhatsAppBot( \Library\WhatsApp\Bot $WhatsAppBot ) {
			$this->bot = $WhatsAppBot;
		}
		private function getHelp() {
			return $this->help;
		}
		/**
		 * Fetches data from $uri
		 *
		 * @param string $uri
		 * @return string
		 */
		protected function fetch($uri) {

			//$this->bot->log("Fetching from URI: " . $uri);

			// create curl resource
			$ch = curl_init();

			// set url
			curl_setopt($ch, CURLOPT_URL, $uri);

			//return the transfer as a string
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);

			// $output contains the output string
			$output = curl_exec($ch);

			// close curl resource to free up system resources
			curl_close($ch);

			//$this->bot->log("Data fetched: " . $output);

			return $output;
		}
		}

