<?php

namespace NetBull\AwesomeFilterBundle\ORM;

use Doctrine\ORM\QueryBuilder;

interface AwesomeFilterInterface
{
    /**
     * @param string $field
     * @param array $params
     * @return string
     * @throws InvalidArgumentException
     */
    public function getColumnNameByField(string $field, array $params): string;

    /**
     * @param QueryBuilder $qb
     * @param array $params
     */
    public function addFilters(QueryBuilder $qb, array $params): void;

    /**
     * @param QueryBuilder $qb
     * @param int $index
     * @param string $operator
     * @param string $column
     * @param string|null $value
     * @throws InvalidArgumentException
     */
    public function addFilter(QueryBuilder $qb, int $index, string $operator, string $column, ?string $value): void;
}
