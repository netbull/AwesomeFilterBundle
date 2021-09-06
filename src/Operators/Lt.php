<?php

namespace NetBull\AwesomeFilterBundle\Operators;

class Lt extends BaseOperator
{
	const TYPE = 'lt';

	public function __construct()
	{
		$this->setLabel('less than');
		$this->setValue(self::TYPE);
	}
}
