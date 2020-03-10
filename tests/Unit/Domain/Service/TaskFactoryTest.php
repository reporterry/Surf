<?php

namespace TYPO3\Surf\Tests\Unit\Domain\Service;

/*
 * This file is part of TYPO3 Surf.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\TestCase;
use TYPO3\Surf\Domain\Model\Application;
use TYPO3\Surf\Domain\Model\Deployment;
use TYPO3\Surf\Domain\Model\Node;
use TYPO3\Surf\Domain\Model\Task;
use TYPO3\Surf\Domain\Service\ShellCommandService;
use TYPO3\Surf\Domain\Service\ShellCommandServiceAwareInterface;
use TYPO3\Surf\Domain\Service\TaskFactory;
use TYPO3\Surf\Exception as SurfException;

class TaskFactoryTest extends TestCase
{
    /**
     * @var TaskFactory
     */
    protected $subject;

    protected function setUp()
    {
        $this->subject = new TaskFactory();
    }

    /**
     * @test
     */
    public function createTaskInstance(): void
    {
        $task = new class extends Task {
            public function execute(Node $node, Application $application, Deployment $deployment, array $options = [])
            {
            }
        };

        $this->assertEquals($task, $this->subject->createTaskInstance(get_class($task)));
    }

    /**
     * @test
     */
    public function createTaskInstanceImplementingShellCommandServiceAwareInterface(): void
    {
        $task = new class extends Task implements ShellCommandServiceAwareInterface {
            public function execute(Node $node, Application $application, Deployment $deployment, array $options = [])
            {
            }

            public function setShellCommandService(ShellCommandService $shellCommandService)
            {
            }
        };

        $this->assertEquals($task, $this->subject->createTaskInstance(get_class($task)));
    }

    /**
     * @test
     */
    public function createTaskInstanceThrowsExceptionClassDoesNotExist(): void
    {
        $this->expectException(SurfException::class);
        $this->subject->createTaskInstance('SomeFooBarBaz');
    }

    /**
     * @test
     */
    public function createTaskInstanceThrowsExceptionClassIsNotOfCorrectSubclass(): void
    {
        $task = new class {
        };

        $this->expectException(SurfException::class);
        $this->subject->createTaskInstance(get_class($task));
    }
}
