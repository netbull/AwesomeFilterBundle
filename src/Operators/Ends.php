<?php

namespace NetBull\AwesomeFilterBundle\Operators;

class Ends extends BaseOperator
{
	const TYPE = 'ends';

	public function __construct()
	{
		$this->setLabel('ends');
		$this->setValue(self::TYPE);
	}
}
