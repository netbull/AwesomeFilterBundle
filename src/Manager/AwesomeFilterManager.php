<?php

namespace NetBull\AwesomeFilterBundle\Manager;

use NetBull\AwesomeFilterBundle\Operators\OperatorInterface;

class AwesomeFilterManager
{
    /**
     * @var array
     */
    private array $operators = [];

    /**
     * @param $operator
     * @return $this
     */
    public function addOperator($operator): self
    {
        if ($operator instanceof OperatorInterface) {
            $this->operators[$operator->getValue()] = $operator;
        }

        return $this;
    }

    /**
     * @param string $value
     * @return OperatorInterface|null
     */
    public function getOperator(string $value): ?OperatorInterface
    {
        if (array_key_exists($value, $this->operators)) {
            return $this->operators[$value];
        }

        return null;
    }

    /**
     * @return OperatorInterface[]
     */
    public function getOperators(): array
    {
        return $this->operators;
    }
}
