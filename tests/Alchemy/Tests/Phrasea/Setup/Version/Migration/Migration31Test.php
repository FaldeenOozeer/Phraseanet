<?php

namespace Alchemy\Tests\Phrasea\Setup\Version\Migration;

use Alchemy\Phrasea\BaseApplication;
use Alchemy\Phrasea\Setup\Version\Migration\Migration31;
use Alchemy\Tests\Phrasea\Setup\AbstractSetupTester;

/**
 * @group functional
 * @group legacy
 */
class Migration31Test extends AbstractSetupTester
{

    public function testMigrateFails()
    {
        $migration = $this->getMigration();
        try {
            $migration->migrate();
            $this->fail('Should fail');
        } catch (\LogicException $e) {

        }
    }

    public function testMigrate()
    {
        $this->goBackTo31();
        $migration = $this->getMigration();
        $migration->migrate();

        require __DIR__ . '/../../../../../../../config/config.inc';

        $this->assertEquals('http://local.phrasea.tester/', $servername);

        unlink(__DIR__ . '/../../../../../../../config/_GV.php.old');
        unlink(__DIR__ . '/../../../../../../../config/config.inc');
    }

    private function getMigration()
    {
        return new Migration31(new BaseApplication(BaseApplication::ENV_TEST));
    }
}
