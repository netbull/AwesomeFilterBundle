<?php

namespace NetBull\AwesomeFilterBundle;

use NetBull\AwesomeFilterBundle\DependencyInjection\Compiler\OperatorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NetBullAwesomeFilterBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		$container->addCompilerPass(new OperatorPass());
	}
}
