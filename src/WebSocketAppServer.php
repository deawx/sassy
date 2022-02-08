<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace iDimensionz\AppServer;

use Exception;
use iDimensionz\AppServer\Service\ServiceInterface;
use iDimensionz\AppServer\Message\Exception\MessageNotFoundException;
use iDimensionz\AppServer\Server\AbstractAppServer;
use iDimensionz\AppServer\Traits\DebugTrait;
use Ratchet\ConnectionInterface;

class WebSocketAppServer extends AbstractAppServer
{
    use DebugTrait;

//    public const COMMAND_PREFIX = '/';
//
//    private array $availableCommands;

    public function __construct()
    {
        parent::__construct();
//        $this->registerCommands();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        parent::onOpen($conn);
    }

    /**
     * @param string $message
     * @throws Exception
     */
    public function onMessage(ConnectionInterface $from, $message)
    {
        try {
            parent::onMessage($from, $message);
//            $recipientCount = count($this->clients) - 1;
//            $this->debug(sprintf(
//                'Connection %d sending message "%s" to %d other connection%s',
//                $from->resourceId,
//                $message,
//                $recipientCount,
//                $recipientCount == 1 ? '' : 's'
//            ));
//            if (self::COMMAND_PREFIX == substr($message, 0, 1)) {
//                $this->processMessage($from, $message);
//            } else {
//                $encodedChatMessage = $this->createEncodedChatMessage($from, $message);
//                $from->currentTopic->publish($encodedChatMessage);
//                //            $this->addMessage($encodedChatMessage);
//                //            $this->distributeEncodedChatMessage($from, $encodedChatMessage);
//            }
        } catch (MessageNotFoundException $mnf) {
        }
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        parent::onClose($conn);
// @todo Move this to the close event (pre?) listener
//        $message = "Connection {$conn->username} has disconnected";
//        $this->debug($message);
// @todo Move this to the close event (post?) listener
//        $textMessage = new TextBaseMessage($message);
//        TopicManager::getTopic(self::TOPIC_GENERAL)->publish($textMessage);
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        parent::onError($conn, $e);
    }

    /**
     * @param ConnectionInterface $from
     * @param $message
     * @return false|string
     */
//    public function createEncodedChatMessage(ConnectionInterface $from, $message)
//    {
//        $clientUserName = $this->getClientUserName($from);
//        $chatMessage = new TextBaseMessage();
//        $chatMessage->message = $message;
//        $chatMessage->userName = $clientUserName;
//
////        return json_encode($chatMessage);
//        return $chatMessage;
//    }

    /**
     * @param $message
     * @return false|string
     */
//    public function createEncodedSystemChatMessage($message)
//    {
//        $chatMessage = new SystemMessage();
//        $chatMessage->message = $message;
//        $chatMessage->userName = self::USER_NAME_SYSTEM;
//
////        return $chatMessage;
//        return json_encode($chatMessage);
//    }

    /**
     * Sends a message to all connections.
     * @param ConnectionInterface $from
     * @param string $encodedChatMessage
     * @param bool $skipSender  Skips sending the message back to the sender when true.
     */
//    public function distributeEncodedChatMessage(
//        ConnectionInterface $from,
//        string $encodedChatMessage,
//        bool $skipSender = true
//    ): void {
//        /**
//         * @var ConnectionInterface $client
//         */
//        foreach ($this->clients as $client) {
//            if (!$skipSender || $from !== $client) {
//                // The sender is not the receiver, send to each client connected
//                $client->send($encodedChatMessage);
//            }
//        }
//    }

    /**
     * Get the client's username from the meta-data added to the matching connection.
     */
//    protected function getClientUserName(ConnectionInterface $from): string
//    {
//        $clientUserName = '';
//        // Find the matching connection.
//        foreach ($this->getClients() as $client) {
//            $this->debug($client->resourceId);
//            if ($from == $client) {
//                $this->debug("Found match!");
//                $clientUserName = $client->username;
//                $this->debug("Match's username: $clientUserName");
//            }
//        }
//        //        $client = $this->clients->offsetGet($from);
//        return $clientUserName;
//    }

    /**
     * Update username in messages for a particular user.
     * @param string $previousUserName
     * @param string $newUserName
     */
//    public function updateUserNameInMessages(string $previousUserName, string $newUserName)
//    {
//        foreach ($this->getMessages() as $key => $message) {
//            $chatMessage = json_decode($message);
//            if ($previousUserName == $chatMessage->userName) {
//                $chatMessage->userName = $newUserName;
//                $message = json_encode($chatMessage);
//                $this->messages[$key] = $message;
//            }
//        }
//    }

    /**
     * @deprecated Use registerMessages() instead
     */
//    protected function registerCommands()
//    {
//        // @todo Iterate through the classes in Command dir and register each class that implements ServiceInterface.
//        $this->addAvailableCommand(new NameCommand($this));
//        $this->addAvailableCommand(new DebugCommand($this));
//        $this->addAvailableCommand(new TopicService($this));
//    }

    /**
     * @todo Move this to chat server.
     * @return array
     */
//    public function getMessages(): array
//    {
//        return $this->messages;
//    }

    /**
     * @todo Move this to chat server
     * @param string $message
     */
//    protected function addMessage(string $message)
//    {
//        $this->messages[] = $message;
//    }

    /**
     * @return array
     */
//    protected function getAvailableCommands(): array
//    {
//        return $this->availableCommands;
//    }

    /**
     * @param array $availableCommands
     */
//    public function setAvailableCommands(array $availableCommands): void
//    {
//        $this->availableCommands = $availableCommands;
//    }

    /**
     * @param ServiceInterface $availableCommand
     */
//    protected function addAvailableCommand(ServiceInterface $availableCommand)
//    {
//        $this->availableCommands[$availableCommand::getCommandName()] = $availableCommand;
//    }
}
