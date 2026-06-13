<?php

declare(strict_types=1);

namespace Exel\ApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('exel_api');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('api_key')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('base_url')
                    ->defaultValue('https://api01.exeldelnorte.com.mx')
                ->end()
                ->arrayNode('cache')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultTrue()
                        ->end()
                        ->integerNode('ttl')
                            ->defaultValue(3600)
                            ->min(0)
                        ->end()
                        ->scalarNode('service')
                            ->defaultNull()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('retry')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultTrue()
                        ->end()
                        ->integerNode('max_retries')
                            ->defaultValue(3)
                            ->min(0)
                            ->max(10)
                        ->end()
                        ->integerNode('delay_ms')
                            ->defaultValue(1000)
                            ->min(100)
                            ->max(30000)
                        ->end()
                        ->floatNode('multiplier')
                            ->defaultValue(2.0)
                            ->min(1.0)
                            ->max(5.0)
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('logging')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultTrue()
                        ->end()
                        ->booleanNode('log_request_body')
                            ->defaultFalse()
                        ->end()
                        ->booleanNode('log_response_body')
                            ->defaultFalse()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('timeout')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('connection')
                            ->defaultValue(10)
                            ->min(1)
                        ->end()
                        ->integerNode('response')
                            ->defaultValue(30)
                            ->min(5)
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
