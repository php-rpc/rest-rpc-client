# REST RPC Client

## Purpose

The general purpose of this library is to wrap common REST calls with RPC
Client interface. The `ProtocolFactoryInterface` allows to do some internal
logic for higher-level HTTP-based protocols, like JSON-RPC
 
## Installation

`composer require symfony-rpc/rest-rpc-client`

## Usage

For the simple JSON-based API the basic usage looks like as easy as

```php
use ScayTrase\Api\Rest\Decoder\JsonDecoder;
use ScayTrase\Api\Rest\Encoder\JsonEncoder;
use ScayTrase\Api\Rest\ProtocolFactory\NaiveFactory;
use ScayTrase\Api\Rest\RestRpcClient;
use ScayTrase\Api\Rpc\RpcRequestInterface;

final class MyRpcRequest implements RpcRequestInterface
{

    private $method;
    private $parameters;

    public function __construct($method, $parameters)
    {
        $this->method     = $method;
        $this->parameters = $parameters;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getParameters()
    {
        return $this->parameters;
    }
}

$httpClient = new \GuzzleHttp\Client();

// Any Guzzle\ClientInterface suits, configure it as you need, i.e add
// base url or additional authentication headers

$factory = new NaiveFactory(new JsonEncoder(), new JsonDecoder(), '/');
$client  = new RestRpcClient($httpClient, $factory);

$call = new MyRpcRequest('any-path-as/namespace/method', ['array' => ['of', 'params']]);

// This would actually make the HTTP call to the
// url '/'.'any-path-as/namespace/method' (from factory + from request method)
// with params encoded as a JSON, and parse the JSON response as a \stdClass
// object. The request counts succeeded when HTTP Response code is 2xx
// Following redirects and other is up to the Guzzle client, so configure it properly
$response = $client->invoke($call)->getResponse($call);
```
