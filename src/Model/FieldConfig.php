<?php

namespace NetBull\AwesomeFilterBundle\Model;

use NetBull\AwesomeFilterBundle\Constants\FieldConstants;
use NetBull\AwesomeFilterBundle\Operators\OperatorInterface;

class FieldConfig
{
    /**
     * @var string|null
     */
    private ?string $label;

    /**
     * @var string|null
     */
    private string $type = FieldConstants::TYPE_TEXT;

    /**
     * @var OperatorInterface[]
     */
    private array $operators = [];

    /**
     * @var string|null Used for Select type to populate the options list
     */
    private ?string $optionName = null;

    /**
     * @var bool Should this field be used multiple times
     */
    private bool $multiple = true;

    /**
     * @var bool Should this field have multiple values
     */
    private bool $multiselect = false;

    /**
     * @var bool Default option for the UI to know that this field is available
     */
    private bool $available = true;

    /**
     * @var bool Shoud this field be used for filtering
     */
    private bool $filterable = true;

    /**
     * @var bool Shoud this field be used for sorting
     */
    private bool $sortable = true;

    /**
     * @var bool Is this field required
     */
    private bool $required = false;

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string|null $label
     * @return FieldConfig
     */
    public function setLabel(?string $label): FieldConfig
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return FieldConfig
     */
    public function setType(?string $type): FieldConfig
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return OperatorInterface[]
     */
    public function getOperators(): array
    {
        return $this->operators;
    }

    /**
     * @param OperatorInterface[] $operators
     * @return FieldConfig
     */
    public function setOperators(array $operators): FieldConfig
    {
        $this->operators = $operators;
        return $this;
    }

    /**
     * @param OperatorInterface $operator
     * @return $this
     */
    public function addOperator(OperatorInterface $operator): FieldConfig
    {
        $usedOperators = array_map(function (OperatorInterface $operator) {
            return $operator->getValue();
        }, $this->getOperators());

        if (!in_array($operator->getValue(), $usedOperators)) {
            $this->operators[] = $operator;
        }
        return $this;
    }

    /**
     * @param OperatorInterface $operator
     * @return $this
     */
    public function removeOperator(OperatorInterface $operator): FieldConfig
    {
        $usedOperators = array_map(function (OperatorInterface $operator) {
            return $operator->getValue();
        }, $this->getOperators());

        if (false !== $index = array_search($operator->getValue(), $usedOperators)) {
            unset($this->operators[$index]);
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOptionName(): ?string
    {
        return $this->optionName;
    }

    /**
     * @param string|null $optionName
     * @return FieldConfig
     */
    public function setOptionName(?string $optionName): FieldConfig
    {
        $this->optionName = $optionName;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMultiple(): bool
    {
        return $this->multiple;
    }

    /**
     * @param bool $multiple
     * @return FieldConfig
     */
    public function setMultiple(bool $multiple): FieldConfig
    {
        $this->multiple = $multiple;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMultiselect(): bool
    {
        return $this->multiselect;
    }

    /**
     * @param bool $multiselect
     * @return FieldConfig
     */
    public function setMultiselect(bool $multiselect): FieldConfig
    {
        $this->multiselect = $multiselect;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->available;
    }

    /**
     * @param bool $available
     * @return FieldConfig
     */
    public function setAvailable(bool $available): FieldConfig
    {
        $this->available = $available;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFilterable(): bool
    {
        return $this->filterable;
    }

    /**
     * @param bool $filterable
     * @return FieldConfig
     */
    public function setFilterable(bool $filterable): FieldConfig
    {
        $this->filterable = $filterable;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     * @param bool $sortable
     * @return FieldConfig
     */
    public function setSortable(bool $sortable): FieldConfig
    {
        $this->sortable = $sortable;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @param bool $required
     * @return FieldConfig
     */
    public function setRequired(bool $required): FieldConfig
    {
        $this->required = $required;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'label' => $this->getLabel(),
            'type' => $this->getType(),
            'operators' => array_map(function (OperatorInterface $operator) {
                return $operator->toArray();
            }, $this->getOperators()),
            'optionName' => $this->getOptionName(),
            'multiple' => $this->isMultiple(),
            'multiselect' => $this->isMultiselect(),
            'available' => $this->isAvailable(),
            'filterable' => $this->isFilterable(),
            'sortable' => $this->isSortable(),
            'required' => $this->isRequired(),
        ];
    }
}
