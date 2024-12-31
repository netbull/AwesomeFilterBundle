<?php

namespace NetBull\AwesomeFilterBundle\ORM;

use Doctrine\ORM\QueryBuilder;
use InvalidArgumentException;
use NetBull\AwesomeFilterBundle\Operators;

trait AwesomeFilterTrait
{
    /**
     * @param QueryBuilder $qb
     * @param array $params
     */
    public function addFilters(QueryBuilder $qb, array $params): void
    {
        foreach ($params as $i => $filter) {
            if (!is_array($filter) || !isset($filter['field']) || !isset($filter['operator'])) {
                continue;
            }

            try {
                $column = $this->getColumnNameByField($filter['field'], $filter);
                $this->addFilter($qb, $i, $filter['operator'], $column, $filter['value']);
            } catch (InvalidArgumentException $e) {}
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param int $index
     * @param string $operator
     * @param string $column
     * @param array|string|null $value
     * @throws InvalidArgumentException
     */
    public function addFilter(QueryBuilder $qb, int $index, string $operator, string $column, $value): void
    {
        $parameterName = 'param_'.$index;
        $parameters = [ $parameterName => $value ];
        switch ($operator) {
            case Operators\Is::TYPE:
                $qb->andWhere($qb->expr()->eq($column, ':'.$parameterName));
                break;
            case Operators\IsNot::TYPE:
                $qb->andWhere($qb->expr()->neq($column, ':'.$parameterName));
                break;
            case Operators\IsEmpty::TYPE:
                $parameters = [];
                $qb->andWhere($qb->expr()->isNull($column));
                break;
            case Operators\IsBetween::TYPE:
                $parts = explode('|', $value);
                $parameters = [
                    'param_'.$index.'_0' => $parts[0],
                    'param_'.$index.'_1' => $parts[1],
                ];
                $qb->andWhere($qb->expr()->between($column, ':param_'.$index.'_0', ':param_'.$index.'_1'));
                break;
            case Operators\Gt::TYPE:
                $qb->andWhere($qb->expr()->gt($column, ':'.$parameterName));
                break;
            case Operators\Gte::TYPE:
                $qb->andWhere($qb->expr()->gte($column, ':'.$parameterName));
                break;
            case Operators\Lt::TYPE:
                $qb->andWhere($qb->expr()->lt($column, ':'.$parameterName));
                break;
            case Operators\Lte::TYPE:
                $qb->andWhere($qb->expr()->lte($column, ':'.$parameterName));
                break;
            case Operators\Contains::TYPE:
                $qb->andWhere($qb->expr()->like($column, ':'.$parameterName));
                $parameters[$parameterName] = "%$value%";
                break;
            case Operators\Starts::TYPE:
                $qb->andWhere($qb->expr()->like($column, ':'.$parameterName));
                $parameters[$parameterName] = "$value%";
                break;
            case Operators\Ends::TYPE:
                $qb->andWhere($qb->expr()->like($column, ':'.$parameterName));
                $parameters[$parameterName] = "%$value";
                break;
            case Operators\IsIn::TYPE:
                $qb->andWhere($qb->expr()->in($column, ':'.$parameterName));
                $parameters[$parameterName] = $value;
                break;
            case Operators\IsNotIn::TYPE:
                $qb->andWhere($qb->expr()->notIn($column, ':'.$parameterName));
                $parameters[$parameterName] = $value;
                break;
            default:
                throw new InvalidArgumentException("Operator \"$operator\" is not defined.");
        }

        foreach ($parameters as $name => $value) {
            $qb->setParameter($name, $value);
        }
    }
}
