<?php

/*
 * Copyright (c) 2022 by iDimensionz. All rights reserved.
 */

namespace Tests;

use DateTime;
use iDimensionz\AppServer\Server\AbstractAppServer;
use Phake;
use PHPUnit\Framework\TestCase;
use Ratchet\ConnectionInterface;
use SplObjectStorage;

class WebSocketAppServerUnitTest extends TestCase
{
    /**
     * @var WebSocketAppServerTestStub
     */
    private $webSocketAppServer;
    /**
     * @var ConnectionInterface|\Phake_IMock
     */
    private $mockConnection;
    /**
     * @var int
     */
    private $validResourceId;
    /**
     * @var SplObjectStorage
     */
    private $mockClients;
    private $validSentDate;

    public function setUp(): void
    {
        $this->validSentDate = (new DateTime())->format('Y-m-d h:i:s a');
        $this->mockClients = new SplObjectStorage();
        $this->validResourceId = 123;
        parent::setUp();
        $this->webSocketAppServer = new WebSocketAppServerTestStub();
    }

    public function tearDown(): void
    {
        unset($this->mockClients);
        unset($this->webSocketAppServer);
        parent::tearDown();
    }

    public function testConstants()
    {
        $this->assertSame('Sassy App Server', AbstractAppServer::USER_NAME_SYSTEM);
    }

    public function testConstruct()
    {
        // Validate clients
        $actualClients = $this->webSocketAppServer->getClients();
        $this->assertInstanceOf(SplObjectStorage::class, $actualClients);
        $this->assertSame(0, $actualClients->count());
    }

//    public function testCreateEncodedSystemChatMessage()
//    {
//        $this->hasConnection();
//        $validMessage = 'This is a test message';
//        $actualValue = $this->WebSocketAppServer->createEncodedSystemChatMessage($validMessage);
//        $this->assertChatMessage(
//            ChatMessage::MESSAGE_TYPE_TEXT,
//            true,
//            $validMessage,
//            WebSocketAppServer::USER_NAME_SYSTEM,
//            $actualValue
//        );
//    }
//
//    public function testDistributeEncodedChatMessageSendsMessageToAllClientsWhenSkipSenderIsFalse()
//    {
//        $skipSender = false;
//        $this->hasConnection();
//        $this->hasClients();
//        $sender = $this->mockConnection;
//        $validMessage = $this->hasEncodedChatMessage($sender, 'some message');
//        $this->WebSocketAppServer->distributeEncodedChatMessage($sender, $validMessage, $skipSender);
//        $this->assertMessageSentToClients($validMessage, $skipSender);
//    }

//    public function testDistributeEncodedChatMessageSendsMessageToAllClientsExceptSenderWhenSkipSenderIsTrue()
//    {
//        $skipSender = true;
//        $this->hasConnection();
//        $this->hasClients();
//        $sender = $this->mockConnection;
//        $validMessage = $this->hasEncodedChatMessage($sender, 'some message');
//        $this->WebSocketAppServer->distributeEncodedChatMessage($sender, $validMessage, $skipSender);
//        $this->assertMessageSentToClients($validMessage, $skipSender);
//    }
//
    public function testOnOpenDoesNotSendMessageToConnectionWhenNoMessages()
    {
        $this->markTestSkipped();
        $this->hasConnection();
        $this->webSocketAppServer->onOpen($this->mockConnection);
        /**
         * @var ConnectionInterface $verifierProxy
         */
        $verifierProxy = Phake::verify($this->mockConnection, Phake::times(0));
        $verifierProxy->send(Phake::anyParameters());
    }

    public function testOnOpenSendsMessagesToConnectionWhenMessagesExist()
    {
        $this->markTestIncomplete();
//        $this->hasConnection();
//        $validMessages = [
//            'message 1',
//            'message 2'
//        ];
//        $this->webSocketAppServer->setMessages($validMessages);
//        $this->webSocketAppServer->onOpen($this->mockConnection);
//        /**
//         * @var ConnectionInterface $verifierProxy
//         */
//        $verifierProxy = \Phake::verify($this->mockConnection, \Phake::times(count($validMessages)));
//        $verifierProxy->send(\Phake::anyParameters());
    }

//    public function testCreateEncodedChatMessage()
//    {
//        $this->hasConnection();
//        $this->hasClients();
//        $validMessage = 'This is a test message';
//        $actualValue = $this->WebSocketAppServer->createEncodedChatMessage($this->mockConnection, $validMessage);
//        $this->assertChatMessage(
//            ChatMessage::MESSAGE_TYPE_TEXT,
//            false,
//            $validMessage,
//            $this->mockConnection->username,
//            $actualValue
//        );
//
//    }
//
    /**
     * @throws \Exception
     */
//    public function testOnClose()
//    {
//        $this->hasConnection();
//        $this->hasClients();
//        $preCloseExistence = $this->mockClients->offsetExists($this->mockConnection);
//        $this->assertTrue($preCloseExistence);
//        $this->WebSocketAppServer->onClose($this->mockConnection);
//        $postCloseExistence = $this->mockClients->offsetExists($this->mockConnection);
//        $this->assertFalse($postCloseExistence);
//        $expectedMessage = $this->hasEncodedChatMessage($this->mockConnection, "Connection {$this->mockConnection->username} has disconnected", true);
//        $this->assertMessageSentToClients($expectedMessage, true);
//    }

