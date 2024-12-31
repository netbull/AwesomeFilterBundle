<?php

namespace NetBull\AwesomeFilterBundle\Model;

use LogicException;

class FieldConfigsChain
{
    /**
     * @var bool
     */
    private bool $automaticallyAdjustPosition = false;

    /**
     * @var array
     */
    private array $fieldConfigs = [];

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
     * @param FieldConfig $fieldConfig
     * @return $this
     */
    public function addFieldConfig(FieldConfig $fieldConfig): self
    {
        if (!$fieldConfig->getName()) {
            throw new LogicException('FieldConfig name must be defined');
        }

        if ($this->automaticallyAdjustPosition) {
            $fieldConfig->setPosition(sizeof($this->fieldConfigs));
        }
        $this->fieldConfigs[$fieldConfig->getName()] = $fieldConfig;

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
     * @return void
     */
    private function shouldAutomaticallyAdjustPositions(array $fieldConfigs): void
    {
        $autoSetPositions = false;
        foreach ($fieldConfigs as $fieldConfig) {
            if (null === $fieldConfig->getPosition()) {
                $autoSetPositions = true;
                break;
            }
        }

        $this->automaticallyAdjustPosition = $autoSetPositions;
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
