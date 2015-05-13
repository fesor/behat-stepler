<?php

namespace Fesor\Stepler\Runner;

use Behat\Behat\Tester\StepTester;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\StepNode;
use Behat\Testwork\Environment\EnvironmentManager;
use Behat\Testwork\Suite\Suite;

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
     * @param StepTester $stepTester
     * @param EnvironmentManager $environmentManager
     */
    public function __construct(StepTester $stepTester, EnvironmentManager $environmentManager) 
    {
        $this->stepTester = $stepTester;
        $this->environmentManager = $environmentManager;
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
        
        $feature = $this->generateEmptyFeature();
        $step = $this->generateStep($step);
        
        return $this->stepTester->test($env, $feature, $step, false);
    }

    /**
     * @return FeatureNode
     */
    private function generateEmptyFeature()
    {
        return new FeatureNode('', '', [], null, [], 'Feature', 'en', '_.feature', 0);
    }

    /**
     * @param $step
     * @return StepNode
     */
    private function generateStep($step)
    {
        return new StepNode('Given', $step, [], 0, 'Given');
    }
    
}