<?php

namespace App\Models;

use Closure;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\BasePreparedQuery;
use CodeIgniter\Database\BaseResult;
use CodeIgniter\Database\Query;
use Config\Database;

/**
 * @see \CodeIgniter\Database\BaseConnection
 * @see \CodeIgniter\Database\BaseBuilder
 *
 * @method static $this testMode(bool $mode = true)
 * @method static array getBinds()
 * @method static $this ignore(bool $ignore = true)
 * @method static BaseBuilder select($select = '*', bool $escape = null)
 * @method static BaseBuilder selectMax(string $select = '', string $alias = '')
 * @method static BaseBuilder selectMin(string $select = '', string $alias = '')
 * @method static BaseBuilder selectAvg(string $select = '', string $alias = '')
 * @method static BaseBuilder selectSum(string $select = '', string $alias = '')
 * @method static BaseBuilder selectCount(string $select = '', string $alias = '')
 * @method static BaseBuilder distinct(bool $val = true)
 * @method static BaseBuilder from($from, bool $overwrite = false)
 * @method static BaseBuilder join(string $table, string $cond, string $type = '', bool $escape = null)
 * @method static BaseBuilder where($key, $value = null, bool $escape = null)
 * @method static BaseBuilder orWhere($key, $value = null, bool $escape = null)
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
 * @method static BaseBuilder|null setInsertBatch($key, string $value = '', bool $escape = null)
 * @method static string getCompiledInsert(bool $reset = true)
 * @method static BaseResult|Query|false insert(array $set = null, bool $escape = null)
 * @method static BaseResult|Query|string|false replace(array $set = null)
 * @method static string getCompiledUpdate(bool $reset = true)
 * @method static boolean update(array $set = null, $where = null, int $limit = null)
 * @method static mixed updateBatch(array $set = null, string $index = null, int $batchSize = 100)
 * @method static BaseBuilder|null setUpdateBatch($key, string $index = '', bool $escape = null)
 * @method static boolean emptyTable()
 * @method static boolean truncate()
 * @method static string getCompiledDelete(bool $reset = true)
 * @method static mixed delete($where = '', int $limit = null, bool $reset_data = true)
 * @method static boolean increment(string $column, int $value = 1)
 * @method static boolean decrement(string $column, int $value = 1)
 * @method static BaseBuilder resetQuery()
 * @method static void close()
 * @method static mixed persistentConnect()
 * @method static mixed reconnect()
 * @method static mixed getConnection(string $alias = null)
 * @method static mixed setDatabase(string $databaseName)
 * @method static string getDatabase()
 * @method static string setPrefix(string $prefix = '')
 * @method static string getPrefix()
 * @method static string getPlatform()
 * @method static string getVersion()
 * @method static $this setAliasedTables(array $aliases)
 * @method static $this addTableAlias(string $table)
 * @method static mixed execute(string $sql)
 * @method static BaseResult|Query|false query(string $sql, $binds = null, bool $setEscapeFlags = true, string $queryClass = 'CodeIgniter\\Database\\Query')
 * @method static mixed simpleQuery(string $sql)
 * @method static void transOff()
 * @method static $this transStrict(bool $mode = true)
 * @method static boolean transStart(bool $test_mode = false)
 * @method static boolean transComplete()
 * @method static boolean transStatus()
 * @method static boolean transBegin(bool $test_mode = false)
 * @method static boolean transCommit()
 * @method static boolean transRollback()
 * @method static BaseBuilder table($tableName)
 * @method static BasePreparedQuery|null prepare(Closure $func, array $options = [])
 * @method static mixed getLastQuery()
 * @method static string showLastQuery()
 * @method static float|null getConnectStart()
 * @method static string getConnectDuration(int $decimals = 6)
 * @method static string|array protectIdentifiers($item, bool $prefixSingle = false, bool $protectIdentifiers = null, bool $fieldExists = true)
 * @method static mixed escapeIdentifiers($item)
 * @method static string prefixTable(string $table = '')
 * @method static mixed affectedRows()
 * @method static mixed escape($str)
 * @method static string|string[] escapeString($str, bool $like = false)
 * @method static string|string[] escapeLikeString($str)
 * @method static boolean callFunction(string $functionName, ...$params): bool
 * @method static boolean|array listTables(bool $constrainByPrefix = false)
 * @method static boolean tableExists(string $tableName)
 * @method static array|false getFieldNames(string $table)
 * @method static boolean fieldExists(string $fieldName, string $tableName)
 * @method static array|false getFieldData(string $table)
 * @method static array|false getIndexData(string $table)
 * @method static array|false getForeignKeyData(string $table)
 * @method static mixed disableForeignKeyChecks()
 * @method static mixed enableForeignKeyChecks()
 * @method static $this pretend(bool $pretend = true)
 * @method static $this resetDataCache()
 * @method static array error()
 * @method static int insertID()
 */
class DB
{
    /** @var Database */
    protected $manager;

    /**
     * Create new connection database manager.
     *
     * @return void
     */
    public function __construct()
    {
        $this->manager = new Database();
    }

    /**
     * Get a connection instance from the global manager.
     *
     * @param  string|null  $connection
     * @return BaseConnection
     */
    public static function connection($connection = null)
    {
        return (new static())->getConnection($connection);
    }

    /**
     * Get a registered connection instance.
     *
     * @param  string|null  $name
     * @return BaseConnection
     */
    public function getConnection($name = null)
    {
        return $this->manager->connect($name);
    }

    /**
     * Call static base connection instance.
     *
     * @param $method
     * @param $arguments
     * @return BaseConnection|BaseBuilder
     */
    public static function __callStatic($method, $arguments)
    {
        return static::connection()->$method(...$arguments);
    }
}
