<?php

namespace NetBull\AwesomeFilterBundle\DependencyInjection;

use Exception;
use NetBull\AwesomeFilterBundle\Operators\OperatorInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use NetBull\AwesomeFilterBundle\Manager\AwesomeFilterManager;

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

        $container->registerForAutoconfiguration(OperatorInterface::class)
            ->addTag('awesome_filter.operator');

		$managerDefinition = $container->getDefinition(AwesomeFilterManager::class);
		foreach ($container->findTaggedServiceIds('awesome_filter.operator') as $name => $exporter) {
            $managerDefinition->addMethodCall('addOperator', [new Reference($name)]);
		}
    }
}
