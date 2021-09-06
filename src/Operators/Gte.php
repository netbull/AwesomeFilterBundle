<?php

namespace NetBull\AwesomeFilterBundle\Operators;

class Gte extends BaseOperator
{
	const TYPE = 'gte';

	public function __construct()
	{
		$this->setLabel('greater than or equal');
		$this->setValue(self::TYPE);
	}
}
