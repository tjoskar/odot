<?php
namespace Ratchet\WebSocket\Guzzle\Http\Message;
use Guzzle\Http\Message\RequestFactory as GuzzleRequestFactory;
use Guzzle\Http\EntityBody;

class RequestFactory extends GuzzleRequestFactory {
    /**
     * {@inheritdoc}
     */
    public function create($method, $url, $headers = null, $body = '') {
        $c = $this->entityEnclosingRequestClass;
        $request = new $c($method, $url, $headers);
        $request->setBody(EntityBody::factory($body));

        return $request;
    }
}