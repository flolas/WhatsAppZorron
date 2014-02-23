<?php
/**
 * WhatsAppZorron
 *
 * LICENSE: This source file is subject to Creative Commons Attribution
 * 3.0 License that is available through the world-wide-web at the following URI:
 * http://creativecommons.org/licenses/by/3.0/.  Basically you are free to adapt
 * and use this script commercially/non-commercially. My only requirement is that
 * you keep this header as an attribution to my work. Enjoy!
 *
 * @license http://creativecommons.org/licenses/by/3.0/
 *
 * @package WhatsAppZorron
 * @author flolas <flolas@alumnos.uai.cl>
 * @author Felipe Lolas<flolas@alumnos.uai.cl>
 */
namespace Library\WhatsApp;
/**
 * A simple WhatsApp Bot with basic features.
 *
 * @package WhatsAppBot
 * @subpackage Library
 * @author Felipe Lolas <flolas@alumnos.uai.cl>
 * @author Super3 <admin@wildphp.com>
 * @author Daniel Siepmann <coding.layne@me.com>
 */
class Bot {
	/**
	 * Holds the server connection.
	 * @var \Library\WhatsApp\Connection
	 */
	private $connection = null;

	/**
	 * The nick of the bot.
	 * @var string
	 */
	private $nick = '';
	
	/**
	 * The nick of the bot.
	 * @var string
	 */
	private $phone = '';
	/**
	 * Complete file path to the log file.
	 * Configure the path, the filename is generated and added.
	 * @var string
	 */
	private $logFile = '';

	public $commandPrefix = '!';
	/**
	 * All available commands.
	 * Commands are type of WhatsAppCommand
	 * @var array
	 */
	public $modules = array ( );
	
	/**
	 * Holds the reference to the file.
	 * @var type
	 */
	private $logFileHandler = null;
	
	/**
	 * Creates a new WhatsAppBot.
	 *
	 * @param array $configuration The whole configuration, you can use the setters, too.
	 * @return void
	 * @author Felipe Lolas <flolas@alumnos.uai.cl>
	 */
	public function __construct( array $configuration = array ( ) ) {
	
		$this->connection = new \Library\WhatsApp\Connection\Socket;
		$this->moduleManager = new moduleManager($this->connection,$this);
		
		if (count( $configuration ) === 0) {
			return;
		}
	
		$this->setWholeConfiguration( $configuration );
	}
	/**
	 * Cleanup handlers.
	 */
	public function __destruct() {
		if ($this->logFileHandler) {
			fclose( $this->logFileHandler );
		}
	}
	/**
	 * Connects the bot to the server.
	 *
	 * @author Super3 <admin@wildphp.com>
	 * @author Daniel Siepmann <coding.layne@me.com>
	 */
	public function connectToWhatsApp() {
		$this->log( 'Los siguientes Modulos estan disponibles para el Bot: "' . implode( ',', array_keys( $this->modules ) ) . '".', 'INFO' );
		$this->log("Conectando...",'WhatsApp');
		$this->connection->connect();
		$this->connection->bindMessage($this->moduleManager);
		$this->main();
	}
	public function disconnectFromWhatsApp() {
		$this->log("Desconectando...",'WhatsApp');
		$this->connection->disconnect();
	}
	
	/**
	 * This is the workhorse function, grabs the data from the server and displays on the browser
	 *
	 * @author Felipe Lolas
	 *
	 */
	public function main() {
		$this->log("{$this->nick} conectado desde el numero <{$this->phone}>", 'WhatsApp' );
		$this->connection->say('56985273664','Me conecte :)');
	do {
		$command = '';
		$arguments = array ( );
		$this->connection->getData();
	}
	while(true);
	}
	
	// Setters
	
	/**
	 * Sets the whole configuration.
	 *
	 * @param array $configuration The whole configuration, you can use the setters, too.
	 * @author Daniel Siepmann <coding.layne@me.com>
	 */
	private function setWholeConfiguration( array $configuration ) {
		$this->setPhone( $configuration['phone'] );
		$this->setIdentity( $configuration['identity'] );
		$this->setNickname( $configuration['nickname'] );
		$this->setPassword( $configuration['password'] );
		$this->setDebug( $configuration['debug'] );
		$this->setProfilePicture($configuration['profilepicture'] );
		$this->setLogFile( $configuration['logFile'] );
	}
	/**
	 * Sets the server.
	 * E.g. irc.quakenet.org or irc.freenode.org
	 * @param string $server The server to set.
	 */
	public function setPhone( $phone ) {
		$this->connection->setPhone( $phone );
		$this->phone=$phone;
	}
	/**
	*Debug
	*
	*/
	public function setDebug( $debug ) {
		$this->connection->setDebug( $debug );
	}
	public function setProfilePicture( $ProfilePicture ) {
		$this->connection->setProfilePicture( $ProfilePicture );
	}
	/**
	 * Sets the port.
	 * E.g. 6667
	 * @param integer $port The port to set.
	 */
	public function setIdentity( $identity) {
		$this->connection->setIdentity( $identity );
	}
	
