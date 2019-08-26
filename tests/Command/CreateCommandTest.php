<?php
declare(strict_types=1);

namespace reneroboter\gli\Tests\Command;

use League\CLImate\CLImate;
use PHPUnit\Framework\TestCase;
use reneroboter\gli\Command\CreateCommand;

final class CreateCommandTest extends TestCase
{
    public function testCreateCommand(): void
    {
        $climate = new CLImate();
        $GLOBALS['argv'] = ['gli.php', 'create', '--name=test', '--description=test', '--homepage=http://example.org'];
        $createCommand = new CreateCommand($climate);
        $result = $createCommand->handle();
        $this->assertEquals($result->getMethod(), 'GET');
        $this->assertEquals($result->getEndpoint(), '/user/repos');
        $this->assertEquals($result->getData(), [
            'name' => 'test',
            'description' => 'test',
            'homepage' => 'http://example.org'
        ]);
    }
}