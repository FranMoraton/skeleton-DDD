<?php

declare(strict_types=1);

namespace Skeleton\Tests\Kernel\Application;

use PHPUnit\Framework\TestCase;

class CommandHandlerScenarioTestCase extends TestCase
{
    /**
     * @var CommandHandlerScenario
     */
    protected $scenario;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->scenario = new CommandHandlerScenario();

        parent::__construct($name, $data, $dataName);
    }
}
