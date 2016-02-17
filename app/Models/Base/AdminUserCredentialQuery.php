<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\AdminUserCredential as ChildAdminUserCredential;
use App\Models\AdminUserCredentialQuery as ChildAdminUserCredentialQuery;
use App\Models\Map\AdminUserCredentialTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'admin_user_credential' table.
 *
 *
 *
 * @method     ChildAdminUserCredentialQuery orderByAdminUserId($order = Criteria::ASC) Order by the admin_user_id column
 * @method     ChildAdminUserCredentialQuery orderByAdminCredentialId($order = Criteria::ASC) Order by the admin_credential_id column
 * @method     ChildAdminUserCredentialQuery orderByPermRead($order = Criteria::ASC) Order by the perm_read column
 * @method     ChildAdminUserCredentialQuery orderByPermWrite($order = Criteria::ASC) Order by the perm_write column
 * @method     ChildAdminUserCredentialQuery orderByPermExec($order = Criteria::ASC) Order by the perm_exec column
 * @method     ChildAdminUserCredentialQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildAdminUserCredentialQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildAdminUserCredentialQuery groupByAdminUserId() Group by the admin_user_id column
 * @method     ChildAdminUserCredentialQuery groupByAdminCredentialId() Group by the admin_credential_id column
 * @method     ChildAdminUserCredentialQuery groupByPermRead() Group by the perm_read column
 * @method     ChildAdminUserCredentialQuery groupByPermWrite() Group by the perm_write column
 * @method     ChildAdminUserCredentialQuery groupByPermExec() Group by the perm_exec column
 * @method     ChildAdminUserCredentialQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildAdminUserCredentialQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildAdminUserCredentialQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAdminUserCredentialQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAdminUserCredentialQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAdminUserCredentialQuery leftJoinAdminCredential($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdminCredential relation
 * @method     ChildAdminUserCredentialQuery rightJoinAdminCredential($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdminCredential relation
 * @method     ChildAdminUserCredentialQuery innerJoinAdminCredential($relationAlias = null) Adds a INNER JOIN clause to the query using the AdminCredential relation
 *
 * @method     ChildAdminUserCredentialQuery leftJoinAdminUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdminUser relation
 * @method     ChildAdminUserCredentialQuery rightJoinAdminUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdminUser relation
 * @method     ChildAdminUserCredentialQuery innerJoinAdminUser($relationAlias = null) Adds a INNER JOIN clause to the query using the AdminUser relation
 *
 * @method     \App\Models\AdminCredentialQuery|\App\Models\AdminUserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAdminUserCredential findOne(ConnectionInterface $con = null) Return the first ChildAdminUserCredential matching the query
 * @method     ChildAdminUserCredential findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAdminUserCredential matching the query, or a new ChildAdminUserCredential object populated from the query conditions when no match is found
 *
 * @method     ChildAdminUserCredential findOneByAdminUserId(int $admin_user_id) Return the first ChildAdminUserCredential filtered by the admin_user_id column
 * @method     ChildAdminUserCredential findOneByAdminCredentialId(int $admin_credential_id) Return the first ChildAdminUserCredential filtered by the admin_credential_id column
 * @method     ChildAdminUserCredential findOneByPermRead(int $perm_read) Return the first ChildAdminUserCredential filtered by the perm_read column
 * @method     ChildAdminUserCredential findOneByPermWrite(int $perm_write) Return the first ChildAdminUserCredential filtered by the perm_write column
 * @method     ChildAdminUserCredential findOneByPermExec(int $perm_exec) Return the first ChildAdminUserCredential filtered by the perm_exec column
 * @method     ChildAdminUserCredential findOneByCreatedAt(string $created_at) Return the first ChildAdminUserCredential filtered by the created_at column
 * @method     ChildAdminUserCredential findOneByUpdatedAt(string $updated_at) Return the first ChildAdminUserCredential filtered by the updated_at column *

 * @method     ChildAdminUserCredential requirePk($key, ConnectionInterface $con = null) Return the ChildAdminUserCredential by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUserCredential requireOne(ConnectionInterface $con = null) Return the first ChildAdminUserCredential matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAdminUserCredential requireOneByAdminUserId(int $admin_user_id) Return the first ChildAdminUserCredential filtered by the admin_user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUserCredential requireOneByAdminCredentialId(int $admin_credential_id) Return the first ChildAdminUserCredential filtered by the admin_credential_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUserCredential requireOneByPermRead(int $perm_read) Return the first ChildAdminUserCredential filtered by the perm_read column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUserCredential requireOneByPermWrite(int $perm_write) Return the first ChildAdminUserCredential filtered by the perm_write column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUserCredential requireOneByPermExec(int $perm_exec) Return the first ChildAdminUserCredential filtered by the perm_exec column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUserCredential requireOneByCreatedAt(string $created_at) Return the first ChildAdminUserCredential filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUserCredential requireOneByUpdatedAt(string $updated_at) Return the first ChildAdminUserCredential filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAdminUserCredential[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAdminUserCredential objects based on current ModelCriteria
 * @method     ChildAdminUserCredential[]|ObjectCollection findByAdminUserId(int $admin_user_id) Return ChildAdminUserCredential objects filtered by the admin_user_id column
 * @method     ChildAdminUserCredential[]|ObjectCollection findByAdminCredentialId(int $admin_credential_id) Return ChildAdminUserCredential objects filtered by the admin_credential_id column
 * @method     ChildAdminUserCredential[]|ObjectCollection findByPermRead(int $perm_read) Return ChildAdminUserCredential objects filtered by the perm_read column
 * @method     ChildAdminUserCredential[]|ObjectCollection findByPermWrite(int $perm_write) Return ChildAdminUserCredential objects filtered by the perm_write column
 * @method     ChildAdminUserCredential[]|ObjectCollection findByPermExec(int $perm_exec) Return ChildAdminUserCredential objects filtered by the perm_exec column
 * @method     ChildAdminUserCredential[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildAdminUserCredential objects filtered by the created_at column
 * @method     ChildAdminUserCredential[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildAdminUserCredential objects filtered by the updated_at column
 * @method     ChildAdminUserCredential[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AdminUserCredentialQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\AdminUserCredentialQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\AdminUserCredential', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAdminUserCredentialQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAdminUserCredentialQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAdminUserCredentialQuery) {
            return $criteria;
        }
        $query = new ChildAdminUserCredentialQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$admin_user_id, $admin_credential_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildAdminUserCredential|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AdminUserCredentialTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AdminUserCredentialTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAdminUserCredential A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT admin_user_id, admin_credential_id, perm_read, perm_write, perm_exec, created_at, updated_at FROM admin_user_credential WHERE admin_user_id = :p0 AND admin_credential_id = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildAdminUserCredential $obj */
            $obj = new ChildAdminUserCredential();
            $obj->hydrate($row);
            AdminUserCredentialTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildAdminUserCredential|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(AdminUserCredentialTableMap::COL_ADMIN_USER_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(AdminUserCredentialTableMap::COL_ADMIN_CREDENTIAL_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(AdminUserCredentialTableMap::COL_ADMIN_USER_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(AdminUserCredentialTableMap::COL_ADMIN_CREDENTIAL_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the admin_user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAdminUserId(1234); // WHERE admin_user_id = 1234
     * $query->filterByAdminUserId(array(12, 34)); // WHERE admin_user_id IN (12, 34)
     * $query->filterByAdminUserId(array('min' => 12)); // WHERE admin_user_id > 12
     * </code>
     *
     * @see       filterByAdminUser()
     *
     * @param     mixed $adminUserId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function filterByAdminUserId($adminUserId = null, $comparison = null)
    {
        if (is_array($adminUserId)) {
            $useMinMax = false;
            if (isset($adminUserId['min'])) {
                $this->addUsingAlias(AdminUserCredentialTableMap::COL_ADMIN_USER_ID, $adminUserId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($adminUserId['max'])) {
                $this->addUsingAlias(AdminUserCredentialTableMap::COL_ADMIN_USER_ID, $adminUserId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdminUserCredentialTableMap::COL_ADMIN_USER_ID, $adminUserId, $comparison);
    }

    /**
     * Filter the query on the admin_credential_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAdminCredentialId(1234); // WHERE admin_credential_id = 1234
     * $query->filterByAdminCredentialId(array(12, 34)); // WHERE admin_credential_id IN (12, 34)
     * $query->filterByAdminCredentialId(array('min' => 12)); // WHERE admin_credential_id > 12
     * </code>
     *
     * @see       filterByAdminCredential()
     *
     * @param     mixed $adminCredentialId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function filterByAdminCredentialId($adminCredentialId = null, $comparison = null)
    {
        if (is_array($adminCredentialId)) {
            $useMinMax = false;
            if (isset($adminCredentialId['min'])) {
                $this->addUsingAlias(AdminUserCredentialTableMap::COL_ADMIN_CREDENTIAL_ID, $adminCredentialId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($adminCredentialId['max'])) {
                $this->addUsingAlias(AdminUserCredentialTableMap::COL_ADMIN_CREDENTIAL_ID, $adminCredentialId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdminUserCredentialTableMap::COL_ADMIN_CREDENTIAL_ID, $adminCredentialId, $comparison);
    }

    /**
     * Filter the query on the perm_read column
     *
     * Example usage:
     * <code>
     * $query->filterByPermRead(1234); // WHERE perm_read = 1234
     * $query->filterByPermRead(array(12, 34)); // WHERE perm_read IN (12, 34)
     * $query->filterByPermRead(array('min' => 12)); // WHERE perm_read > 12
     * </code>
     *
     * @param     mixed $permRead The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function filterByPermRead($permRead = null, $comparison = null)
    {
        if (is_array($permRead)) {
            $useMinMax = false;
            if (isset($permRead['min'])) {
                $this->addUsingAlias(AdminUserCredentialTableMap::COL_PERM_READ, $permRead['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($permRead['max'])) {
                $this->addUsingAlias(AdminUserCredentialTableMap::COL_PERM_READ, $permRead['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdminUserCredentialTableMap::COL_PERM_READ, $permRead, $comparison);
    }

    /**
     * Filter the query on the perm_write column
     *
     * Example usage:
     * <code>
     * $query->filterByPermWrite(1234); // WHERE perm_write = 1234
     * $query->filterByPermWrite(array(12, 34)); // WHERE perm_write IN (12, 34)
     * $query->filterByPermWrite(array('min' => 12)); // WHERE perm_write > 12
     * </code>
     *
     * @param     mixed $permWrite The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function filterByPermWrite($permWrite = null, $comparison = null)
    {
        if (is_array($permWrite)) {
            $useMinMax = false;
            if (isset($permWrite['min'])) {
                $this->addUsingAlias(AdminUserCredentialTableMap::COL_PERM_WRITE, $permWrite['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($permWrite['max'])) {
                $this->addUsingAlias(AdminUserCredentialTableMap::COL_PERM_WRITE, $permWrite['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdminUserCredentialTableMap::COL_PERM_WRITE, $permWrite, $comparison);
    }

    /**
     * Filter the query on the perm_exec column
     *
     * Example usage:
     * <code>
     * $query->filterByPermExec(1234); // WHERE perm_exec = 1234
     * $query->filterByPermExec(array(12, 34)); // WHERE perm_exec IN (12, 34)
     * $query->filterByPermExec(array('min' => 12)); // WHERE perm_exec > 12
     * </code>
     *
     * @param     mixed $permExec The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function filterByPermExec($permExec = null, $comparison = null)
    {
        if (is_array($permExec)) {
            $useMinMax = false;
            if (isset($permExec['min'])) {
                $this->addUsingAlias(AdminUserCredentialTableMap::COL_PERM_EXEC, $permExec['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($permExec['max'])) {
                $this->addUsingAlias(AdminUserCredentialTableMap::COL_PERM_EXEC, $permExec['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdminUserCredentialTableMap::COL_PERM_EXEC, $permExec, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(AdminUserCredentialTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(AdminUserCredentialTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdminUserCredentialTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(AdminUserCredentialTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(AdminUserCredentialTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdminUserCredentialTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\AdminCredential object
     *
     * @param \App\Models\AdminCredential|ObjectCollection $adminCredential The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function filterByAdminCredential($adminCredential, $comparison = null)
    {
        if ($adminCredential instanceof \App\Models\AdminCredential) {
            return $this
                ->addUsingAlias(AdminUserCredentialTableMap::COL_ADMIN_CREDENTIAL_ID, $adminCredential->getId(), $comparison);
        } elseif ($adminCredential instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdminUserCredentialTableMap::COL_ADMIN_CREDENTIAL_ID, $adminCredential->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAdminCredential() only accepts arguments of type \App\Models\AdminCredential or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdminCredential relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function joinAdminCredential($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdminCredential');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'AdminCredential');
        }

        return $this;
    }

    /**
     * Use the AdminCredential relation AdminCredential object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\AdminCredentialQuery A secondary query class using the current class as primary query
     */
    public function useAdminCredentialQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAdminCredential($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdminCredential', '\App\Models\AdminCredentialQuery');
    }

    /**
     * Filter the query by a related \App\Models\AdminUser object
     *
     * @param \App\Models\AdminUser|ObjectCollection $adminUser The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function filterByAdminUser($adminUser, $comparison = null)
    {
        if ($adminUser instanceof \App\Models\AdminUser) {
            return $this
                ->addUsingAlias(AdminUserCredentialTableMap::COL_ADMIN_USER_ID, $adminUser->getId(), $comparison);
        } elseif ($adminUser instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdminUserCredentialTableMap::COL_ADMIN_USER_ID, $adminUser->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAdminUser() only accepts arguments of type \App\Models\AdminUser or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdminUser relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function joinAdminUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdminUser');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'AdminUser');
        }

        return $this;
    }

    /**
     * Use the AdminUser relation AdminUser object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\AdminUserQuery A secondary query class using the current class as primary query
     */
    public function useAdminUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAdminUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdminUser', '\App\Models\AdminUserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAdminUserCredential $adminUserCredential Object to remove from the list of results
     *
     * @return $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function prune($adminUserCredential = null)
    {
        if ($adminUserCredential) {
            $this->addCond('pruneCond0', $this->getAliasedColName(AdminUserCredentialTableMap::COL_ADMIN_USER_ID), $adminUserCredential->getAdminUserId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(AdminUserCredentialTableMap::COL_ADMIN_CREDENTIAL_ID), $adminUserCredential->getAdminCredentialId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the admin_user_credential table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AdminUserCredentialTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AdminUserCredentialTableMap::clearInstancePool();
            AdminUserCredentialTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AdminUserCredentialTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AdminUserCredentialTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AdminUserCredentialTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AdminUserCredentialTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(AdminUserCredentialTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(AdminUserCredentialTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(AdminUserCredentialTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(AdminUserCredentialTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(AdminUserCredentialTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildAdminUserCredentialQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(AdminUserCredentialTableMap::COL_CREATED_AT);
    }

} // AdminUserCredentialQuery