	/**
	 * Sets the channel.
	 * E.g. '#testchannel' or array('#testchannel','#helloWorldChannel')
	 * @param string|array $channel The channel as string, or a set of channels as array.
	 */
	public function setPassword( $password ) {
		$this->connection->setPassword( $password );
    }
	
	
	/**
	 * Sets the nick of the bot.
	 * "Yes give me a nick too. I love nicks."
	 *
	 * @param string $nick The nick of the bot.
	 */
	public function setNickname( $nickname ) {
		$this->connection->setNickname( $nickname );
		$this->nick=$nickname;
	}
	/**
	 * Sets the filepath to the log. Specify the folder and a prefix.
	 * E.g. /Users/yourname/logs/ircbot- That will result in a logfile like the following:
	 * /Users/yourname/logs/ircbot-11-12-2012.log
	 *
	 * @param string $logFile The filepath and prefix for a logfile.
	 */
	public function setLogFile( $logFile ) {
		date_default_timezone_set(TIMEZONE);
		$this->logFile = (string) $logFile;
		if (!empty( $this->logFile )) {
			$logFilePath = dirname( $this->logFile );
			if (!is_dir( $logFilePath )) {
				mkdir( $logFilePath, 0777, true );
			}
			$this->logFile .= date( 'H-i-d-m-Y' ) . '.log';
			$this->logFileHandler = fopen( $this->logFile, 'w+' );
		}
	}
	
	public function getModules() {
		return $this->modules;
	}
	
	public function getModulePrefix() {
		return $this->modulePrefix;
	}
	/**
	 * Adds a log entry to the log file.
	 *
	 * @param string $log    The log entry to add.
	 * @param string $status The status, used to prefix the log entry.
	 *
	 * @author Daniel Siepmann <coding.layne@me.com>
	 */
	public function log( $log, $status = '' ) {
		if (empty( $status )) {
			$status = 'LOG';
		}
		$date = date( 'H:i:s d-m-Y' ) ;
		$msg = "({$date})[ " . $status . " ]  ". \Library\FunctionCollection::removeLineBreaks( $log ) . "\r\n" ;
	
		echo $msg;
	
		if (!is_null( $this->logFileHandler )) {
			fwrite( $this->logFileHandler, $msg);
		}
	}
	/**
	 * Adds a single command to the bot.
	 *
	 * @param IRCCommand $command The command to add.
	 * @author Daniel Siepmann <coding.layne@me.com>
	 */
	public function addModule( \Library\WhatsApp\Module\Base $module ) {
		$moduleName = $this->getClassName($module);
		$module->setWhatsAppConnection( $this->connection );
		$module->setWhatsAppBot( $this );
		$this->modules[$moduleName] = $module;
		$this->log( 'El siguiente Modulo se cargo al Bot: "' . $moduleName . '".', 'INFO' );
	}
	public function deleteModule( \Library\WhatsApp\Module\Base $module ) {
		$moduleName = $this->getClassName($module);
		$this->modules[$moduleName] = null;
		$this->log( 'El siguiente Modulo se desactivo al Bot: "' . $moduleName . '".', 'INFO' );
	}
	/**
	 * Returns class name of $object without namespace
	 *
	 * @param mixed $object
	 * @author Matej Velikonja <matej@velikonja.si>
	 * @return string
	 */
	public function getClassName( $object) {
		$objectName = explode( '\\', get_class( $object ) );
		$objectName = $objectName[count( $objectName ) - 1];
	
		return $objectName;
	}
	public function executeCommand( $source, $moduleName, $data ) {
		// Execute command:
		$module = $this->modules[$moduleName];
		$len = strlen($moduleName);
		if (ucfirst(strpos(substr($data['message'],1,$len),$moduleName)!== false && $moduleName!='Misc'))  {
			$data['message'] = substr($data['message'],$len+1);
		}
		$arguments=array_slice(explode(" ",$data['message']),1);
		$module->executeCommand($source, $data,$arguments);
	}
}
