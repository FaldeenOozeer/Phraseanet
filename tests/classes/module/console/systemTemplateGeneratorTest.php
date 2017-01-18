<?php

use Alchemy\Phrasea\CommandLineApplication;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @group functional
 * @group legacy
 */
class module_console_systemTemplateGeneratorTest extends \PhraseanetTestCase
{

    public function testExecute()
    {
        $application = new CommandLineApplication('test', null, 'test');
        $application->command(new module_console_systemTemplateGenerator('system:templateGenerator'));
        // Application should be booted before executing commands
        $application->boot();

        $command = $application['console']->find('system:templateGenerator');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['command' => $command->getName()]);

        $data = explode("\n", trim($commandTester->getDisplay()));
        $last_line = array_pop($data);

        $this->assertTrue(strpos($last_line, 'templates failed') === false, sprintf('Some templates failed: %s', $commandTester->getDisplay()));
        $this->assertTrue(strpos($last_line, 'templates generated') !== false, 'No templates have been generated');
    }
}
