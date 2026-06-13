<?php

declare(strict_types=1);

namespace Exel\ApiBundle\DependencyInjection;

use Exel\ApiBundle\Cache\CacheManager;
use Exel\ApiBundle\Client\ExelApiClient;
use Exel\ApiBundle\ExelApi;
use Exel\ApiBundle\Service\CatalogService;
use Exel\ApiBundle\Service\OrderService;
use Exel\ApiBundle\Service\ProductService;
use Exel\ApiBundle\Service\ShippingService;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Contracts\Cache\CacheInterface;

final class ExelApiExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        // Set parameters
        $container->setParameter('exel_api.api_key', $config['api_key']);
        $container->setParameter('exel_api.base_url', $config['base_url']);
        $container->setParameter('exel_api.cache.enabled', $config['cache']['enabled']);
        $container->setParameter('exel_api.cache.ttl', $config['cache']['ttl']);
        $container->setParameter('exel_api.retry.enabled', $config['retry']['enabled']);
        $container->setParameter('exel_api.retry.max_retries', $config['retry']['max_retries']);
        $container->setParameter('exel_api.retry.delay_ms', $config['retry']['delay_ms']);
        $container->setParameter('exel_api.retry.multiplier', $config['retry']['multiplier']);
        $container->setParameter('exel_api.logging.enabled', $config['logging']['enabled']);
        $container->setParameter('exel_api.logging.log_request_body', $config['logging']['log_request_body']);
        $container->setParameter('exel_api.logging.log_response_body', $config['logging']['log_response_body']);
        $container->setParameter('exel_api.timeout.connection', $config['timeout']['connection']);
        $container->setParameter('exel_api.timeout.response', $config['timeout']['response']);

        // Register CacheManager if cache is enabled
        if ($config['cache']['enabled']) {
            $cacheManagerDefinition = new Definition(CacheManager::class);
            
            if ($config['cache']['service'] && $container->has($config['cache']['service'])) {
                $cacheManagerDefinition->setArgument('$cache', new Reference($config['cache']['service']));
            } else {
                $cacheManagerDefinition->setArgument('$cache', new Reference('cache.app'));
            }
            
            $cacheManagerDefinition->setArgument('$ttl', $config['cache']['ttl']);
            $container->setDefinition(CacheManager::class, $cacheManagerDefinition);
        }

        // Alias for main API facade
        $container->setAlias(ExelApi::class, 'exel_api.client_facade');
    }
}
