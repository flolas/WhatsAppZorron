<?php
namespace Library\WhatsApp\Connection;
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
     * @author Daniel Siepmann <coding.layne@me.com>
     */

    /**
     * Delivers a connection via socket to the WhatsApp server.
     *
     * @package WhatsAppBot
     * @subpackage Library
     * @author Daniel Siepmann <Daniel.Siepmann@wfp2.com>
     */
    class Socket implements \Library\WhatsApp\Connection {

        /**
         * The phone with area code
         * @var string
         */
        private $phone = '';

        /**
         * The port of the server you want to connect to.
         * @var integer
         */
        private $identity;

        /**
         * The TCP/IP connection.
         * @var type
         */
        private $password;

        /**
         * The TCP/IP connection.
         * @var type
         */
        private $nickname;
        /**
         * The TCP/IP connection.
         * @var type
         */
        private $ProfilePicture;
        /**
         * The TCP/IP connection.
         * @var type
         */
        private $debug;
        
        /**
         * Close the connection.
         */
        public function __destruct() {
            $this->disconnect();
        }

        /**
         * Establishs the connection to the server.
         */
        public function connect() {
            $this->socket = new WhatsAPI\WhatsProt($this->phone, $this->identity,$this->nickname, $this->debug);
            $this->socket->connect();
            $this->socket->loginWithPassword($this->password);
            $this->socket->sendSetProfilePicture(__DIR__ ."/".$this->ProfilePicture);
            if (!$this->socket) {
                throw new Exception( 'Unable to connect to WhatsApp with phone: "' . $this->phone . '" and identity: "' . $this->identity . '".' );
            }
        }
        public function getData () {
        	//$this->event=new WhatsAPI\onGetMessageEventListener();
        	//$this->socket->eventManager()->addEventListener($this->event);
        	$this->socket->pollMessages();
        return $this->socket->getMessages();
        }
        
        public function bindMessage($process) {
        	return $this->socket->setNewMessageBind($process);
        }
        public function say($phone,$msg) {
        	$this->socket->sendMessage($phone,$msg);
        }

        /**
         * Disconnects from the server.
         *
         * @return boolean True if the connection was closed. False otherwise.
         */
        public function disconnect() {
        	$this->socket->disconnect();
            return false;
        }

        /**
         * Check wether the connection exists.
         *
         * @return boolean True if the connection exists. False otherwise.
         */
        public function isConnected() {

            return true;
        }

        /**
         * Sets the server.
         * E.g. WhatsApp.quakenet.org or WhatsApp.freenode.org
         * @param string $server The server to set.
         */
        public function setPhone( $phone ) {
            $this->phone = (string) $phone;
        }

        /**
         * Sets the port.
         * E.g. 6667
         * @param integer $port The port to set.
         */
        public function setIdentity( $identity ) {
            $this->identity = (string) $identity;
        }
        public function setProfilePicture( $ProfilePicture ) {
        	$this->ProfilePicture = (string)$ProfilePicture;
        }
        /**
         * Sets the port.
         * E.g. 6667
         * @param integer $port The port to set.
         */
        public function setPassword( $password ) {
        	$this->password = (string) $password;
        }
        /**
         * Sets the port.
         * E.g. 6667
         * @param integer $port The port to set.
         */
        public function setNickname( $nickname ) {
        	$this->nickname = (string) $nickname;
        }
        /**
         * Sets the port.
         * E.g. 6667
         * @param integer $port The port to set.
         */
        public function setDebug ($debug ) {
        	$this->debug = (bool)$debug;
        }
        
    }
?>