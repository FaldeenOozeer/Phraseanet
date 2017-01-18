<?php

namespace Alchemy\Tests\Phrasea\Core\Event\Subscriber;

use Alchemy\Phrasea\BaseApplication;
use Symfony\Component\HttpKernel\Client;
use Alchemy\Phrasea\Core\Event\Subscriber\BridgeExceptionSubscriber;

/**
 * @group functional
 * @group legacy
 */
class BridgeExceptionSubscriberTest extends \PhraseanetTestCase
{
    public function testErrorOnBridgeExceptions()
    {
        $app = new BaseApplication(BaseApplication::ENV_TEST);
        $app['bridge.account'] = $this->getMockBuilder('Bridge_Account')
            ->disableOriginalConstructor()
            ->getMock();
        unset($app['exception_handler']);
        $app['dispatcher']->addSubscriber(new BridgeExceptionSubscriber($app));
        $app->get('/', function () {
            throw new \Bridge_Exception('Bridge exception');
        });

        $client = new Client($app);
        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testErrorOnOtherExceptions()
    {
        $app = new BaseApplication(BaseApplication::ENV_TEST);
        $app['bridge.account'] = $this->getMockBuilder('Bridge_Account')
            ->disableOriginalConstructor()
            ->getMock();
        unset($app['exception_handler']);
        $app['dispatcher']->addSubscriber(new BridgeExceptionSubscriber($app));
        $app->get('/', function () {
            throw new \InvalidArgumentException;
        });

        $client = new Client($app);
        $this->setExpectedException('\InvalidArgumentException');
        $client->request('GET', '/');
    }
}
