<?php

namespace Alchemy\Tests\Phrasea\Application;

use Alchemy\Phrasea\BaseApplication;

/**
 * @group functional
 * @group legacy
 */
class RootApplicationTest extends \PhraseanetTestCase
{
    /**
     * @dataProvider provideEnvironments
     */
    public function testApplicationIsBuiltWithTheRightEnv($environment)
    {
        $app = require __DIR__ . '/../../../../../lib/Alchemy/Phrasea/Application/Root.php';
        $this->assertEquals($environment, $app->getEnvironment());
    }

    public function provideEnvironments()
    {
        return [
            [BaseApplication::ENV_PROD],
            [BaseApplication::ENV_TEST],
            [BaseApplication::ENV_DEV],
        ];
    }

    public function testWebProfilerDisableInProdEnv()
    {
        $environment = BaseApplication::ENV_PROD;
        $app = require __DIR__ . '/../../../../../lib/Alchemy/Phrasea/Application/Root.php';
        $this->assertFalse(isset($app['profiler']));
    }

    public function testWebProfilerDisableInTestEnv()
    {
        $environment = BaseApplication::ENV_TEST;
        $app = require __DIR__ . '/../../../../../lib/Alchemy/Phrasea/Application/Root.php';
        $this->assertFalse(isset($app['profiler']));
    }

    public function testWebProfilerEnableInDevMode()
    {
        $environment = BaseApplication::ENV_DEV;
        $app = require __DIR__ . '/../../../../../lib/Alchemy/Phrasea/Application/Root.php';
        $this->assertTrue(isset($app['profiler']));
    }
}
