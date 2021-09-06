<?php

namespace NetBull\AwesomeFilterBundle\Operators;

class Contains extends BaseOperator
{
	const TYPE = 'contains';

	public function __construct()
	{
		$this->setLabel('contains');
		$this->setValue(self::TYPE);
	}
}
