<?php
namespace ScayTrase\Api\Rest\Tests;

use ScayTrase\Api\Rpc\RpcRequestInterface;

trait RpcRequestMockTrait
{
    protected function createRequestMock($method, $parameters)
    {
        $request = $this->prophesize(RpcRequestInterface::class);
        $request->getMethod()->willReturn($method);
        $request->getParameters()->willReturn($parameters);

        return $request->reveal();
    }

    /**
     * @param  string|null $classOrInterface
     *
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    abstract protected function prophesize($classOrInterface = null);
}
