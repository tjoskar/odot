<?php

class GetListTest extends TestCase {

    public function testGetListsAsGuest()
    {
        try
        {
            $this->client->request('GET', '/list');
            $this->assertTrue(false);
        }
        catch (Exception $e)
        {
            return;
        }
    }

    public function testGetListsAsUser()
    {
        $user = User::find(1);     // Oskar
        $this->be($user);

        $response = $this->call('GET', '/list');

        $this->assertTrue($this->client->getResponse()->isOk());

        $json = json_decode($response->getContent());
        $this->assertFalse(is_null($json));
        $this->assertTrue(is_array($json));
    }

    public function testGetListAsUser()
    {
        $user = User::find(1);     // Oskar
        $this->be($user);

        $random_id = rand(1, 8); // List exist
        $response = $this->call('GET', '/list/'.$random_id);

        $this->assertTrue($this->client->getResponse()->isOk());

        $json = json_decode($response->getContent());

        $this->assertFalse(is_null($json));
        $this->assertTrue(is_object($json));
    }

    public function testCreateListAsUser()
    {
        $user = User::find(1);     // Oskar
        $this->be($user);

        $response = $this->call('POST', '/list', array('title' => 'New list'));

        $this->assertTrue($this->client->getResponse()->isOk());

        $json = json_decode($response->getContent());
        $this->assertFalse(is_null($json));
        $this->assertTrue(is_object($json));
    }

}
