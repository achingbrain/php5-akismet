<?php

require_once 'PHPUnit/Framework.php';
require_once 'src/main/php/' . str_replace('.','/','net.achingbrain').'/Akismet.class.php';

class AkismetTest extends PHPUnit_Framework_TestCase {
	private $akismet;
	private $requestFactory;

	protected function setUp() {
		$this->requestFactory = new MockRequestFactory();

		$this->akismet = new Akismet('', '');
		$this->akismet->setRequestFactory($this->requestFactory);
	}

	function testIsKeyValid_validKey() {
		$this->requestFactory->setResponse("\r\n\r\nvalid");
		$response = $this->akismet->isKeyValid();
		$this->assertTrue($response);
	}

	function testIsKeyValid_invalidKey() {
		$this->requestFactory->setResponse("\r\n\r\ninvalid");
		$response = $this->akismet->isKeyValid();
		$this->assertFalse($response);
	}

	function testIsCommentSpam() {
		$this->requestFactory->setResponse("\r\n\r\ntrue");
		$response = $this->akismet->isCommentSpam();
		$this->assertTrue($response);
	}

	function testIsCommentHam() {
		$this->requestFactory->setResponse("\r\n\r\nfalse");
		$response = $this->akismet->isCommentSpam();
		$this->assertFalse($response);
	}
}

class MockRequestSender implements AkismetRequestSender {
	private $response;


	public function __construct($response) {
		$this->response = $response;
	}

	public function send($host, $port, $request, $responseLength = 1160) {
		return $this->response;
	}
}

class MockRequestFactory implements AkismetRequestFactory {
	private $response;

	public function createRequestSender() {
		return new MockRequestSender($this->response);
	}

	public function setResponse($response) {
		$this->response = $response;
	}
}

?>