    /**
     * @throws \Exception
     */
    public function testOnError()
    {
        $this->hasConnection();
        $this->webSocketAppServer->onError($this->mockConnection, new \Exception());
        /**
         * @var ConnectionInterface $verifierProxy
         */
        $verifierProxy = Phake::verify($this->mockConnection, Phake::times(1));
        $verifierProxy->close();
    }

//    public function testUpdateUserNameInMessages()
//    {
//        $this->hasConnection();
//        $validMessage = 'Some valid message';
//        $validNewUserName = 'New User Name';
//        $encodedMessage = $this->hasEncodedChatMessage($this->mockConnection, $validMessage);
//        $this->WebSocketAppServer->addMessage($encodedMessage);
//        $preUpdateMessages = $this->WebSocketAppServer->getMessages();
//        $preUpdateMessage = $preUpdateMessages[0];
//        $preUpdateMessageArray = json_decode($preUpdateMessage, true);
//        $this->assertSame($this->mockConnection->username, $preUpdateMessageArray['userName']);
//
//        $this->WebSocketAppServer->updateUserNameInMessages($this->mockConnection->username, $validNewUserName);
//
//        $postUpdateMessages = $this->WebSocketAppServer->getMessages();
//        $postUpdateMessage = $postUpdateMessages[0];
//        $postUpdateMessageArray = json_decode($postUpdateMessage, true);
//        $this->assertSame($validNewUserName, $postUpdateMessageArray['userName']);
//    }
//
    protected function hasConnection(): void
    {
        $this->mockConnection = Phake::mock(ConnectionTestStub::class);
        $this->mockConnection->resourceId = $this->validResourceId;
        $this->mockConnection->username = 'User ' . $this->validResourceId;
    }

    /**
     * @param ConnectionInterface $mockConnection
     * @param string $message
     * @param bool $isSystemEncodedChatMessage
     * @return false|string
     */
//    private function hasEncodedChatMessage(ConnectionInterface $mockConnection, string $message, bool $isSystemEncodedChatMessage = false)
//    {
//        $userName = $isSystemEncodedChatMessage ? WebSocketAppServer::USER_NAME_SYSTEM : $mockConnection->username;
//        return json_encode(
//            [
//                'messageType' => ChatMessage::MESSAGE_TYPE_TEXT,
//                'message' => $message,
//                'sentDate' => $this->validSentDate,
//                'isSystemMessage' => $isSystemEncodedChatMessage,
//                'userName' => $userName,
//            ]
//        );
//    }
//
    /**
     * @param string $validMessage
     * @param bool $skipSender
     */
    protected function assertMessageSentToClients(string $validMessage, $skipSender = true): void
    {
        /**
         * @var \Phake_IMock $mockClient
         */
        foreach ($this->mockClients as $mockClient) {
            if (!$skipSender || $this->mockConnection != $mockClient) {
                /**
                 * @var ConnectionInterface $verifierProxy
                 */
                $verifierProxy = Phake::verify($mockClient, Phake::times(1));
                $verifierProxy->send($validMessage);
            }
        }
        if (!$skipSender) {
            /**
             * @var ConnectionInterface $verifierProxy
             */
            $verifierProxy = Phake::verify($this->mockConnection, Phake::times(1));
            $verifierProxy->send($validMessage);
        }
    }

    /**
     * @param string $expectedMessageType
     * @param string $expectedUserName
     * @param string $expectedMessage
     * @param bool $expectedIsSystemMessage
     * @param string $actualValue
     */
    protected function assertChatMessage(
        string $expectedMessageType,
        bool $expectedIsSystemMessage,
        string $expectedMessage,
        string $expectedUserName,
        string $actualValue
    ): void
    {
        $this->assertIsString($actualValue);
        $actualArray = json_decode($actualValue, true);
        $this->assertTrue(isset($actualArray['messageType']));
        $this->assertSame($expectedMessageType, $actualArray['messageType']);
        $this->assertTrue(isset($actualArray['isSystemMessage']));
        $this->assertSame($expectedIsSystemMessage, $actualArray['isSystemMessage']);
        $this->assertTrue(isset($actualArray['message']));
        $this->assertSame($expectedMessage, $actualArray['message']);
        $this->assertTrue(isset($actualArray['userName']));
        $this->assertSame($expectedUserName, $actualArray['userName']);
        $this->assertTrue(isset($actualArray['sentDate']));
        $this->assertSame($this->validSentDate, $actualArray['sentDate']);
    }
}
