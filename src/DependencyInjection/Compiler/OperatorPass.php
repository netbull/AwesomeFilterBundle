<?php

namespace NetBull\AwesomeFilterBundle\DependencyInjection\Compiler;

use Doctrine\Bundle\DoctrineBundle\Mapping\ClassMetadataFactory;
use Doctrine\Bundle\DoctrineBundle\Mapping\MappingDriver;
use Doctrine\ORM\Mapping\ClassMetadataFactory as ORMClassMetadataFactory;
use NetBull\AwesomeFilterBundle\Manager\AwesomeFilterManager;
use NetBull\AwesomeFilterBundle\Operators\OperatorInterface;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class OperatorPass implements CompilerPassInterface
{
    public const OPERATOR_TAG  = 'awesome_filter.operator';

    public function process(ContainerBuilder $container): void
    {
        $operators = array_keys($container->findTaggedServiceIds(self::OPERATOR_TAG));
        if (!$container->hasDefinition(AwesomeFilterManager::class) || !$operators) {
            return;
        }

		$operatorRefs = array_map(static function ($id) {
			return new Reference($id);
		}, $operators);

        $definition = $container->getDefinition(AwesomeFilterManager::class);
		foreach ($operatorRefs as $operatorRef) {
            $definition->addMethodCall('addOperator', [$operatorRef]);
		}
    }
}
