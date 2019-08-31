<?php


namespace reneroboter\gli\Tests\Command;


use League\CLImate\CLImate;
use PHPUnit\Framework\TestCase;
use reneroboter\gli\Command\DeleteCommand;

class DeleteCommandTest extends TestCase
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
        $GLOBALS['argv'] = ['gli.php', 'delete', '--repo=test-repo', '--owner=test-owner',];
        $deleteCommand = new DeleteCommand($this->climate);
        $result = $deleteCommand->handle();
        $this->assertEquals($result->getMethod(), 'DELETE');
        $this->assertEquals($result->getEndpoint(), '/repos/test-owner/test-repo');
        $this->assertEmpty($result->getData());
    }
}