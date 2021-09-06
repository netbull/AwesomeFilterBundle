<?php

namespace NetBull\AwesomeFilterBundle\Operators;

class Gt extends BaseOperator
{
	const TYPE = 'gt';

	public function __construct()
	{
		$this->setLabel('greater than');
		$this->setValue(self::TYPE);
	}
}
