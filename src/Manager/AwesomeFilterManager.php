<?php

namespace NetBull\AwesomeFilterBundle\Manager;

use NetBull\AwesomeFilterBundle\Model\FieldConfig;
use NetBull\AwesomeFilterBundle\Operators\OperatorInterface;

class AwesomeFilterManager
{
    /**
     * @var bool
     */
    private bool $automaticallyAdjustPosition = false;

    /**
     * @var array
     */
    private array $operators = [];

    /**
     * @var array
     */
    private array $fieldConfigs = [];

    /**
     * @param OperatorInterface $operator
     * @return $this
     */
    public function addOperator(OperatorInterface $operator): self
    {
        $this->operators[$operator->getValue()] = $operator;
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

    /**
     * @param FieldConfig[] $fieldConfigs
     * @return $this
     */
    public function setFieldConfigs(array $fieldConfigs): self
    {
        $this->shouldAutomaticallyAdjustPositions($fieldConfigs);

        $this->fieldConfigs = [];
        foreach ($fieldConfigs as $fieldConfig) {
            $this->addFieldConfig($fieldConfig->getName(), $fieldConfig);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getFieldConfigs(): array
    {
        return $this->getSortedFieldConfigs();
    }

    /**
     * @param string $name
     * @param FieldConfig $fieldConfig
     * @return $this
     */
    public function addFieldConfig(string $name, FieldConfig $fieldConfig): self
    {
        if ($this->automaticallyAdjustPosition) {
            $fieldConfig->setPosition(sizeof($this->fieldConfigs));
        }
        $this->fieldConfigs[$name] = $fieldConfig;

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function removeFieldConfig(string $name): self
    {
        if (array_key_exists($name, $this->fieldConfigs)) {
            unset($this->fieldConfigs[$name]);
        }

        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasFieldConfig(string $name): bool
    {
        return array_key_exists($name, $this->fieldConfigs);
    }

    /**
     * @return array
     */
    private function getSortedFieldConfigs(): array
    {
        usort($this->fieldConfigs, function (FieldConfig $a, FieldConfig $b) {
           return $a->getPosition() <=> $b->getPosition();
        });

        return $this->fieldConfigs;
    }

    /**
     * @param array $fieldConfigs
     * @return bool
     */
    private function shouldAutomaticallyAdjustPositions(array $fieldConfigs): bool
    {
        $autoSetPositions = false;
        foreach ($fieldConfigs as $fieldConfig) {
            if (null === $fieldConfig->getPosition()) {
                $autoSetPositions = true;
                break;
            }
        }

        return $autoSetPositions;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_map(function ($fieldConfig) {
            return $fieldConfig->toArray();
        }, $this->getSortedFieldConfigs());
    }
}
