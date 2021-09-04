<?php
declare(strict_types=1);
namespace App\Examples;

use App\Ado\MySQLQueryBuilder;
use App\Ado\PostgresQueryBuilder;
use App\Interface\SQLQueryBuilder;

/**
 * Note that the client code uses the builder object directly. A designated
 * Director class is not necessary in this case, because the client code needs
 * different queries almost every time, so the sequence of the construction
 * steps cannot be easily reused.
 *
 * Since all our query builders create products of the same type (which is a
 * string), we can interact with all builders using their common interface.
 * Later, if we implement a new Builder class, we will be able to pass its
 * instance to the existing client code without breaking it thanks to the
 * SQLQueryBuilder interface.
 */
function clientCode(SQLQueryBuilder $queryBuilder)
{
    $query = $queryBuilder
        ->select('u', ["name", "email", "password"])
        ->where("age", "18", ">")
        ->where("age", "30", "<")
        ->limit(10, 10)
        ->debug();

    echo $query;
}

/**
 * The application selects the proper query builder type depending on a current
 * configuration or the environment settings.
 */
// if ($_ENV['database_type'] == 'postgres') {
//     $builder = new PostgresQueryBuilder(); } else {
//     $builder = new MysqlQueryBuilder(); }
//
// clientCode($builder);

echo "Testing MySQL query builder:\n";
clientCode(new MySQLQueryBuilder('usuario'));

echo "\n\n";

echo "Testing PostgreSQL query builder:\n";
clientCode(new PostgresQueryBuilder('usuario'));