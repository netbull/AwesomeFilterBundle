<?php

namespace NetBull\AwesomeFilterBundle\Operators;

class IsEmpty extends BaseOperator
{
	const TYPE = 'is_empty';

	public function __construct()
	{
		$this->setLabel('is empty');
		$this->setValue(self::TYPE);
	}
}
