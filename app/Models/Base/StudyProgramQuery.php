<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\StudyProgram as ChildStudyProgram;
use App\Models\StudyProgramQuery as ChildStudyProgramQuery;
use App\Models\Map\StudyProgramTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'study_program' table.
 *
 *
 *
 * @method     ChildStudyProgramQuery orderBySubjectId($order = Criteria::ASC) Order by the subject_id column
 * @method     ChildStudyProgramQuery orderByCourseId($order = Criteria::ASC) Order by the course_id column
 * @method     ChildStudyProgramQuery orderByYear($order = Criteria::ASC) Order by the year column
 * @method     ChildStudyProgramQuery orderBySemester($order = Criteria::ASC) Order by the semester column
 * @method     ChildStudyProgramQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildStudyProgramQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildStudyProgramQuery groupBySubjectId() Group by the subject_id column
 * @method     ChildStudyProgramQuery groupByCourseId() Group by the course_id column
 * @method     ChildStudyProgramQuery groupByYear() Group by the year column
 * @method     ChildStudyProgramQuery groupBySemester() Group by the semester column
 * @method     ChildStudyProgramQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildStudyProgramQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildStudyProgramQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStudyProgramQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStudyProgramQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStudyProgramQuery leftJoinCourse($relationAlias = null) Adds a LEFT JOIN clause to the query using the Course relation
 * @method     ChildStudyProgramQuery rightJoinCourse($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Course relation
 * @method     ChildStudyProgramQuery innerJoinCourse($relationAlias = null) Adds a INNER JOIN clause to the query using the Course relation
 *
 * @method     ChildStudyProgramQuery leftJoinSubject($relationAlias = null) Adds a LEFT JOIN clause to the query using the Subject relation
 * @method     ChildStudyProgramQuery rightJoinSubject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Subject relation
 * @method     ChildStudyProgramQuery innerJoinSubject($relationAlias = null) Adds a INNER JOIN clause to the query using the Subject relation
 *
 * @method     \App\Models\CourseQuery|\App\Models\SubjectQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildStudyProgram findOne(ConnectionInterface $con = null) Return the first ChildStudyProgram matching the query
 * @method     ChildStudyProgram findOneOrCreate(ConnectionInterface $con = null) Return the first ChildStudyProgram matching the query, or a new ChildStudyProgram object populated from the query conditions when no match is found
 *
 * @method     ChildStudyProgram findOneBySubjectId(int $subject_id) Return the first ChildStudyProgram filtered by the subject_id column
 * @method     ChildStudyProgram findOneByCourseId(int $course_id) Return the first ChildStudyProgram filtered by the course_id column
 * @method     ChildStudyProgram findOneByYear(int $year) Return the first ChildStudyProgram filtered by the year column
 * @method     ChildStudyProgram findOneBySemester(int $semester) Return the first ChildStudyProgram filtered by the semester column
 * @method     ChildStudyProgram findOneByCreatedAt(string $created_at) Return the first ChildStudyProgram filtered by the created_at column
 * @method     ChildStudyProgram findOneByUpdatedAt(string $updated_at) Return the first ChildStudyProgram filtered by the updated_at column *

 * @method     ChildStudyProgram requirePk($key, ConnectionInterface $con = null) Return the ChildStudyProgram by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudyProgram requireOne(ConnectionInterface $con = null) Return the first ChildStudyProgram matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStudyProgram requireOneBySubjectId(int $subject_id) Return the first ChildStudyProgram filtered by the subject_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudyProgram requireOneByCourseId(int $course_id) Return the first ChildStudyProgram filtered by the course_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudyProgram requireOneByYear(int $year) Return the first ChildStudyProgram filtered by the year column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudyProgram requireOneBySemester(int $semester) Return the first ChildStudyProgram filtered by the semester column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudyProgram requireOneByCreatedAt(string $created_at) Return the first ChildStudyProgram filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudyProgram requireOneByUpdatedAt(string $updated_at) Return the first ChildStudyProgram filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStudyProgram[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildStudyProgram objects based on current ModelCriteria
 * @method     ChildStudyProgram[]|ObjectCollection findBySubjectId(int $subject_id) Return ChildStudyProgram objects filtered by the subject_id column
 * @method     ChildStudyProgram[]|ObjectCollection findByCourseId(int $course_id) Return ChildStudyProgram objects filtered by the course_id column
 * @method     ChildStudyProgram[]|ObjectCollection findByYear(int $year) Return ChildStudyProgram objects filtered by the year column
 * @method     ChildStudyProgram[]|ObjectCollection findBySemester(int $semester) Return ChildStudyProgram objects filtered by the semester column
 * @method     ChildStudyProgram[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildStudyProgram objects filtered by the created_at column
 * @method     ChildStudyProgram[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildStudyProgram objects filtered by the updated_at column
 * @method     ChildStudyProgram[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class StudyProgramQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\StudyProgramQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\StudyProgram', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStudyProgramQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStudyProgramQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildStudyProgramQuery) {
            return $criteria;
        }
        $query = new ChildStudyProgramQuery();
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
     * @param array[$subject_id, $course_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildStudyProgram|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StudyProgramTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StudyProgramTableMap::DATABASE_NAME);
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
     * @return ChildStudyProgram A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT subject_id, course_id, year, semester, created_at, updated_at FROM study_program WHERE subject_id = :p0 AND course_id = :p1';
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
            /** @var ChildStudyProgram $obj */
            $obj = new ChildStudyProgram();
            $obj->hydrate($row);
            StudyProgramTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildStudyProgram|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildStudyProgramQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(StudyProgramTableMap::COL_SUBJECT_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(StudyProgramTableMap::COL_COURSE_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildStudyProgramQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(StudyProgramTableMap::COL_SUBJECT_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(StudyProgramTableMap::COL_COURSE_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildStudyProgramQuery The current query, for fluid interface
     */
    public function filterBySubjectId($subjectId = null, $comparison = null)
    {
        if (is_array($subjectId)) {
            $useMinMax = false;
            if (isset($subjectId['min'])) {
                $this->addUsingAlias(StudyProgramTableMap::COL_SUBJECT_ID, $subjectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subjectId['max'])) {
                $this->addUsingAlias(StudyProgramTableMap::COL_SUBJECT_ID, $subjectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyProgramTableMap::COL_SUBJECT_ID, $subjectId, $comparison);
    }

    /**
     * Filter the query on the course_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCourseId(1234); // WHERE course_id = 1234
     * $query->filterByCourseId(array(12, 34)); // WHERE course_id IN (12, 34)
     * $query->filterByCourseId(array('min' => 12)); // WHERE course_id > 12
     * </code>
     *
     * @see       filterByCourse()
     *
     * @param     mixed $courseId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStudyProgramQuery The current query, for fluid interface
     */
    public function filterByCourseId($courseId = null, $comparison = null)
    {
        if (is_array($courseId)) {
            $useMinMax = false;
            if (isset($courseId['min'])) {
                $this->addUsingAlias(StudyProgramTableMap::COL_COURSE_ID, $courseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($courseId['max'])) {
                $this->addUsingAlias(StudyProgramTableMap::COL_COURSE_ID, $courseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyProgramTableMap::COL_COURSE_ID, $courseId, $comparison);
    }

    /**
     * Filter the query on the year column
     *
     * Example usage:
     * <code>
     * $query->filterByYear(1234); // WHERE year = 1234
     * $query->filterByYear(array(12, 34)); // WHERE year IN (12, 34)
     * $query->filterByYear(array('min' => 12)); // WHERE year > 12
     * </code>
     *
     * @param     mixed $year The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStudyProgramQuery The current query, for fluid interface
     */
    public function filterByYear($year = null, $comparison = null)
    {
        if (is_array($year)) {
            $useMinMax = false;
            if (isset($year['min'])) {
                $this->addUsingAlias(StudyProgramTableMap::COL_YEAR, $year['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($year['max'])) {
                $this->addUsingAlias(StudyProgramTableMap::COL_YEAR, $year['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyProgramTableMap::COL_YEAR, $year, $comparison);
    }

    /**
     * Filter the query on the semester column
     *
     * Example usage:
     * <code>
     * $query->filterBySemester(1234); // WHERE semester = 1234
     * $query->filterBySemester(array(12, 34)); // WHERE semester IN (12, 34)
     * $query->filterBySemester(array('min' => 12)); // WHERE semester > 12
     * </code>
     *
     * @param     mixed $semester The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStudyProgramQuery The current query, for fluid interface
     */
    public function filterBySemester($semester = null, $comparison = null)
    {
        if (is_array($semester)) {
            $useMinMax = false;
            if (isset($semester['min'])) {
                $this->addUsingAlias(StudyProgramTableMap::COL_SEMESTER, $semester['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($semester['max'])) {
                $this->addUsingAlias(StudyProgramTableMap::COL_SEMESTER, $semester['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyProgramTableMap::COL_SEMESTER, $semester, $comparison);
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
     * @return $this|ChildStudyProgramQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(StudyProgramTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(StudyProgramTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyProgramTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildStudyProgramQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(StudyProgramTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(StudyProgramTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyProgramTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\Course object
     *
     * @param \App\Models\Course|ObjectCollection $course The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildStudyProgramQuery The current query, for fluid interface
     */
    public function filterByCourse($course, $comparison = null)
    {
        if ($course instanceof \App\Models\Course) {
            return $this
                ->addUsingAlias(StudyProgramTableMap::COL_COURSE_ID, $course->getId(), $comparison);
        } elseif ($course instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudyProgramTableMap::COL_COURSE_ID, $course->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCourse() only accepts arguments of type \App\Models\Course or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Course relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStudyProgramQuery The current query, for fluid interface
     */
    public function joinCourse($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Course');

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
            $this->addJoinObject($join, 'Course');
        }

        return $this;
    }

    /**
     * Use the Course relation Course object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\CourseQuery A secondary query class using the current class as primary query
     */
    public function useCourseQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCourse($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Course', '\App\Models\CourseQuery');
    }

    /**
     * Filter the query by a related \App\Models\Subject object
     *
     * @param \App\Models\Subject|ObjectCollection $subject The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildStudyProgramQuery The current query, for fluid interface
     */
    public function filterBySubject($subject, $comparison = null)
    {
        if ($subject instanceof \App\Models\Subject) {
            return $this
                ->addUsingAlias(StudyProgramTableMap::COL_SUBJECT_ID, $subject->getId(), $comparison);
        } elseif ($subject instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudyProgramTableMap::COL_SUBJECT_ID, $subject->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildStudyProgramQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildStudyProgram $studyProgram Object to remove from the list of results
     *
     * @return $this|ChildStudyProgramQuery The current query, for fluid interface
     */
    public function prune($studyProgram = null)
    {
        if ($studyProgram) {
            $this->addCond('pruneCond0', $this->getAliasedColName(StudyProgramTableMap::COL_SUBJECT_ID), $studyProgram->getSubjectId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(StudyProgramTableMap::COL_COURSE_ID), $studyProgram->getCourseId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the study_program table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StudyProgramTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            StudyProgramTableMap::clearInstancePool();
            StudyProgramTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(StudyProgramTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StudyProgramTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            StudyProgramTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StudyProgramTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildStudyProgramQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(StudyProgramTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildStudyProgramQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(StudyProgramTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildStudyProgramQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(StudyProgramTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildStudyProgramQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(StudyProgramTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildStudyProgramQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(StudyProgramTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildStudyProgramQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(StudyProgramTableMap::COL_CREATED_AT);
    }

} // StudyProgramQuery
