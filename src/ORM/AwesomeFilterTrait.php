<?php

namespace NetBull\AwesomeFilterBundle\ORM;

use Doctrine\ORM\QueryBuilder;
use NetBull\AwesomeFilterBundle\Constants\AwesomeFilterConstants;

/**
 * Trait AwesomeFilterTrait
 * @package NetBull\AwesomeFilterBundle\ORM
 */
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
                $column = $this->getColumnNameByField($filter['field']);
                $this->addFilter($qb, $i, $filter['operator'], $column, $filter['value']);
            } catch (InvalidArgumentException $e) {}
        }
    }

    /**
     * @param QueryBuilder $qb
     * @param int $index
     * @param string $operator
     * @param string $column
     * @param string|null $value
     * @throws InvalidArgumentException
     */
    public function addFilter(QueryBuilder $qb, int $index, string $operator, string $column, ?string $value): void
    {
        $parameterName = 'param_'.$index;
        $parameters = [ $parameterName => $value ];
        switch ($operator) {
            case AwesomeFilterConstants::OPERATOR_IS['value']:
                $qb->andWhere($qb->expr()->eq($column, ':'.$parameterName));
                break;
            case AwesomeFilterConstants::OPERATOR_IS_NOT['value']:
                $qb->andWhere($qb->expr()->neq($column, ':'.$parameterName));
                break;
            case AwesomeFilterConstants::OPERATOR_IS_EMPTY['value']:
                $parameters = [];
                $qb->andWhere($qb->expr()->isNull($column));
                break;
            case AwesomeFilterConstants::OPERATOR_IS_BETWEEN['value']:
                $parts = explode('|', $value);
                $parameters = [
                    'param_'.$index.'_0' => $parts[0],
                    'param_'.$index.'_1' => $parts[1],
                ];
                $qb->andWhere($qb->expr()->between($column, ':param_'.$index.'_0', ':param_'.$index.'_1'));
                break;
            case AwesomeFilterConstants::OPERATOR_GT['value']:
                $qb->andWhere($qb->expr()->gt($column, ':'.$parameterName));
                break;
            case AwesomeFilterConstants::OPERATOR_GTE['value']:
                $qb->andWhere($qb->expr()->gte($column, ':'.$parameterName));
                break;
            case AwesomeFilterConstants::OPERATOR_LT['value']:
                $qb->andWhere($qb->expr()->lt($column, ':'.$parameterName));
                break;
            case AwesomeFilterConstants::OPERATOR_LTE['value']:
                $qb->andWhere($qb->expr()->lte($column, ':'.$parameterName));
                break;
            case AwesomeFilterConstants::OPERATOR_CONTAINS['value']:
                $qb->andWhere($qb->expr()->like($column, ':'.$parameterName));
                $parameters[$parameterName] = "%$value%";
                break;
            case AwesomeFilterConstants::OPERATOR_STARTS['value']:
                $qb->andWhere($qb->expr()->like($column, ':'.$parameterName));
                $parameters[$parameterName] = "$value%";
                break;
            case AwesomeFilterConstants::OPERATOR_ENDS['value']:
                $qb->andWhere($qb->expr()->like($column, ':'.$parameterName));
                $parameters[$parameterName] = "%$value";
                break;
            default:
                throw new InvalidArgumentException("Operator \"$operator\" is not defined.");
        }

        foreach ($parameters as $name => $value) {
            $qb->setParameter($name, $value);
        }
    }
}