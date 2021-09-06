<?php

namespace NetBull\AwesomeFilterBundle\Operators;

class Is extends BaseOperator
{
	const TYPE = 'is';

	public function __construct()
	{
		$this->setLabel('is');
		$this->setValue(self::TYPE);
	}
}
