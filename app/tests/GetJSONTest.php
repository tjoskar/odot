<?php

class GetJSONTest extends TestCase {

	public function testGetLists()
	{
		$respons = $this->client->request('GET', '/list');

		$this->assertTrue($this->client->getResponse()->isOk());

		$json = json_encode($respons);

		$this->assertFalse(is_null($json));
	}

	public function testGetList()
	{
		$random_id = rand(1, 20);
		$respons = $this->client->request('GET', '/list/'.$random_id);

		$this->assertTrue($this->client->getResponse()->isOk());

		$json = json_encode($respons);

		$this->assertFalse(is_null($json));
	}

}