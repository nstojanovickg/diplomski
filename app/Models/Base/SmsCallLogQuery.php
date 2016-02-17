<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\SmsCallLog as ChildSmsCallLog;
use App\Models\SmsCallLogQuery as ChildSmsCallLogQuery;
use App\Models\Map\SmsCallLogTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'sms_call_log' table.
 *
 *
 *
 * @method     ChildSmsCallLogQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildSmsCallLogQuery orderByStudentId($order = Criteria::ASC) Order by the student_id column
 * @method     ChildSmsCallLogQuery orderBySubjectId($order = Criteria::ASC) Order by the subject_id column
 * @method     ChildSmsCallLogQuery orderByPeriodId($order = Criteria::ASC) Order by the period_id column
 * @method     ChildSmsCallLogQuery orderByApplicationDate($order = Criteria::ASC) Order by the application_date column
 * @method     ChildSmsCallLogQuery orderByIsSuccess($order = Criteria::ASC) Order by the is_success column
 * @method     ChildSmsCallLogQuery orderByApplicationRequestId($order = Criteria::ASC) Order by the application_request_id column
 * @method     ChildSmsCallLogQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildSmsCallLogQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildSmsCallLogQuery groupById() Group by the id column
 * @method     ChildSmsCallLogQuery groupByStudentId() Group by the student_id column
 * @method     ChildSmsCallLogQuery groupBySubjectId() Group by the subject_id column
 * @method     ChildSmsCallLogQuery groupByPeriodId() Group by the period_id column
 * @method     ChildSmsCallLogQuery groupByApplicationDate() Group by the application_date column
 * @method     ChildSmsCallLogQuery groupByIsSuccess() Group by the is_success column
 * @method     ChildSmsCallLogQuery groupByApplicationRequestId() Group by the application_request_id column
 * @method     ChildSmsCallLogQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildSmsCallLogQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildSmsCallLogQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSmsCallLogQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSmsCallLogQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSmsCallLogQuery leftJoinApplicationRequest($relationAlias = null) Adds a LEFT JOIN clause to the query using the ApplicationRequest relation
 * @method     ChildSmsCallLogQuery rightJoinApplicationRequest($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ApplicationRequest relation
 * @method     ChildSmsCallLogQuery innerJoinApplicationRequest($relationAlias = null) Adds a INNER JOIN clause to the query using the ApplicationRequest relation
 *
 * @method     ChildSmsCallLogQuery leftJoinPeriod($relationAlias = null) Adds a LEFT JOIN clause to the query using the Period relation
 * @method     ChildSmsCallLogQuery rightJoinPeriod($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Period relation
 * @method     ChildSmsCallLogQuery innerJoinPeriod($relationAlias = null) Adds a INNER JOIN clause to the query using the Period relation
 *
 * @method     ChildSmsCallLogQuery leftJoinSubject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Subject relation
 * @method     ChildSmsCallLogQuery rightJoinSubject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Subject relation
 * @method     ChildSmsCallLogQuery innerJoinSubject($relationAlias = null) Adds a INNER JOIN clause to the query using the Subject relation
 *
 * @method     ChildSmsCallLogQuery leftJoinStudent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Student relation
 * @method     ChildSmsCallLogQuery rightJoinStudent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Student relation
 * @method     ChildSmsCallLogQuery innerJoinStudent($relationAlias = null) Adds a INNER JOIN clause to the query using the Student relation
 *
 * @method     \App\Models\ApplicationRequestQuery|\App\Models\PeriodQuery|\App\Models\SubjectQuery|\App\Models\StudentQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSmsCallLog findOne(ConnectionInterface $con = null) Return the first ChildSmsCallLog matching the query
 * @method     ChildSmsCallLog findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSmsCallLog matching the query, or a new ChildSmsCallLog object populated from the query conditions when no match is found
 *
 * @method     ChildSmsCallLog findOneById(int $id) Return the first ChildSmsCallLog filtered by the id column
 * @method     ChildSmsCallLog findOneByStudentId(int $student_id) Return the first ChildSmsCallLog filtered by the student_id column
 * @method     ChildSmsCallLog findOneBySubjectId(int $subject_id) Return the first ChildSmsCallLog filtered by the subject_id column
 * @method     ChildSmsCallLog findOneByPeriodId(int $period_id) Return the first ChildSmsCallLog filtered by the period_id column
 * @method     ChildSmsCallLog findOneByApplicationDate(string $application_date) Return the first ChildSmsCallLog filtered by the application_date column
 * @method     ChildSmsCallLog findOneByIsSuccess(int $is_success) Return the first ChildSmsCallLog filtered by the is_success column
 * @method     ChildSmsCallLog findOneByApplicationRequestId(int $application_request_id) Return the first ChildSmsCallLog filtered by the application_request_id column
 * @method     ChildSmsCallLog findOneByCreatedAt(string $created_at) Return the first ChildSmsCallLog filtered by the created_at column
 * @method     ChildSmsCallLog findOneByUpdatedAt(string $updated_at) Return the first ChildSmsCallLog filtered by the updated_at column *

 * @method     ChildSmsCallLog requirePk($key, ConnectionInterface $con = null) Return the ChildSmsCallLog by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSmsCallLog requireOne(ConnectionInterface $con = null) Return the first ChildSmsCallLog matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSmsCallLog requireOneById(int $id) Return the first ChildSmsCallLog filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSmsCallLog requireOneByStudentId(int $student_id) Return the first ChildSmsCallLog filtered by the student_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSmsCallLog requireOneBySubjectId(int $subject_id) Return the first ChildSmsCallLog filtered by the subject_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSmsCallLog requireOneByPeriodId(int $period_id) Return the first ChildSmsCallLog filtered by the period_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSmsCallLog requireOneByApplicationDate(string $application_date) Return the first ChildSmsCallLog filtered by the application_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSmsCallLog requireOneByIsSuccess(int $is_success) Return the first ChildSmsCallLog filtered by the is_success column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSmsCallLog requireOneByApplicationRequestId(int $application_request_id) Return the first ChildSmsCallLog filtered by the application_request_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSmsCallLog requireOneByCreatedAt(string $created_at) Return the first ChildSmsCallLog filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSmsCallLog requireOneByUpdatedAt(string $updated_at) Return the first ChildSmsCallLog filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSmsCallLog[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSmsCallLog objects based on current ModelCriteria
 * @method     ChildSmsCallLog[]|ObjectCollection findById(int $id) Return ChildSmsCallLog objects filtered by the id column
 * @method     ChildSmsCallLog[]|ObjectCollection findByStudentId(int $student_id) Return ChildSmsCallLog objects filtered by the student_id column
 * @method     ChildSmsCallLog[]|ObjectCollection findBySubjectId(int $subject_id) Return ChildSmsCallLog objects filtered by the subject_id column
 * @method     ChildSmsCallLog[]|ObjectCollection findByPeriodId(int $period_id) Return ChildSmsCallLog objects filtered by the period_id column
 * @method     ChildSmsCallLog[]|ObjectCollection findByApplicationDate(string $application_date) Return ChildSmsCallLog objects filtered by the application_date column
 * @method     ChildSmsCallLog[]|ObjectCollection findByIsSuccess(int $is_success) Return ChildSmsCallLog objects filtered by the is_success column
 * @method     ChildSmsCallLog[]|ObjectCollection findByApplicationRequestId(int $application_request_id) Return ChildSmsCallLog objects filtered by the application_request_id column
 * @method     ChildSmsCallLog[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildSmsCallLog objects filtered by the created_at column
 * @method     ChildSmsCallLog[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildSmsCallLog objects filtered by the updated_at column
 * @method     ChildSmsCallLog[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SmsCallLogQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\SmsCallLogQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\SmsCallLog', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSmsCallLogQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSmsCallLogQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSmsCallLogQuery) {
            return $criteria;
        }
        $query = new ChildSmsCallLogQuery();
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSmsCallLog|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SmsCallLogTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SmsCallLogTableMap::DATABASE_NAME);
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
     * @return ChildSmsCallLog A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, student_id, subject_id, period_id, application_date, is_success, application_request_id, created_at, updated_at FROM sms_call_log WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildSmsCallLog $obj */
            $obj = new ChildSmsCallLog();
            $obj->hydrate($row);
            SmsCallLogTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildSmsCallLog|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
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
     * @return $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SmsCallLogTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SmsCallLogTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SmsCallLogTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the student_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStudentId(1234); // WHERE student_id = 1234
     * $query->filterByStudentId(array(12, 34)); // WHERE student_id IN (12, 34)
     * $query->filterByStudentId(array('min' => 12)); // WHERE student_id > 12
     * </code>
     *
     * @see       filterByStudent()
     *
     * @param     mixed $studentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function filterByStudentId($studentId = null, $comparison = null)
    {
        if (is_array($studentId)) {
            $useMinMax = false;
            if (isset($studentId['min'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_STUDENT_ID, $studentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studentId['max'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_STUDENT_ID, $studentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SmsCallLogTableMap::COL_STUDENT_ID, $studentId, $comparison);
    }

    /**
     * Filter the query on the subject_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySubjectId(1234); // WHERE subject_id = 1234
     * $query->filterBySubjectId(array(12, 34)); // WHERE subject_id IN (12, 34)
     * $query->filterBySubjectId(array('min' => 12)); // WHERE subject_id > 12
     * </code>
     *
     * @see       filterBySubject()
     *
     * @param     mixed $subjectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function filterBySubjectId($subjectId = null, $comparison = null)
    {
        if (is_array($subjectId)) {
            $useMinMax = false;
            if (isset($subjectId['min'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_SUBJECT_ID, $subjectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subjectId['max'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_SUBJECT_ID, $subjectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SmsCallLogTableMap::COL_SUBJECT_ID, $subjectId, $comparison);
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
     * @return $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function filterByPeriodId($periodId = null, $comparison = null)
    {
        if (is_array($periodId)) {
            $useMinMax = false;
            if (isset($periodId['min'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_PERIOD_ID, $periodId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($periodId['max'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_PERIOD_ID, $periodId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SmsCallLogTableMap::COL_PERIOD_ID, $periodId, $comparison);
    }

    /**
     * Filter the query on the application_date column
     *
     * Example usage:
     * <code>
     * $query->filterByApplicationDate('2011-03-14'); // WHERE application_date = '2011-03-14'
     * $query->filterByApplicationDate('now'); // WHERE application_date = '2011-03-14'
     * $query->filterByApplicationDate(array('max' => 'yesterday')); // WHERE application_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $applicationDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function filterByApplicationDate($applicationDate = null, $comparison = null)
    {
        if (is_array($applicationDate)) {
            $useMinMax = false;
            if (isset($applicationDate['min'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_APPLICATION_DATE, $applicationDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($applicationDate['max'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_APPLICATION_DATE, $applicationDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SmsCallLogTableMap::COL_APPLICATION_DATE, $applicationDate, $comparison);
    }

    /**
     * Filter the query on the is_success column
     *
     * Example usage:
     * <code>
     * $query->filterByIsSuccess(1234); // WHERE is_success = 1234
     * $query->filterByIsSuccess(array(12, 34)); // WHERE is_success IN (12, 34)
     * $query->filterByIsSuccess(array('min' => 12)); // WHERE is_success > 12
     * </code>
     *
     * @param     mixed $isSuccess The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function filterByIsSuccess($isSuccess = null, $comparison = null)
    {
        if (is_array($isSuccess)) {
            $useMinMax = false;
            if (isset($isSuccess['min'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_IS_SUCCESS, $isSuccess['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isSuccess['max'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_IS_SUCCESS, $isSuccess['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SmsCallLogTableMap::COL_IS_SUCCESS, $isSuccess, $comparison);
    }

    /**
     * Filter the query on the application_request_id column
     *
     * Example usage:
     * <code>
     * $query->filterByApplicationRequestId(1234); // WHERE application_request_id = 1234
     * $query->filterByApplicationRequestId(array(12, 34)); // WHERE application_request_id IN (12, 34)
     * $query->filterByApplicationRequestId(array('min' => 12)); // WHERE application_request_id > 12
     * </code>
     *
     * @see       filterByApplicationRequest()
     *
     * @param     mixed $applicationRequestId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function filterByApplicationRequestId($applicationRequestId = null, $comparison = null)
    {
        if (is_array($applicationRequestId)) {
            $useMinMax = false;
            if (isset($applicationRequestId['min'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_APPLICATION_REQUEST_ID, $applicationRequestId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($applicationRequestId['max'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_APPLICATION_REQUEST_ID, $applicationRequestId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SmsCallLogTableMap::COL_APPLICATION_REQUEST_ID, $applicationRequestId, $comparison);
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
     * @return $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SmsCallLogTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(SmsCallLogTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SmsCallLogTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\ApplicationRequest object
     *
     * @param \App\Models\ApplicationRequest|ObjectCollection $applicationRequest The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function filterByApplicationRequest($applicationRequest, $comparison = null)
    {
        if ($applicationRequest instanceof \App\Models\ApplicationRequest) {
            return $this
                ->addUsingAlias(SmsCallLogTableMap::COL_APPLICATION_REQUEST_ID, $applicationRequest->getId(), $comparison);
        } elseif ($applicationRequest instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SmsCallLogTableMap::COL_APPLICATION_REQUEST_ID, $applicationRequest->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByApplicationRequest() only accepts arguments of type \App\Models\ApplicationRequest or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ApplicationRequest relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function joinApplicationRequest($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ApplicationRequest');

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
            $this->addJoinObject($join, 'ApplicationRequest');
        }

        return $this;
    }

    /**
     * Use the ApplicationRequest relation ApplicationRequest object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\ApplicationRequestQuery A secondary query class using the current class as primary query
     */
    public function useApplicationRequestQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinApplicationRequest($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ApplicationRequest', '\App\Models\ApplicationRequestQuery');
    }

    /**
     * Filter the query by a related \App\Models\Period object
     *
     * @param \App\Models\Period|ObjectCollection $period The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function filterByPeriod($period, $comparison = null)
    {
        if ($period instanceof \App\Models\Period) {
            return $this
                ->addUsingAlias(SmsCallLogTableMap::COL_PERIOD_ID, $period->getId(), $comparison);
        } elseif ($period instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SmsCallLogTableMap::COL_PERIOD_ID, $period->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildSmsCallLogQuery The current query, for fluid interface
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
     * Filter the query by a related \App\Models\Subject object
     *
     * @param \App\Models\Subject|ObjectCollection $subject The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function filterBySubject($subject, $comparison = null)
    {
        if ($subject instanceof \App\Models\Subject) {
            return $this
                ->addUsingAlias(SmsCallLogTableMap::COL_SUBJECT_ID, $subject->getId(), $comparison);
        } elseif ($subject instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SmsCallLogTableMap::COL_SUBJECT_ID, $subject->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySubject() only accepts arguments of type \App\Models\Subject or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Subject relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function joinSubject($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Subject');

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
            $this->addJoinObject($join, 'Subject');
        }

        return $this;
    }

    /**
     * Use the Subject relation Subject object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\SubjectQuery A secondary query class using the current class as primary query
     */
    public function useSubjectQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSubject($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Subject', '\App\Models\SubjectQuery');
    }

    /**
     * Filter the query by a related \App\Models\Student object
     *
     * @param \App\Models\Student|ObjectCollection $student The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function filterByStudent($student, $comparison = null)
    {
        if ($student instanceof \App\Models\Student) {
            return $this
                ->addUsingAlias(SmsCallLogTableMap::COL_STUDENT_ID, $student->getId(), $comparison);
        } elseif ($student instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SmsCallLogTableMap::COL_STUDENT_ID, $student->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByStudent() only accepts arguments of type \App\Models\Student or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Student relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function joinStudent($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Student');

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
            $this->addJoinObject($join, 'Student');
        }

        return $this;
    }

    /**
     * Use the Student relation Student object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\StudentQuery A secondary query class using the current class as primary query
     */
    public function useStudentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStudent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Student', '\App\Models\StudentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSmsCallLog $smsCallLog Object to remove from the list of results
     *
     * @return $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function prune($smsCallLog = null)
    {
        if ($smsCallLog) {
            $this->addUsingAlias(SmsCallLogTableMap::COL_ID, $smsCallLog->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the sms_call_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SmsCallLogTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SmsCallLogTableMap::clearInstancePool();
            SmsCallLogTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SmsCallLogTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SmsCallLogTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SmsCallLogTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SmsCallLogTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(SmsCallLogTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(SmsCallLogTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(SmsCallLogTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(SmsCallLogTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(SmsCallLogTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildSmsCallLogQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(SmsCallLogTableMap::COL_CREATED_AT);
    }

} // SmsCallLogQuery
