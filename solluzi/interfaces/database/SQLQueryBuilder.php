<?php
declare(strict_types = 1);
namespace Solluzi\Interfaces\Database;

/**
 * 
 */
interface SQLQueryBuilder
{
    // +100 outras sintaxes 

    public function select(string $alias, array $fields): SQLQueryBuilder;

    public function join(string $table, string $alias, string $field1, string $operator, string $field2): SQLQueryBuilder;

    public function leftJoin(string $table, string $alias, string $field1, string $operator, string $field2): SQLQueryBuilder;

    public function rightJoin(string $table, string $alias, string $field1, string $operator, string $field2): SQLQueryBuilder;

    public function union(object $table, array $fields ): SQLQueryBuilder;

    public function unionAll(object $table, array $fields ): SQLQueryBuilder;

    public function where(string $field, $value, string $operator = '='): SQLQueryBuilder;

    public function orWhere(string $field, $value, string $operator = "="): SQLQueryBuilder;

    public function whereIn(string $field, array $data): SQLQueryBuilder;

    public function whereNotIn(string $field, array $data): SQLQueryBuilder;

    public function whereNull(string $field): SQLQueryBuilder;

    public function whereNotNull(string $field): SQLQueryBuilder;

    public function having(string $field, string $value, string $operator = "="): SQLQueryBuilder;

    public function between(string $field, array $data): SQLQueryBuilder;

    public function notBetween(string $field, array $data): SQLQueryBuilder;

    public function orderBy(string $field, string $direction): SQLQueryBuilder;

    public function groupBy(array $fields) : SQLQueryBuilder;

    public function limit(int $start, int $offset = 0): SQLQueryBuilder;

    public function insert(array $datas): SQLQueryBuilder;

    public function update(array $datas): SQLQueryBuilder;

    public function instruction(string $function);

    public function instructionValues($values);

    public function delete(): SQLQueryBuilder;

    public function get();

    public function getAll();

    public function execute();

    public function lastId(string $primaryKey): int;

    public function getId();

    public function debug();
    
}