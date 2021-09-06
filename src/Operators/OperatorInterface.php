<?php

namespace NetBull\AwesomeFilterBundle\Operators;

interface OperatorInterface
{
	/**
	 * @return string
	 */
	public function getLabel(): string;

	/**
	 * @param string $label
	 * @return OperatorInterface
	 */
	public function setLabel(string $label): OperatorInterface;

	/**
	 * @return string
	 */
	public function getValue(): string;

	/**
	 * @param string $value
	 * @return OperatorInterface
	 */
	public function setValue(string $value): OperatorInterface;

	/**
	 * @return array
	 */
	public function toArray(): array;
}
