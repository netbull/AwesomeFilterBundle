<?php

namespace NetBull\AwesomeFilterBundle\Operators;

class IsNotIn extends BaseOperator
{
	const TYPE = 'is_not_in';

	public function __construct()
	{
		$this->setLabel('is not in');
		$this->setValue(self::TYPE);
	}
}
