<?php

namespace NetBull\AwesomeFilterBundle\Operators;

class IsBetween extends BaseOperator
{
	const TYPE = 'is_between';

	public function __construct()
	{
		$this->setLabel('is between');
		$this->setValue(self::TYPE);
	}
}
