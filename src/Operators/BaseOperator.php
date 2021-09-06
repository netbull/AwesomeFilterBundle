<?php

namespace NetBull\AwesomeFilterBundle\Operators;

abstract class BaseOperator implements OperatorInterface
{
    /**
     * @var string|null
     */
    private string $label;

    /**
     * @var string|null
     */
    private string $value;

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->value;
    }

    /**
     * @param string $label
     * @return OperatorInterface
     */
    public function setLabel(string $label): OperatorInterface
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return OperatorInterface
     */
    public function setValue(string $value): OperatorInterface
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'value' => $this->value,
        ];
    }
}
