<?php

namespace NetBull\AwesomeFilterBundle;

use NetBull\AwesomeFilterBundle\DependencyInjection\Compiler\OperatorPass;
use NetBull\AwesomeFilterBundle\Operators\OperatorInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NetBullAwesomeFilterBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
        $container->registerForAutoconfiguration(OperatorInterface::class)
            ->addTag(OperatorPass::OPERATOR_TAG);

		$container->addCompilerPass(new OperatorPass());
	}
}
