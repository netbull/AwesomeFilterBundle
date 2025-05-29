<?php

namespace NetBull\AwesomeFilterBundle\DependencyInjection\Compiler;

use NetBull\AwesomeFilterBundle\Manager\AwesomeFilterManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
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
