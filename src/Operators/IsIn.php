<?php

namespace NetBull\AwesomeFilterBundle\Operators;

class IsIn extends BaseOperator
{
	const TYPE = 'is_in';

	public function __construct()
	{
		$this->setLabel('is in');
		$this->setValue(self::TYPE);
	}
}
