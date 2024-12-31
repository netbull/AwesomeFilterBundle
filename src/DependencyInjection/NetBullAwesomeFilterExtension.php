<?php

namespace NetBull\AwesomeFilterBundle\DependencyInjection;

use NetBull\AwesomeFilterBundle\DependencyInjection\Compiler\OperatorPass;
use Exception;
use NetBull\AwesomeFilterBundle\Operators\OperatorInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class NetBullAwesomeFilterExtension extends Extension
{
	/**
	 * @param array $configs
	 * @param ContainerBuilder $container
	 * @return void
	 * @throws Exception
	 */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
    }
}
