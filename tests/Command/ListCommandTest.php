<?php


namespace reneroboter\gli\Tests\Command;


use League\CLImate\CLImate;
use PHPUnit\Framework\TestCase;
use reneroboter\gli\Command\ListCommand;

class ListCommandTest extends TestCase
{
    /**
     * @var CLImate
     */
    private $climate;

    protected function setUp(): void
    {
        $this->climate = new CLImate();
    }

    public function testDeleteValidCommandResultObject(): void
    {
        $GLOBALS['argv'] = ['gli.php', 'list', '--visibility=all'];
        $listCommand = new ListCommand($this->climate);
        $result = $listCommand->handle();
        $this->assertEquals($result->getMethod(), 'GET');
        $this->assertEquals($result->getEndpoint(), '/user/repos?per_page=100&visibility=all');
        $this->assertEmpty($result->getData());
    }
}