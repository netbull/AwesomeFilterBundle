<?php

namespace NetBull\AwesomeFilterBundle\Operators;

class Lte extends BaseOperator
{
	const TYPE = 'lte';

	public function __construct()
	{
		$this->setLabel('less than or equal');
		$this->setValue(self::TYPE);
	}
}
