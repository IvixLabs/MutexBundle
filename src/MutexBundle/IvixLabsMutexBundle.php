<?php
namespace IvixLabs\MutexBundle;

use IvixLabs\MutexBundle\DependencyInjection\MutexStorageCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class IvixLabsMutexBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new MutexStorageCompilerPass());
    }

}
