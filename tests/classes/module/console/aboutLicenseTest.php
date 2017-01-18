<?php

use Alchemy\Phrasea\CommandLineApplication;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @group functional
 * @group legacy
 */
class module_console_aboutLicenseTest extends \PhraseanetTestCase
{
    /**
     * @var module_console_aboutLicense
     */
    protected $object;

    /**
     * @covers module_console_aboutAuthors::execute
     */
    public function testExecute()
    {
        $application = new CommandLineApplication('test', null, 'test');
        $application->command(new module_console_aboutLicense('about:license'));

        $command = $application['console']->find('about:license');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['command' => $command->getName()]);

        $this->assertEquals(
            trim(file_get_contents(__DIR__ . '/../../../../LICENSE'))
            , trim($commandTester->getDisplay())
        );
    }
}
