<?php

namespace Fesor\Stepler\Runner;

use Behat\Behat\Tester\StepTester;
use Behat\Testwork\Environment\EnvironmentManager;
use Behat\Testwork\Suite\Suite;
use Fesor\Stepler\Generator\DummyFeatureGenerator;

final class StepRunner
{
    /**
     * @var StepTester
     */
    private $stepTester;

    /**
     * @var EnvironmentManager
     */
    private $environmentManager;

    /**
     * @var DummyFeatureGenerator
     */
    private $generator;

    /**
     * @param StepTester $stepTester
     * @param EnvironmentManager $environmentManager
     * @param DummyFeatureGenerator $generator
     */
    public function __construct(
        StepTester $stepTester, 
        EnvironmentManager $environmentManager, 
        DummyFeatureGenerator $generator
    ) {
        $this->stepTester = $stepTester;
        $this->environmentManager = $environmentManager;
        $this->generator = $generator;
    }

    /**
     * @param $step
     * @param Suite $suite
     * @return \Behat\Behat\Tester\Result\StepResult
     */
    public function run($step, Suite $suite)
    {
        $env = $this->environmentManager->buildEnvironment($suite);
        $env = $this->environmentManager->isolateEnvironment($env);

        $dummyFeatureNode = $this->generator->generate($step);

        return $this->stepTester->test(
            $env, 
            $dummyFeatureNode->getFeatureNode(), 
            $dummyFeatureNode->getStepNode(), 
            false
        );
    }
    
}