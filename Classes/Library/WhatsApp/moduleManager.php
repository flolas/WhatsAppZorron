<?php
/**
 * WhatsApp Bot
 *
 * LICENSE: This source file is subject to Creative Commons Attribution
 * 3.0 License that is available through the world-wide-web at the following URI:
 * http://creativecommons.org/licenses/by/3.0/.  Basically you are free to adapt
 * and use this script commercially/non-commercially. My only requirement is that
 * you keep this header as an attribution to my work. Enjoy!
 *
 * @license    http://creativecommons.org/licenses/by/3.0/
 *
 * @package WhatsAppBot
 * @subpackage Library
 *
 * @encoding UTF-8
 * @created Jan 11, 2012 11:02:00 PM
 *
 * @author Felipe Lolas
 */

namespace Library\WhatsApp;
class moduleManager
{
	protected $connection = false;
	protected $bot = false;
	
	public function __construct($connection,$bot)
	{
		$this->connection = $connection;
		$this->bot =$bot;
	}

	/**
	 * @param ProtocolNode $node
	 */
	public function process($node)
	{
		$attr = $node->getAttributes();
		$from =$node->getChild('notify')->getAttributes();
		$from=$from['name'];
		$msg = $node->getChild('body')->getData();
		$phone =explode('@',$attr['from']);
		$phone = $phone[0];
		$data = array('phone'=>$phone,
					  'name'=>$from,
					  'type'=>$attr['type'],
					  'message'=>$msg,
					  );
		if(!$data){$this->bot->log("moduleManager didn't recieved anything.".$node,"FATAL ERROR");return false;}
		$output = "{$data['name']}<{$data['phone']}> : {$data['message']}" ;
		$this->bot->log($output,"Message");
		// Check if the response was a command.
		
		if(!isset($this->bot->commandPrefix)){
			$dataexp=explode(" ",$data['message']);
			$command = ucfirst($dataexp[0]);
			if (!array_key_exists( $command, $this->bot->modules )) {
					$this->bot->executeCommand($data['phone'],'Misc',Array("type"=>$data['type'],"name"=>$data['name'],"message"=>$data['message']));
					return false;
			}
			$this->bot->executeCommand($data['phone'],$command, Array("type"=>$data['type'],"name"=>$data['name'],"message"=>$data['message']));
		}
		else{
		if (stripos( $data['message'], $this->bot->commandPrefix ) === 0) {
			$dataexp=explode(" ",$data['message']);
			$command = ucfirst(substr($dataexp[0],1));
			
			
			if (!array_key_exists( $command, $this->bot->modules )) {
					$this->connection->say($data['phone'],"El comando no existe :(.\nEscribe !ayuda para mas informacion.");
					$this->bot->log( 'The following, not existing, command was called: "' . $command . '".', 'MISSING' );
					$this->bot->log( 'The following commands are known by the bot: "' . implode( ',', array_keys( $this->bot->modules ) ) . '".', 'MISSING' );
				return false;
			}
			$this->bot->executeCommand($data['phone'],$command, Array("type"=>$data['type'],"name"=>$data['name'],"message"=>$data['message']));
				
		}
		else 
		{
		$this->bot->executeCommand($data['phone'],'Misc',Array("type"=>$data['type'],"name"=>$data['name'],"message"=>$data['message']));
		}		
		}
		
	return true;
	}

}