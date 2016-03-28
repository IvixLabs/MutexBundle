<?php
namespace IvixLabs\MutexBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;


class MutexStorageCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $serviceId = 'ivixlabs.mutex.factory';


        if (!$container->hasDefinition($serviceId)) {
            return;
        }

        $definition = $container->getDefinition($serviceId);

        $tag = 'ivixlabs.mutex.storage';

        $services = $container->findTaggedServiceIds($tag);
        foreach ($services as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall('addStorage', array(new Reference($id), $attributes['storage_name']));
            }
        }
    }


}