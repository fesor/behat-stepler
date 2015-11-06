<?php

namespace Fesor\Stepler\Generator;

use Behat\Gherkin\Parser;
use Fesor\Stepler\Generator\Node\DummyFeatureNode;

class DummyFeatureGenerator
{

    /**
     * @var Parser
     */
    private $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }


    public function generate($steps)
    {
        $feature = $this->generateFeatureForSteps($steps);
        $featureNode = $this->parser->parse($feature);

        return new DummyFeatureNode($featureNode);
    }

    private function generateFeatureForSteps($steps)
    {
        return implode("\n", [
            'Feature: dummy',
            'Scenario: dummy',
            $this->generateRawSteps($steps)
        ]);
    }

    private function generateRawSteps($steps)
    {
        return implode("\n", array_map(function($step) {
            return sprintf('Given %s', $step);
        }, $steps));
    }
}
