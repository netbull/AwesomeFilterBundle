<?php

namespace NetBull\AwesomeFilterBundle\Operators;

class Starts extends BaseOperator
{
	const TYPE = 'starts';

	public function __construct()
	{
		$this->setLabel('starts');
		$this->setValue(self::TYPE);
	}
}
