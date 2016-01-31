<?php
namespace IvixLabs\MutexBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class IvixLabsMutexExtension extends Extension
{

    private $storageClasses = array(
        'memcache' => 'IvixLabs\Mutex\Storage\MemcacheMutexStorage',
        'memcached' => 'IvixLabs\Mutex\Storage\MemcachedMutexStorage',
        'file' => 'IvixLabs\Mutex\Storage\FileMutexStorage',
    );

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $storages = array();
        foreach ($config['storages'] as $stoageName => $storageDefinition) {
            $definition = new Definition($this->storageClasses[$storageDefinition['type']]);
            $definition->addTag('ivixlabs.mutex.storage');
            $definition->addArgument($storageDefinition['settings']);

            $id = 'ivixlabs.mutex.storage.' . $stoageName;

            $storages[$id] = $definition;
        }
        $container->addDefinitions($storages);


        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }
}
