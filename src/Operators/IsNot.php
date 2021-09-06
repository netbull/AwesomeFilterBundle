<?php

namespace NetBull\AwesomeFilterBundle\Operators;

class IsNot extends BaseOperator
{
	const TYPE = 'is_not';

	public function __construct()
	{
		$this->setLabel('is not');
		$this->setValue(self::TYPE);
	}
}
