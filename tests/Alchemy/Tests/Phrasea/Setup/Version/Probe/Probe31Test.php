<?php

namespace Alchemy\Tests\Phrasea\Setup\Version\Probe;

use Alchemy\Phrasea\BaseApplication;
use Alchemy\Tests\Phrasea\Setup\AbstractSetupTester;
use Alchemy\Phrasea\Setup\Version\Probe\Probe31;

/**
 * @group functional
 * @group legacy
 */
class Probe31Test extends AbstractSetupTester
{
    public function testNoMigration()
    {
        $probe = $this->getProbe();
        $this->assertFalse($probe->isMigrable());
    }

    public function testMigration()
    {
        $this->goBackTo31();
        $probe = $this->getProbe();
        $this->assertTrue($probe->isMigrable());
        $this->assertInstanceOf('Alchemy\Phrasea\Setup\Version\Migration\Migration31', $probe->getMigration());
    }

    private function getProbe()
    {
        return new Probe31(new BaseApplication(BaseApplication::ENV_TEST));
    }
}
