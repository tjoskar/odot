<?php

class TestController extends BaseController {

	public function index()
	{
		$data = array('Oskar', 'Karlsson');

		$context = new ZMQContext();
    	$socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'my pusher');
    	$socket->connect("tcp://localhost:5555");

    	$socket->send(json_encode($ata));
	}

}
