<?php

namespace Fesor\Stepler\ServiceContainer;

use Behat\Behat\Tester\ServiceContainer\TesterExtension;
use Behat\Testwork\Cli\ServiceContainer\CliExtension;
use Behat\Testwork\Environment\ServiceContainer\EnvironmentExtension;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Behat\Testwork\Suite\ServiceContainer\SuiteExtension;
use Fesor\Stepler\Controller\SteplerController;
use Fesor\Stepler\Generator\DummyFeatureGenerator;
use Fesor\Stepler\Runner\StepRunner;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Dump\Container;
use Symfony\Component\DependencyInjection\Reference;

final class SteplerExtension implements Extension
{
    
    const STEP_RUNNER_ID = 'stepler.step_runner';
    const DUMMY_GENERATOR_ID = 'stepler.dummy_generator';

    /**
     * @inheritdoc
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $this->loadStepRunner($container);
        $this->loadSteplerController($container, $config);
        $this->loadDummyFeatureGenerator($container);
    }

    /**
     * @inheritdoc
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('suite')->defaultNull()->end()
            ->end();
            
    }

    /**
     * @inheritdoc
     */
    public function getConfigKey()
    {
        return 'stepler';
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
    }
    
    private function loadStepRunner(ContainerBuilder $container)
    {
        $definition = new Definition(StepRunner::class, [
            new Reference(TesterExtension::STEP_TESTER_ID),
            new Reference(EnvironmentExtension::MANAGER_ID),
            new Reference(self::DUMMY_GENERATOR_ID),
        ]);

        $container->setDefinition(self::STEP_RUNNER_ID, $definition);
    }

    private function loadSteplerController(ContainerBuilder $container, array $config)
    {
        $definition = new Definition(SteplerController::class , [
            new Reference(self::STEP_RUNNER_ID),
            new Reference(SuiteExtension::REGISTRY_ID),
            isset($config['suite']) ? $config['suite'] : null
        ]);
        $definition->addTag(CliExtension::CONTROLLER_TAG, array('priority' => 999));
        $container->setDefinition(CliExtension::CONTROLLER_TAG . '.stepler', $definition);
    }
    
    private function loadDummyFeatureGenerator(ContainerBuilder $container)
    {
        $definition = new Definition(DummyFeatureGenerator::class, [
            new Reference('gherkin.parser')
        ]);
        $container->setDefinition(self::DUMMY_GENERATOR_ID, $definition);
    }
    
}