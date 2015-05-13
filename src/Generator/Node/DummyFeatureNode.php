<?php

namespace Fesor\Stepler\Generator\Node;

use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\StepNode;

class DummyFeatureNode
{

    /**
     * @var FeatureNode
     */
    private $featureNode;

    /**
     * @var StepNode
     */
    private $stepNode;

    /**
     * @param FeatureNode $featureNode
     */
    public function __construct(FeatureNode $featureNode)
    {
        $this->featureNode = $featureNode;
        $this->findStepNode();
    }

    /**
     * @return FeatureNode
     */
    public function getFeatureNode()
    {
        return $this->featureNode;
    }

    /**
     * @return StepNode
     */
    public function getStepNode()
    {
        return $this->stepNode;
    }
    
    private function findStepNode()
    {
        $scenarios = $this->featureNode->getScenarios();
        if (count($scenarios) === 0) {
            throw new \InvalidArgumentException('Unable to find any scenarios in dummy feature');
        }
        
        $scenario = $scenarios[0];
        $steps = $scenario->getSteps();
        
        if (count($steps) === 0) {
            throw new \InvalidArgumentException('Unable to find any steps in dummy feature');
        }
        
        $this->stepNode = $steps[0];
    }
    
}