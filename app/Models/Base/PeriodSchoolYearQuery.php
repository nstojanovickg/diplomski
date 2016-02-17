<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\PeriodSchoolYear as ChildPeriodSchoolYear;
use App\Models\PeriodSchoolYearQuery as ChildPeriodSchoolYearQuery;
use App\Models\Map\PeriodSchoolYearTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'period_school_year' table.
 *
 *
 *
 * @method     ChildPeriodSchoolYearQuery orderByPeriodId($order = Criteria::ASC) Order by the period_id column
 * @method     ChildPeriodSchoolYearQuery orderBySchoolYearId($order = Criteria::ASC) Order by the school_year_id column
 * @method     ChildPeriodSchoolYearQuery orderByDateStart($order = Criteria::ASC) Order by the date_start column
 * @method     ChildPeriodSchoolYearQuery orderByDateEnd($order = Criteria::ASC) Order by the date_end column
 * @method     ChildPeriodSchoolYearQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildPeriodSchoolYearQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildPeriodSchoolYearQuery groupByPeriodId() Group by the period_id column
 * @method     ChildPeriodSchoolYearQuery groupBySchoolYearId() Group by the school_year_id column
 * @method     ChildPeriodSchoolYearQuery groupByDateStart() Group by the date_start column
 * @method     ChildPeriodSchoolYearQuery groupByDateEnd() Group by the date_end column
 * @method     ChildPeriodSchoolYearQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildPeriodSchoolYearQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildPeriodSchoolYearQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPeriodSchoolYearQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPeriodSchoolYearQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPeriodSchoolYearQuery leftJoinPeriod($relationAlias = null) Adds a LEFT JOIN clause to the query using the Period relation
 * @method     ChildPeriodSchoolYearQuery rightJoinPeriod($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Period relation
 * @method     ChildPeriodSchoolYearQuery innerJoinPeriod($relationAlias = null) Adds a INNER JOIN clause to the query using the Period relation
 *
 * @method     ChildPeriodSchoolYearQuery leftJoinSchoolYear($relationAlias = null) Adds a LEFT JOIN clause to the query using the SchoolYear relation
 * @method     ChildPeriodSchoolYearQuery rightJoinSchoolYear($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SchoolYear relation
 * @method     ChildPeriodSchoolYearQuery innerJoinSchoolYear($relationAlias = null) Adds a INNER JOIN clause to the query using the SchoolYear relation
 *
 * @method     \App\Models\PeriodQuery|\App\Models\SchoolYearQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPeriodSchoolYear findOne(ConnectionInterface $con = null) Return the first ChildPeriodSchoolYear matching the query
 * @method     ChildPeriodSchoolYear findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPeriodSchoolYear matching the query, or a new ChildPeriodSchoolYear object populated from the query conditions when no match is found
 *
 * @method     ChildPeriodSchoolYear findOneByPeriodId(int $period_id) Return the first ChildPeriodSchoolYear filtered by the period_id column
 * @method     ChildPeriodSchoolYear findOneBySchoolYearId(int $school_year_id) Return the first ChildPeriodSchoolYear filtered by the school_year_id column
 * @method     ChildPeriodSchoolYear findOneByDateStart(string $date_start) Return the first ChildPeriodSchoolYear filtered by the date_start column
 * @method     ChildPeriodSchoolYear findOneByDateEnd(string $date_end) Return the first ChildPeriodSchoolYear filtered by the date_end column
 * @method     ChildPeriodSchoolYear findOneByCreatedAt(string $created_at) Return the first ChildPeriodSchoolYear filtered by the created_at column
 * @method     ChildPeriodSchoolYear findOneByUpdatedAt(string $updated_at) Return the first ChildPeriodSchoolYear filtered by the updated_at column *

 * @method     ChildPeriodSchoolYear requirePk($key, ConnectionInterface $con = null) Return the ChildPeriodSchoolYear by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeriodSchoolYear requireOne(ConnectionInterface $con = null) Return the first ChildPeriodSchoolYear matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPeriodSchoolYear requireOneByPeriodId(int $period_id) Return the first ChildPeriodSchoolYear filtered by the period_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeriodSchoolYear requireOneBySchoolYearId(int $school_year_id) Return the first ChildPeriodSchoolYear filtered by the school_year_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeriodSchoolYear requireOneByDateStart(string $date_start) Return the first ChildPeriodSchoolYear filtered by the date_start column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeriodSchoolYear requireOneByDateEnd(string $date_end) Return the first ChildPeriodSchoolYear filtered by the date_end column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeriodSchoolYear requireOneByCreatedAt(string $created_at) Return the first ChildPeriodSchoolYear filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeriodSchoolYear requireOneByUpdatedAt(string $updated_at) Return the first ChildPeriodSchoolYear filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPeriodSchoolYear[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPeriodSchoolYear objects based on current ModelCriteria
 * @method     ChildPeriodSchoolYear[]|ObjectCollection findByPeriodId(int $period_id) Return ChildPeriodSchoolYear objects filtered by the period_id column
 * @method     ChildPeriodSchoolYear[]|ObjectCollection findBySchoolYearId(int $school_year_id) Return ChildPeriodSchoolYear objects filtered by the school_year_id column
 * @method     ChildPeriodSchoolYear[]|ObjectCollection findByDateStart(string $date_start) Return ChildPeriodSchoolYear objects filtered by the date_start column
 * @method     ChildPeriodSchoolYear[]|ObjectCollection findByDateEnd(string $date_end) Return ChildPeriodSchoolYear objects filtered by the date_end column
 * @method     ChildPeriodSchoolYear[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildPeriodSchoolYear objects filtered by the created_at column
 * @method     ChildPeriodSchoolYear[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildPeriodSchoolYear objects filtered by the updated_at column
 * @method     ChildPeriodSchoolYear[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PeriodSchoolYearQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\PeriodSchoolYearQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\PeriodSchoolYear', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPeriodSchoolYearQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPeriodSchoolYearQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPeriodSchoolYearQuery) {
            return $criteria;
        }
        $query = new ChildPeriodSchoolYearQuery();
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
     * @param array[$period_id, $school_year_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPeriodSchoolYear|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PeriodSchoolYearTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PeriodSchoolYearTableMap::DATABASE_NAME);
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
     * @return ChildPeriodSchoolYear A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT period_id, school_year_id, date_start, date_end, created_at, updated_at FROM period_school_year WHERE period_id = :p0 AND school_year_id = :p1';
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
            /** @var ChildPeriodSchoolYear $obj */
            $obj = new ChildPeriodSchoolYear();
            $obj->hydrate($row);
            PeriodSchoolYearTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildPeriodSchoolYear|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(PeriodSchoolYearTableMap::COL_PERIOD_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(PeriodSchoolYearTableMap::COL_SCHOOL_YEAR_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(PeriodSchoolYearTableMap::COL_PERIOD_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(PeriodSchoolYearTableMap::COL_SCHOOL_YEAR_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the period_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPeriodId(1234); // WHERE period_id = 1234
     * $query->filterByPeriodId(array(12, 34)); // WHERE period_id IN (12, 34)
     * $query->filterByPeriodId(array('min' => 12)); // WHERE period_id > 12
     * </code>
     *
     * @see       filterByPeriod()
     *
     * @param     mixed $periodId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function filterByPeriodId($periodId = null, $comparison = null)
    {
        if (is_array($periodId)) {
            $useMinMax = false;
            if (isset($periodId['min'])) {
                $this->addUsingAlias(PeriodSchoolYearTableMap::COL_PERIOD_ID, $periodId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($periodId['max'])) {
                $this->addUsingAlias(PeriodSchoolYearTableMap::COL_PERIOD_ID, $periodId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PeriodSchoolYearTableMap::COL_PERIOD_ID, $periodId, $comparison);
    }

    /**
     * Filter the query on the school_year_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySchoolYearId(1234); // WHERE school_year_id = 1234
     * $query->filterBySchoolYearId(array(12, 34)); // WHERE school_year_id IN (12, 34)
     * $query->filterBySchoolYearId(array('min' => 12)); // WHERE school_year_id > 12
     * </code>
     *
     * @see       filterBySchoolYear()
     *
     * @param     mixed $schoolYearId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function filterBySchoolYearId($schoolYearId = null, $comparison = null)
    {
        if (is_array($schoolYearId)) {
            $useMinMax = false;
            if (isset($schoolYearId['min'])) {
                $this->addUsingAlias(PeriodSchoolYearTableMap::COL_SCHOOL_YEAR_ID, $schoolYearId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($schoolYearId['max'])) {
                $this->addUsingAlias(PeriodSchoolYearTableMap::COL_SCHOOL_YEAR_ID, $schoolYearId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PeriodSchoolYearTableMap::COL_SCHOOL_YEAR_ID, $schoolYearId, $comparison);
    }

    /**
     * Filter the query on the date_start column
     *
     * Example usage:
     * <code>
     * $query->filterByDateStart('2011-03-14'); // WHERE date_start = '2011-03-14'
     * $query->filterByDateStart('now'); // WHERE date_start = '2011-03-14'
     * $query->filterByDateStart(array('max' => 'yesterday')); // WHERE date_start > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateStart The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function filterByDateStart($dateStart = null, $comparison = null)
    {
        if (is_array($dateStart)) {
            $useMinMax = false;
            if (isset($dateStart['min'])) {
                $this->addUsingAlias(PeriodSchoolYearTableMap::COL_DATE_START, $dateStart['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateStart['max'])) {
                $this->addUsingAlias(PeriodSchoolYearTableMap::COL_DATE_START, $dateStart['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PeriodSchoolYearTableMap::COL_DATE_START, $dateStart, $comparison);
    }

    /**
     * Filter the query on the date_end column
     *
     * Example usage:
     * <code>
     * $query->filterByDateEnd('2011-03-14'); // WHERE date_end = '2011-03-14'
     * $query->filterByDateEnd('now'); // WHERE date_end = '2011-03-14'
     * $query->filterByDateEnd(array('max' => 'yesterday')); // WHERE date_end > '2011-03-13'
     * </code>
     *
     * @param     mixed $dateEnd The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function filterByDateEnd($dateEnd = null, $comparison = null)
    {
        if (is_array($dateEnd)) {
            $useMinMax = false;
            if (isset($dateEnd['min'])) {
                $this->addUsingAlias(PeriodSchoolYearTableMap::COL_DATE_END, $dateEnd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dateEnd['max'])) {
                $this->addUsingAlias(PeriodSchoolYearTableMap::COL_DATE_END, $dateEnd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PeriodSchoolYearTableMap::COL_DATE_END, $dateEnd, $comparison);
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
     * @return $this|ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PeriodSchoolYearTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PeriodSchoolYearTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PeriodSchoolYearTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(PeriodSchoolYearTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(PeriodSchoolYearTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PeriodSchoolYearTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\Period object
     *
     * @param \App\Models\Period|ObjectCollection $period The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function filterByPeriod($period, $comparison = null)
    {
        if ($period instanceof \App\Models\Period) {
            return $this
                ->addUsingAlias(PeriodSchoolYearTableMap::COL_PERIOD_ID, $period->getId(), $comparison);
        } elseif ($period instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PeriodSchoolYearTableMap::COL_PERIOD_ID, $period->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPeriod() only accepts arguments of type \App\Models\Period or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Period relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function joinPeriod($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Period');

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
            $this->addJoinObject($join, 'Period');
        }

        return $this;
    }

    /**
     * Use the Period relation Period object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\PeriodQuery A secondary query class using the current class as primary query
     */
    public function usePeriodQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPeriod($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Period', '\App\Models\PeriodQuery');
    }

    /**
     * Filter the query by a related \App\Models\SchoolYear object
     *
     * @param \App\Models\SchoolYear|ObjectCollection $schoolYear The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function filterBySchoolYear($schoolYear, $comparison = null)
    {
        if ($schoolYear instanceof \App\Models\SchoolYear) {
            return $this
                ->addUsingAlias(PeriodSchoolYearTableMap::COL_SCHOOL_YEAR_ID, $schoolYear->getId(), $comparison);
        } elseif ($schoolYear instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PeriodSchoolYearTableMap::COL_SCHOOL_YEAR_ID, $schoolYear->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySchoolYear() only accepts arguments of type \App\Models\SchoolYear or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SchoolYear relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function joinSchoolYear($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SchoolYear');

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
            $this->addJoinObject($join, 'SchoolYear');
        }

        return $this;
    }

    /**
     * Use the SchoolYear relation SchoolYear object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\SchoolYearQuery A secondary query class using the current class as primary query
     */
    public function useSchoolYearQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSchoolYear($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SchoolYear', '\App\Models\SchoolYearQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPeriodSchoolYear $periodSchoolYear Object to remove from the list of results
     *
     * @return $this|ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function prune($periodSchoolYear = null)
    {
        if ($periodSchoolYear) {
            $this->addCond('pruneCond0', $this->getAliasedColName(PeriodSchoolYearTableMap::COL_PERIOD_ID), $periodSchoolYear->getPeriodId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(PeriodSchoolYearTableMap::COL_SCHOOL_YEAR_ID), $periodSchoolYear->getSchoolYearId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the period_school_year table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PeriodSchoolYearTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PeriodSchoolYearTableMap::clearInstancePool();
            PeriodSchoolYearTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PeriodSchoolYearTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PeriodSchoolYearTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PeriodSchoolYearTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PeriodSchoolYearTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(PeriodSchoolYearTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(PeriodSchoolYearTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(PeriodSchoolYearTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(PeriodSchoolYearTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(PeriodSchoolYearTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildPeriodSchoolYearQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(PeriodSchoolYearTableMap::COL_CREATED_AT);
    }

} // PeriodSchoolYearQuery
