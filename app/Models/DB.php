<?php

namespace App\Models;

use Closure;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\BaseConnection;
use Config\Database;

/**
 * @see \CodeIgniter\Database\BaseConnection
 * @see \CodeIgniter\Database\BaseBuilder
 *
 * @method static BaseBuilder testMode(bool $mode = true)
 * @method static BaseBuilder getBinds()
 * @method static BaseBuilder ignore(bool $ignore = true)
 * @method static BaseBuilder select($select = '*', bool $escape = null)
 * @method static BaseBuilder selectMax(string $select = '', string $alias = '')
 * @method static BaseBuilder selectMin(string $select = '', string $alias = '')
 * @method static BaseBuilder selectAvg(string $select = '', string $alias = '')
 * @method static BaseBuilder selectSum(string $select = '', string $alias = '')
 * @method static BaseBuilder selectCount(string $select = '', string $alias = '')
 * @method static BaseBuilder maxMinAvgSum(string $select = '', string $alias = '', string $type = 'MAX')
 * @method static BaseBuilder distinct(bool $val = true)
 * @method static BaseBuilder from($from, bool $overwrite = false)
 * @method static BaseBuilder join(string $table, string $cond, string $type = '', bool $escape = null)
 * @method static BaseBuilder where($key, $value = null, bool $escape = null)
 * @method static BaseBuilder orWhere($key, $value = null, bool $escape = null)
 * @method static BaseBuilder whereHaving(string $qb_key, $key, $value = null, string $type = 'AND ', bool $escape = null)
 * @method static BaseBuilder whereIn(string $key = null, $values = null, bool $escape = null)
 * @method static BaseBuilder orWhereIn(string $key = null, $values = null, bool $escape = null)
 * @method static BaseBuilder whereNotIn(string $key = null, $values = null, bool $escape = null)
 * @method static BaseBuilder orWhereNotIn(string $key = null, $values = null, bool $escape = null)
 * @method static BaseBuilder havingIn(string $key = null, $values = null, bool $escape = null)
 * @method static BaseBuilder orHavingIn(string $key = null, $values = null, bool $escape = null)
 * @method static BaseBuilder havingNotIn(string $key = null, $values = null, bool $escape = null)
 * @method static BaseBuilder orHavingNotIn(string $key = null, $values = null, bool $escape = null)
 * @method static BaseBuilder like($field, string $match = '', string $side = 'both', bool $escape = null, bool $insensitiveSearch = false)
 * @method static BaseBuilder notLike($field, string $match = '', string $side = 'both', bool $escape = null, bool $insensitiveSearch = false)
 * @method static BaseBuilder orLike($field, string $match = '', string $side = 'both', bool $escape = null, bool $insensitiveSearch = false)
 * @method static BaseBuilder orNotLike($field, string $match = '', string $side = 'both', bool $escape = null, bool $insensitiveSearch = false)
 * @method static BaseBuilder havingLike($field, string $match = '', string $side = 'both', bool $escape = null, bool $insensitiveSearch = false)
 * @method static BaseBuilder notHavingLike($field, string $match = '', string $side = 'both', bool $escape = null, bool $insensitiveSearch = false)
 * @method static BaseBuilder orHavingLike($field, string $match = '', string $side = 'both', bool $escape = null, bool $insensitiveSearch = false)
 * @method static BaseBuilder orNotHavingLike($field, string $match = '', string $side = 'both', bool $escape = null, bool $insensitiveSearch = false)
 * @method static BaseBuilder groupStart()
 * @method static BaseBuilder orGroupStart()
 * @method static BaseBuilder notGroupStart()
 * @method static BaseBuilder orNotGroupStart()
 * @method static BaseBuilder groupEnd()
 * @method static BaseBuilder havingGroupStart()
 * @method static BaseBuilder orHavingGroupStart()
 * @method static BaseBuilder notHavingGroupStart()
 * @method static BaseBuilder orNotHavingGroupStart()
 * @method static BaseBuilder havingGroupEnd()
 * @method static BaseBuilder groupBy($by, bool $escape = null)
 * @method static BaseBuilder having($key, $value = null, bool $escape = null)
 * @method static BaseBuilder orHaving($key, $value = null, bool $escape = null)
 * @method static BaseBuilder orderBy(string $orderBy, string $direction = '', bool $escape = null)
 * @method static BaseBuilder limit(int $value = null, ?int $offset = 0)
 * @method static BaseBuilder offset(int $offset)
 * @method static BaseBuilder set($key, ?string $value = '', bool $escape = null)
 * @method static BaseBuilder getSetData(bool $clean = false)
 * @method static BaseBuilder getCompiledSelect(bool $reset = true)
 * @method static BaseBuilder get(int $limit = null, int $offset = 0, bool $reset = true)
 * @method static BaseBuilder countAll(bool $reset = true)
 * @method static BaseBuilder countAllResults(bool $reset = true)
 * @method static BaseBuilder getCompiledQBWhere()
 * @method static BaseBuilder getWhere($where = null, int $limit = null, ?int $offset = 0, bool $reset = true)
 * @method static BaseBuilder insertBatch(array $set = null, bool $escape = null, int $batchSize = 100)
 * @method static BaseBuilder setInsertBatch($key, string $value = '', bool $escape = null)
 * @method static BaseBuilder getCompiledInsert(bool $reset = true)
 * @method static BaseBuilder insert(array $set = null, bool $escape = null)
 * @method static BaseBuilder replace(array $set = null)
 * @method static BaseBuilder getCompiledUpdate(bool $reset = true)
 * @method static BaseBuilder update(array $set = null, $where = null, int $limit = null)
 * @method static BaseBuilder updateBatch(array $set = null, string $index = null, int $batchSize = 100)
 * @method static BaseBuilder setUpdateBatch($key, string $index = '', bool $escape = null)
 * @method static BaseBuilder emptyTable()
 * @method static BaseBuilder truncate()
 * @method static BaseBuilder getCompiledDelete(bool $reset = true)
 * @method static BaseBuilder delete($where = '', int $limit = null, bool $reset_data = true)
 * @method static BaseBuilder increment(string $column, int $value = 1)
 * @method static BaseBuilder decrement(string $column, int $value = 1)
 * @method static BaseConnection|BaseBuilder query(string $sql, $binds = null, bool $setEscapeFlags = true, string $queryClass = 'CodeIgniter\\Database\\Query')
 * @method static BaseConnection|BaseBuilder simpleQuery(string $sql)
 * @method static BaseConnection|BaseBuilder transOff()
 * @method static BaseConnection|BaseBuilder transStrict(bool $mode = true)
 * @method static BaseConnection|BaseBuilder transStart(bool $test_mode = false)
 * @method static BaseConnection|BaseBuilder transComplete()
 * @method static BaseConnection|BaseBuilder transStatus()
 * @method static BaseConnection|BaseBuilder transBegin(bool $test_mode = false)
 * @method static BaseConnection|BaseBuilder transCommit()
 * @method static BaseConnection|BaseBuilder transRollback()
 * @method static BaseConnection|BaseBuilder prepare(Closure $func, array $options = [])
 * @method static BaseConnection|BaseBuilder getLastQuery()
 * @method static BaseConnection|BaseBuilder showLastQuery()
 * @method static BaseConnection|BaseBuilder getConnectStart()
 * @method static BaseConnection|BaseBuilder getConnectDuration(int $decimals = 6)
 * @method static BaseConnection|BaseBuilder protectIdentifiers($item, bool $prefixSingle = false, bool $protectIdentifiers = null, bool $fieldExists = true)
 * @method static BaseConnection|BaseBuilder escapeIdentifiers($item)
 * @method static BaseConnection|BaseBuilder prefixTable(string $table = '')
 * @method static BaseConnection|BaseBuilder affectedRows()
 * @method static BaseConnection|BaseBuilder escape($str)
 * @method static BaseConnection|BaseBuilder escapeString($str, bool $like = false)
 * @method static BaseConnection|BaseBuilder escapeLikeString($str)
 * @method static BaseConnection|BaseBuilder callFunction(string $functionName, ...$params) : bool
 * @method static BaseConnection|BaseBuilder listTables(bool $constrainByPrefix = false)
 * @method static BaseConnection|BaseBuilder tableExists(string $tableName)
 * @method static BaseConnection|BaseBuilder getFieldNames(string $table)
 * @method static BaseConnection|BaseBuilder fieldExists(string $fieldName, string $tableName)
 * @method static BaseConnection|BaseBuilder getFieldData(string $table)
 * @method static BaseConnection|BaseBuilder getIndexData(string $table)
 * @method static BaseConnection|BaseBuilder getForeignKeyData(string $table)
 * @method static BaseConnection|BaseBuilder disableForeignKeyChecks()
 * @method static BaseConnection|BaseBuilder enableForeignKeyChecks()
 * @method static BaseConnection|BaseBuilder pretend(bool $pretend = true)
 * @method static BaseConnection|BaseBuilder resetDataCache()
 * @method static BaseConnection|BaseBuilder error()
 * @method static BaseConnection|BaseBuilder insertID()
 * @method static BaseConnection|BaseBuilder __get(string $key)
 * @method static BaseConnection|BaseBuilder __isset(string $key)
 * @method static BaseConnection|BaseBuilder table(string $tableName)
 */
class DB
{
    /**
     * Call static base connection.
     *
     * @param $method
     * @param $argument
     * @return BaseConnection|BaseBuilder
     */
    public static function __callStatic($method, $arguments)
    {
        return Database::connect()->$method(...$arguments);
    }
}
