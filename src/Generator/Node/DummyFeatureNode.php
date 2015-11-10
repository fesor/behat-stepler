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
     * @var StepNode[]
     */
    private $stepNodes;

    /**
     * @param FeatureNode $featureNode
     */
    public function __construct(FeatureNode $featureNode)
    {
        $this->featureNode = $featureNode;
        $this->findStepNodes();
    }

    /**
     * @return FeatureNode
     */
    public function getFeatureNode()
    {
        return $this->featureNode;
    }

    /**
     * @return StepNode[]
     */
    public function getStepNodes()
    {
        return $this->stepNodes;
    }

    private function findStepNodes()
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

        $this->stepNodes = $steps;
    }

}
