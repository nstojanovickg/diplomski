<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\Application as ChildApplication;
use App\Models\ApplicationQuery as ChildApplicationQuery;
use App\Models\Map\ApplicationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'application' table.
 *
 *
 *
 * @method     ChildApplicationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildApplicationQuery orderByStudentId($order = Criteria::ASC) Order by the student_id column
 * @method     ChildApplicationQuery orderBySubjectId($order = Criteria::ASC) Order by the subject_id column
 * @method     ChildApplicationQuery orderByPeriodId($order = Criteria::ASC) Order by the period_id column
 * @method     ChildApplicationQuery orderBySchoolYearId($order = Criteria::ASC) Order by the school_year_id column
 * @method     ChildApplicationQuery orderByOralExamInvitationId($order = Criteria::ASC) Order by the oral_exam_invitation_id column
 * @method     ChildApplicationQuery orderByApplicationDate($order = Criteria::ASC) Order by the application_date column
 * @method     ChildApplicationQuery orderByExamDate($order = Criteria::ASC) Order by the exam_date column
 * @method     ChildApplicationQuery orderByExamTime($order = Criteria::ASC) Order by the exam_time column
 * @method     ChildApplicationQuery orderByExamScore($order = Criteria::ASC) Order by the exam_score column
 * @method     ChildApplicationQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildApplicationQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildApplicationQuery groupById() Group by the id column
 * @method     ChildApplicationQuery groupByStudentId() Group by the student_id column
 * @method     ChildApplicationQuery groupBySubjectId() Group by the subject_id column
 * @method     ChildApplicationQuery groupByPeriodId() Group by the period_id column
 * @method     ChildApplicationQuery groupBySchoolYearId() Group by the school_year_id column
 * @method     ChildApplicationQuery groupByOralExamInvitationId() Group by the oral_exam_invitation_id column
 * @method     ChildApplicationQuery groupByApplicationDate() Group by the application_date column
 * @method     ChildApplicationQuery groupByExamDate() Group by the exam_date column
 * @method     ChildApplicationQuery groupByExamTime() Group by the exam_time column
 * @method     ChildApplicationQuery groupByExamScore() Group by the exam_score column
 * @method     ChildApplicationQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildApplicationQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildApplicationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildApplicationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildApplicationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildApplicationQuery leftJoinOralExamInvitation($relationAlias = null) Adds a LEFT JOIN clause to the query using the OralExamInvitation relation
 * @method     ChildApplicationQuery rightJoinOralExamInvitation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OralExamInvitation relation
 * @method     ChildApplicationQuery innerJoinOralExamInvitation($relationAlias = null) Adds a INNER JOIN clause to the query using the OralExamInvitation relation
 *
 * @method     ChildApplicationQuery leftJoinPeriod($relationAlias = null) Adds a LEFT JOIN clause to the query using the Period relation
 * @method     ChildApplicationQuery rightJoinPeriod($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Period relation
 * @method     ChildApplicationQuery innerJoinPeriod($relationAlias = null) Adds a INNER JOIN clause to the query using the Period relation
 *
 * @method     ChildApplicationQuery leftJoinSubject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Subject relation
 * @method     ChildApplicationQuery rightJoinSubject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Subject relation
 * @method     ChildApplicationQuery innerJoinSubject($relationAlias = null) Adds a INNER JOIN clause to the query using the Subject relation
 *
 * @method     ChildApplicationQuery leftJoinStudent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Student relation
 * @method     ChildApplicationQuery rightJoinStudent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Student relation
 * @method     ChildApplicationQuery innerJoinStudent($relationAlias = null) Adds a INNER JOIN clause to the query using the Student relation
 *
 * @method     ChildApplicationQuery leftJoinSchoolYear($relationAlias = null) Adds a LEFT JOIN clause to the query using the SchoolYear relation
 * @method     ChildApplicationQuery rightJoinSchoolYear($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SchoolYear relation
 * @method     ChildApplicationQuery innerJoinSchoolYear($relationAlias = null) Adds a INNER JOIN clause to the query using the SchoolYear relation
 *
 * @method     \App\Models\OralExamInvitationQuery|\App\Models\PeriodQuery|\App\Models\SubjectQuery|\App\Models\StudentQuery|\App\Models\SchoolYearQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildApplication findOne(ConnectionInterface $con = null) Return the first ChildApplication matching the query
 * @method     ChildApplication findOneOrCreate(ConnectionInterface $con = null) Return the first ChildApplication matching the query, or a new ChildApplication object populated from the query conditions when no match is found
 *
 * @method     ChildApplication findOneById(int $id) Return the first ChildApplication filtered by the id column
 * @method     ChildApplication findOneByStudentId(int $student_id) Return the first ChildApplication filtered by the student_id column
 * @method     ChildApplication findOneBySubjectId(int $subject_id) Return the first ChildApplication filtered by the subject_id column
 * @method     ChildApplication findOneByPeriodId(int $period_id) Return the first ChildApplication filtered by the period_id column
 * @method     ChildApplication findOneBySchoolYearId(int $school_year_id) Return the first ChildApplication filtered by the school_year_id column
 * @method     ChildApplication findOneByOralExamInvitationId(int $oral_exam_invitation_id) Return the first ChildApplication filtered by the oral_exam_invitation_id column
 * @method     ChildApplication findOneByApplicationDate(string $application_date) Return the first ChildApplication filtered by the application_date column
 * @method     ChildApplication findOneByExamDate(string $exam_date) Return the first ChildApplication filtered by the exam_date column
 * @method     ChildApplication findOneByExamTime(string $exam_time) Return the first ChildApplication filtered by the exam_time column
 * @method     ChildApplication findOneByExamScore(int $exam_score) Return the first ChildApplication filtered by the exam_score column
 * @method     ChildApplication findOneByCreatedAt(string $created_at) Return the first ChildApplication filtered by the created_at column
 * @method     ChildApplication findOneByUpdatedAt(string $updated_at) Return the first ChildApplication filtered by the updated_at column *

 * @method     ChildApplication requirePk($key, ConnectionInterface $con = null) Return the ChildApplication by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApplication requireOne(ConnectionInterface $con = null) Return the first ChildApplication matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildApplication requireOneById(int $id) Return the first ChildApplication filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApplication requireOneByStudentId(int $student_id) Return the first ChildApplication filtered by the student_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApplication requireOneBySubjectId(int $subject_id) Return the first ChildApplication filtered by the subject_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApplication requireOneByPeriodId(int $period_id) Return the first ChildApplication filtered by the period_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApplication requireOneBySchoolYearId(int $school_year_id) Return the first ChildApplication filtered by the school_year_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApplication requireOneByOralExamInvitationId(int $oral_exam_invitation_id) Return the first ChildApplication filtered by the oral_exam_invitation_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApplication requireOneByApplicationDate(string $application_date) Return the first ChildApplication filtered by the application_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApplication requireOneByExamDate(string $exam_date) Return the first ChildApplication filtered by the exam_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApplication requireOneByExamTime(string $exam_time) Return the first ChildApplication filtered by the exam_time column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApplication requireOneByExamScore(int $exam_score) Return the first ChildApplication filtered by the exam_score column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApplication requireOneByCreatedAt(string $created_at) Return the first ChildApplication filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildApplication requireOneByUpdatedAt(string $updated_at) Return the first ChildApplication filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildApplication[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildApplication objects based on current ModelCriteria
 * @method     ChildApplication[]|ObjectCollection findById(int $id) Return ChildApplication objects filtered by the id column
 * @method     ChildApplication[]|ObjectCollection findByStudentId(int $student_id) Return ChildApplication objects filtered by the student_id column
 * @method     ChildApplication[]|ObjectCollection findBySubjectId(int $subject_id) Return ChildApplication objects filtered by the subject_id column
 * @method     ChildApplication[]|ObjectCollection findByPeriodId(int $period_id) Return ChildApplication objects filtered by the period_id column
 * @method     ChildApplication[]|ObjectCollection findBySchoolYearId(int $school_year_id) Return ChildApplication objects filtered by the school_year_id column
 * @method     ChildApplication[]|ObjectCollection findByOralExamInvitationId(int $oral_exam_invitation_id) Return ChildApplication objects filtered by the oral_exam_invitation_id column
 * @method     ChildApplication[]|ObjectCollection findByApplicationDate(string $application_date) Return ChildApplication objects filtered by the application_date column
 * @method     ChildApplication[]|ObjectCollection findByExamDate(string $exam_date) Return ChildApplication objects filtered by the exam_date column
 * @method     ChildApplication[]|ObjectCollection findByExamTime(string $exam_time) Return ChildApplication objects filtered by the exam_time column
 * @method     ChildApplication[]|ObjectCollection findByExamScore(int $exam_score) Return ChildApplication objects filtered by the exam_score column
 * @method     ChildApplication[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildApplication objects filtered by the created_at column
 * @method     ChildApplication[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildApplication objects filtered by the updated_at column
 * @method     ChildApplication[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ApplicationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\ApplicationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\Application', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildApplicationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildApplicationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildApplicationQuery) {
            return $criteria;
        }
        $query = new ChildApplicationQuery();
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
     * @return ChildApplication|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ApplicationTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ApplicationTableMap::DATABASE_NAME);
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
     * @return ChildApplication A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, student_id, subject_id, period_id, school_year_id, oral_exam_invitation_id, application_date, exam_date, exam_time, exam_score, created_at, updated_at FROM application WHERE id = :p0';
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
            /** @var ChildApplication $obj */
            $obj = new ChildApplication();
            $obj->hydrate($row);
            ApplicationTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildApplication|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ApplicationTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ApplicationTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApplicationTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function filterByStudentId($studentId = null, $comparison = null)
    {
        if (is_array($studentId)) {
            $useMinMax = false;
            if (isset($studentId['min'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_STUDENT_ID, $studentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studentId['max'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_STUDENT_ID, $studentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApplicationTableMap::COL_STUDENT_ID, $studentId, $comparison);
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
     * @return $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function filterBySubjectId($subjectId = null, $comparison = null)
    {
        if (is_array($subjectId)) {
            $useMinMax = false;
            if (isset($subjectId['min'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_SUBJECT_ID, $subjectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subjectId['max'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_SUBJECT_ID, $subjectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApplicationTableMap::COL_SUBJECT_ID, $subjectId, $comparison);
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
     * @return $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function filterByPeriodId($periodId = null, $comparison = null)
    {
        if (is_array($periodId)) {
            $useMinMax = false;
            if (isset($periodId['min'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_PERIOD_ID, $periodId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($periodId['max'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_PERIOD_ID, $periodId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApplicationTableMap::COL_PERIOD_ID, $periodId, $comparison);
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
     * @return $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function filterBySchoolYearId($schoolYearId = null, $comparison = null)
    {
        if (is_array($schoolYearId)) {
            $useMinMax = false;
            if (isset($schoolYearId['min'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_SCHOOL_YEAR_ID, $schoolYearId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($schoolYearId['max'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_SCHOOL_YEAR_ID, $schoolYearId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApplicationTableMap::COL_SCHOOL_YEAR_ID, $schoolYearId, $comparison);
    }

    /**
     * Filter the query on the oral_exam_invitation_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOralExamInvitationId(1234); // WHERE oral_exam_invitation_id = 1234
     * $query->filterByOralExamInvitationId(array(12, 34)); // WHERE oral_exam_invitation_id IN (12, 34)
     * $query->filterByOralExamInvitationId(array('min' => 12)); // WHERE oral_exam_invitation_id > 12
     * </code>
     *
     * @see       filterByOralExamInvitation()
     *
     * @param     mixed $oralExamInvitationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function filterByOralExamInvitationId($oralExamInvitationId = null, $comparison = null)
    {
        if (is_array($oralExamInvitationId)) {
            $useMinMax = false;
            if (isset($oralExamInvitationId['min'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_ORAL_EXAM_INVITATION_ID, $oralExamInvitationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($oralExamInvitationId['max'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_ORAL_EXAM_INVITATION_ID, $oralExamInvitationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApplicationTableMap::COL_ORAL_EXAM_INVITATION_ID, $oralExamInvitationId, $comparison);
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
     * @return $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function filterByApplicationDate($applicationDate = null, $comparison = null)
    {
        if (is_array($applicationDate)) {
            $useMinMax = false;
            if (isset($applicationDate['min'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_APPLICATION_DATE, $applicationDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($applicationDate['max'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_APPLICATION_DATE, $applicationDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApplicationTableMap::COL_APPLICATION_DATE, $applicationDate, $comparison);
    }

    /**
     * Filter the query on the exam_date column
     *
     * Example usage:
     * <code>
     * $query->filterByExamDate('2011-03-14'); // WHERE exam_date = '2011-03-14'
     * $query->filterByExamDate('now'); // WHERE exam_date = '2011-03-14'
     * $query->filterByExamDate(array('max' => 'yesterday')); // WHERE exam_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $examDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function filterByExamDate($examDate = null, $comparison = null)
    {
        if (is_array($examDate)) {
            $useMinMax = false;
            if (isset($examDate['min'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_EXAM_DATE, $examDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($examDate['max'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_EXAM_DATE, $examDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApplicationTableMap::COL_EXAM_DATE, $examDate, $comparison);
    }

    /**
     * Filter the query on the exam_time column
     *
     * Example usage:
     * <code>
     * $query->filterByExamTime('2011-03-14'); // WHERE exam_time = '2011-03-14'
     * $query->filterByExamTime('now'); // WHERE exam_time = '2011-03-14'
     * $query->filterByExamTime(array('max' => 'yesterday')); // WHERE exam_time > '2011-03-13'
     * </code>
     *
     * @param     mixed $examTime The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function filterByExamTime($examTime = null, $comparison = null)
    {
        if (is_array($examTime)) {
            $useMinMax = false;
            if (isset($examTime['min'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_EXAM_TIME, $examTime['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($examTime['max'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_EXAM_TIME, $examTime['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApplicationTableMap::COL_EXAM_TIME, $examTime, $comparison);
    }

    /**
     * Filter the query on the exam_score column
     *
     * Example usage:
     * <code>
     * $query->filterByExamScore(1234); // WHERE exam_score = 1234
     * $query->filterByExamScore(array(12, 34)); // WHERE exam_score IN (12, 34)
     * $query->filterByExamScore(array('min' => 12)); // WHERE exam_score > 12
     * </code>
     *
     * @param     mixed $examScore The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function filterByExamScore($examScore = null, $comparison = null)
    {
        if (is_array($examScore)) {
            $useMinMax = false;
            if (isset($examScore['min'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_EXAM_SCORE, $examScore['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($examScore['max'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_EXAM_SCORE, $examScore['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApplicationTableMap::COL_EXAM_SCORE, $examScore, $comparison);
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
     * @return $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApplicationTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ApplicationTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ApplicationTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\OralExamInvitation object
     *
     * @param \App\Models\OralExamInvitation|ObjectCollection $oralExamInvitation The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildApplicationQuery The current query, for fluid interface
     */
    public function filterByOralExamInvitation($oralExamInvitation, $comparison = null)
    {
        if ($oralExamInvitation instanceof \App\Models\OralExamInvitation) {
            return $this
                ->addUsingAlias(ApplicationTableMap::COL_ORAL_EXAM_INVITATION_ID, $oralExamInvitation->getId(), $comparison);
        } elseif ($oralExamInvitation instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ApplicationTableMap::COL_ORAL_EXAM_INVITATION_ID, $oralExamInvitation->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByOralExamInvitation() only accepts arguments of type \App\Models\OralExamInvitation or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OralExamInvitation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function joinOralExamInvitation($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OralExamInvitation');

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
            $this->addJoinObject($join, 'OralExamInvitation');
        }

        return $this;
    }

    /**
     * Use the OralExamInvitation relation OralExamInvitation object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\OralExamInvitationQuery A secondary query class using the current class as primary query
     */
    public function useOralExamInvitationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinOralExamInvitation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OralExamInvitation', '\App\Models\OralExamInvitationQuery');
    }

    /**
     * Filter the query by a related \App\Models\Period object
     *
     * @param \App\Models\Period|ObjectCollection $period The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildApplicationQuery The current query, for fluid interface
     */
    public function filterByPeriod($period, $comparison = null)
    {
        if ($period instanceof \App\Models\Period) {
            return $this
                ->addUsingAlias(ApplicationTableMap::COL_PERIOD_ID, $period->getId(), $comparison);
        } elseif ($period instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ApplicationTableMap::COL_PERIOD_ID, $period->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildApplicationQuery The current query, for fluid interface
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
     * @return ChildApplicationQuery The current query, for fluid interface
     */
    public function filterBySubject($subject, $comparison = null)
    {
        if ($subject instanceof \App\Models\Subject) {
            return $this
                ->addUsingAlias(ApplicationTableMap::COL_SUBJECT_ID, $subject->getId(), $comparison);
        } elseif ($subject instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ApplicationTableMap::COL_SUBJECT_ID, $subject->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildApplicationQuery The current query, for fluid interface
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
     * @return ChildApplicationQuery The current query, for fluid interface
     */
    public function filterByStudent($student, $comparison = null)
    {
        if ($student instanceof \App\Models\Student) {
            return $this
                ->addUsingAlias(ApplicationTableMap::COL_STUDENT_ID, $student->getId(), $comparison);
        } elseif ($student instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ApplicationTableMap::COL_STUDENT_ID, $student->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildApplicationQuery The current query, for fluid interface
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
     * Filter the query by a related \App\Models\SchoolYear object
     *
     * @param \App\Models\SchoolYear|ObjectCollection $schoolYear The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildApplicationQuery The current query, for fluid interface
     */
    public function filterBySchoolYear($schoolYear, $comparison = null)
    {
        if ($schoolYear instanceof \App\Models\SchoolYear) {
            return $this
                ->addUsingAlias(ApplicationTableMap::COL_SCHOOL_YEAR_ID, $schoolYear->getId(), $comparison);
        } elseif ($schoolYear instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ApplicationTableMap::COL_SCHOOL_YEAR_ID, $schoolYear->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildApplicationQuery The current query, for fluid interface
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
     * @param   ChildApplication $application Object to remove from the list of results
     *
     * @return $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function prune($application = null)
    {
        if ($application) {
            $this->addUsingAlias(ApplicationTableMap::COL_ID, $application->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the application table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ApplicationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ApplicationTableMap::clearInstancePool();
            ApplicationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ApplicationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ApplicationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ApplicationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ApplicationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ApplicationTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ApplicationTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ApplicationTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ApplicationTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ApplicationTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildApplicationQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ApplicationTableMap::COL_CREATED_AT);
    }

} // ApplicationQuery
