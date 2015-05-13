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


    public function generate($rawStep)
    {
        $feature = $this->generateFeatureForStep($rawStep);
        $featureNode = $this->parser->parse($feature);
        
        return new DummyFeatureNode($featureNode);
    }
    
    private function generateFeatureForStep($rawStep)
    {
        return implode("\n", [
            'Feature: dummy',
            'Scenario: dummy',
            sprintf('Given %s', $rawStep)
        ]);
    }
    
}