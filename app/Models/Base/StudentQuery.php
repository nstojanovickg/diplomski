<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\Student as ChildStudent;
use App\Models\StudentQuery as ChildStudentQuery;
use App\Models\Map\StudentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'student' table.
 *
 *
 *
 * @method     ChildStudentQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildStudentQuery orderByIdentificationNumber($order = Criteria::ASC) Order by the identification_number column
 * @method     ChildStudentQuery orderBySchoolYearId($order = Criteria::ASC) Order by the school_year_id column
 * @method     ChildStudentQuery orderByCourseId($order = Criteria::ASC) Order by the course_id column
 * @method     ChildStudentQuery orderByFirstName($order = Criteria::ASC) Order by the first_name column
 * @method     ChildStudentQuery orderByLastName($order = Criteria::ASC) Order by the last_name column
 * @method     ChildStudentQuery orderByBirthPlace($order = Criteria::ASC) Order by the birth_place column
 * @method     ChildStudentQuery orderByBirthday($order = Criteria::ASC) Order by the birthday column
 * @method     ChildStudentQuery orderByPhoneNumber($order = Criteria::ASC) Order by the phone_number column
 * @method     ChildStudentQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildStudentQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildStudentQuery groupById() Group by the id column
 * @method     ChildStudentQuery groupByIdentificationNumber() Group by the identification_number column
 * @method     ChildStudentQuery groupBySchoolYearId() Group by the school_year_id column
 * @method     ChildStudentQuery groupByCourseId() Group by the course_id column
 * @method     ChildStudentQuery groupByFirstName() Group by the first_name column
 * @method     ChildStudentQuery groupByLastName() Group by the last_name column
 * @method     ChildStudentQuery groupByBirthPlace() Group by the birth_place column
 * @method     ChildStudentQuery groupByBirthday() Group by the birthday column
 * @method     ChildStudentQuery groupByPhoneNumber() Group by the phone_number column
 * @method     ChildStudentQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildStudentQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildStudentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStudentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStudentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStudentQuery leftJoinCourse($relationAlias = null) Adds a LEFT JOIN clause to the query using the Course relation
 * @method     ChildStudentQuery rightJoinCourse($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Course relation
 * @method     ChildStudentQuery innerJoinCourse($relationAlias = null) Adds a INNER JOIN clause to the query using the Course relation
 *
 * @method     ChildStudentQuery leftJoinSchoolYear($relationAlias = null) Adds a LEFT JOIN clause to the query using the SchoolYear relation
 * @method     ChildStudentQuery rightJoinSchoolYear($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SchoolYear relation
 * @method     ChildStudentQuery innerJoinSchoolYear($relationAlias = null) Adds a INNER JOIN clause to the query using the SchoolYear relation
 *
 * @method     ChildStudentQuery leftJoinAdminUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdminUser relation
 * @method     ChildStudentQuery rightJoinAdminUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdminUser relation
 * @method     ChildStudentQuery innerJoinAdminUser($relationAlias = null) Adds a INNER JOIN clause to the query using the AdminUser relation
 *
 * @method     ChildStudentQuery leftJoinApplication($relationAlias = null) Adds a LEFT JOIN clause to the query using the Application relation
 * @method     ChildStudentQuery rightJoinApplication($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Application relation
 * @method     ChildStudentQuery innerJoinApplication($relationAlias = null) Adds a INNER JOIN clause to the query using the Application relation
 *
 * @method     \App\Models\CourseQuery|\App\Models\SchoolYearQuery|\App\Models\AdminUserQuery|\App\Models\ApplicationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildStudent findOne(ConnectionInterface $con = null) Return the first ChildStudent matching the query
 * @method     ChildStudent findOneOrCreate(ConnectionInterface $con = null) Return the first ChildStudent matching the query, or a new ChildStudent object populated from the query conditions when no match is found
 *
 * @method     ChildStudent findOneById(int $id) Return the first ChildStudent filtered by the id column
 * @method     ChildStudent findOneByIdentificationNumber(int $identification_number) Return the first ChildStudent filtered by the identification_number column
 * @method     ChildStudent findOneBySchoolYearId(int $school_year_id) Return the first ChildStudent filtered by the school_year_id column
 * @method     ChildStudent findOneByCourseId(int $course_id) Return the first ChildStudent filtered by the course_id column
 * @method     ChildStudent findOneByFirstName(string $first_name) Return the first ChildStudent filtered by the first_name column
 * @method     ChildStudent findOneByLastName(string $last_name) Return the first ChildStudent filtered by the last_name column
 * @method     ChildStudent findOneByBirthPlace(string $birth_place) Return the first ChildStudent filtered by the birth_place column
 * @method     ChildStudent findOneByBirthday(string $birthday) Return the first ChildStudent filtered by the birthday column
 * @method     ChildStudent findOneByPhoneNumber(string $phone_number) Return the first ChildStudent filtered by the phone_number column
 * @method     ChildStudent findOneByCreatedAt(string $created_at) Return the first ChildStudent filtered by the created_at column
 * @method     ChildStudent findOneByUpdatedAt(string $updated_at) Return the first ChildStudent filtered by the updated_at column *

 * @method     ChildStudent requirePk($key, ConnectionInterface $con = null) Return the ChildStudent by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudent requireOne(ConnectionInterface $con = null) Return the first ChildStudent matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStudent requireOneById(int $id) Return the first ChildStudent filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudent requireOneByIdentificationNumber(int $identification_number) Return the first ChildStudent filtered by the identification_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudent requireOneBySchoolYearId(int $school_year_id) Return the first ChildStudent filtered by the school_year_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudent requireOneByCourseId(int $course_id) Return the first ChildStudent filtered by the course_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudent requireOneByFirstName(string $first_name) Return the first ChildStudent filtered by the first_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudent requireOneByLastName(string $last_name) Return the first ChildStudent filtered by the last_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudent requireOneByBirthPlace(string $birth_place) Return the first ChildStudent filtered by the birth_place column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudent requireOneByBirthday(string $birthday) Return the first ChildStudent filtered by the birthday column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudent requireOneByPhoneNumber(string $phone_number) Return the first ChildStudent filtered by the phone_number column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudent requireOneByCreatedAt(string $created_at) Return the first ChildStudent filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudent requireOneByUpdatedAt(string $updated_at) Return the first ChildStudent filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStudent[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildStudent objects based on current ModelCriteria
 * @method     ChildStudent[]|ObjectCollection findById(int $id) Return ChildStudent objects filtered by the id column
 * @method     ChildStudent[]|ObjectCollection findByIdentificationNumber(int $identification_number) Return ChildStudent objects filtered by the identification_number column
 * @method     ChildStudent[]|ObjectCollection findBySchoolYearId(int $school_year_id) Return ChildStudent objects filtered by the school_year_id column
 * @method     ChildStudent[]|ObjectCollection findByCourseId(int $course_id) Return ChildStudent objects filtered by the course_id column
 * @method     ChildStudent[]|ObjectCollection findByFirstName(string $first_name) Return ChildStudent objects filtered by the first_name column
 * @method     ChildStudent[]|ObjectCollection findByLastName(string $last_name) Return ChildStudent objects filtered by the last_name column
 * @method     ChildStudent[]|ObjectCollection findByBirthPlace(string $birth_place) Return ChildStudent objects filtered by the birth_place column
 * @method     ChildStudent[]|ObjectCollection findByBirthday(string $birthday) Return ChildStudent objects filtered by the birthday column
 * @method     ChildStudent[]|ObjectCollection findByPhoneNumber(string $phone_number) Return ChildStudent objects filtered by the phone_number column
 * @method     ChildStudent[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildStudent objects filtered by the created_at column
 * @method     ChildStudent[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildStudent objects filtered by the updated_at column
 * @method     ChildStudent[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class StudentQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\StudentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\Student', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStudentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStudentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildStudentQuery) {
            return $criteria;
        }
        $query = new ChildStudentQuery();
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
     * @return ChildStudent|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StudentTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StudentTableMap::DATABASE_NAME);
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
     * @return ChildStudent A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, identification_number, school_year_id, course_id, first_name, last_name, birth_place, birthday, phone_number, created_at, updated_at FROM student WHERE id = :p0';
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
            /** @var ChildStudent $obj */
            $obj = new ChildStudent();
            $obj->hydrate($row);
            StudentTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildStudent|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StudentTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StudentTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(StudentTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(StudentTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudentTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the identification_number column
     *
     * Example usage:
     * <code>
     * $query->filterByIdentificationNumber(1234); // WHERE identification_number = 1234
     * $query->filterByIdentificationNumber(array(12, 34)); // WHERE identification_number IN (12, 34)
     * $query->filterByIdentificationNumber(array('min' => 12)); // WHERE identification_number > 12
     * </code>
     *
     * @param     mixed $identificationNumber The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterByIdentificationNumber($identificationNumber = null, $comparison = null)
    {
        if (is_array($identificationNumber)) {
            $useMinMax = false;
            if (isset($identificationNumber['min'])) {
                $this->addUsingAlias(StudentTableMap::COL_IDENTIFICATION_NUMBER, $identificationNumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($identificationNumber['max'])) {
                $this->addUsingAlias(StudentTableMap::COL_IDENTIFICATION_NUMBER, $identificationNumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudentTableMap::COL_IDENTIFICATION_NUMBER, $identificationNumber, $comparison);
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
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterBySchoolYearId($schoolYearId = null, $comparison = null)
    {
        if (is_array($schoolYearId)) {
            $useMinMax = false;
            if (isset($schoolYearId['min'])) {
                $this->addUsingAlias(StudentTableMap::COL_SCHOOL_YEAR_ID, $schoolYearId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($schoolYearId['max'])) {
                $this->addUsingAlias(StudentTableMap::COL_SCHOOL_YEAR_ID, $schoolYearId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudentTableMap::COL_SCHOOL_YEAR_ID, $schoolYearId, $comparison);
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
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterByCourseId($courseId = null, $comparison = null)
    {
        if (is_array($courseId)) {
            $useMinMax = false;
            if (isset($courseId['min'])) {
                $this->addUsingAlias(StudentTableMap::COL_COURSE_ID, $courseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($courseId['max'])) {
                $this->addUsingAlias(StudentTableMap::COL_COURSE_ID, $courseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudentTableMap::COL_COURSE_ID, $courseId, $comparison);
    }

    /**
     * Filter the query on the first_name column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstName('fooValue');   // WHERE first_name = 'fooValue'
     * $query->filterByFirstName('%fooValue%'); // WHERE first_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterByFirstName($firstName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $firstName)) {
                $firstName = str_replace('*', '%', $firstName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StudentTableMap::COL_FIRST_NAME, $firstName, $comparison);
    }

    /**
     * Filter the query on the last_name column
     *
     * Example usage:
     * <code>
     * $query->filterByLastName('fooValue');   // WHERE last_name = 'fooValue'
     * $query->filterByLastName('%fooValue%'); // WHERE last_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterByLastName($lastName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lastName)) {
                $lastName = str_replace('*', '%', $lastName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StudentTableMap::COL_LAST_NAME, $lastName, $comparison);
    }

    /**
     * Filter the query on the birth_place column
     *
     * Example usage:
     * <code>
     * $query->filterByBirthPlace('fooValue');   // WHERE birth_place = 'fooValue'
     * $query->filterByBirthPlace('%fooValue%'); // WHERE birth_place LIKE '%fooValue%'
     * </code>
     *
     * @param     string $birthPlace The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterByBirthPlace($birthPlace = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($birthPlace)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $birthPlace)) {
                $birthPlace = str_replace('*', '%', $birthPlace);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StudentTableMap::COL_BIRTH_PLACE, $birthPlace, $comparison);
    }

    /**
     * Filter the query on the birthday column
     *
     * Example usage:
     * <code>
     * $query->filterByBirthday('2011-03-14'); // WHERE birthday = '2011-03-14'
     * $query->filterByBirthday('now'); // WHERE birthday = '2011-03-14'
     * $query->filterByBirthday(array('max' => 'yesterday')); // WHERE birthday > '2011-03-13'
     * </code>
     *
     * @param     mixed $birthday The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterByBirthday($birthday = null, $comparison = null)
    {
        if (is_array($birthday)) {
            $useMinMax = false;
            if (isset($birthday['min'])) {
                $this->addUsingAlias(StudentTableMap::COL_BIRTHDAY, $birthday['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($birthday['max'])) {
                $this->addUsingAlias(StudentTableMap::COL_BIRTHDAY, $birthday['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudentTableMap::COL_BIRTHDAY, $birthday, $comparison);
    }

    /**
     * Filter the query on the phone_number column
     *
     * Example usage:
     * <code>
     * $query->filterByPhoneNumber('fooValue');   // WHERE phone_number = 'fooValue'
     * $query->filterByPhoneNumber('%fooValue%'); // WHERE phone_number LIKE '%fooValue%'
     * </code>
     *
     * @param     string $phoneNumber The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterByPhoneNumber($phoneNumber = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phoneNumber)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $phoneNumber)) {
                $phoneNumber = str_replace('*', '%', $phoneNumber);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StudentTableMap::COL_PHONE_NUMBER, $phoneNumber, $comparison);
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
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(StudentTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(StudentTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudentTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(StudentTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(StudentTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudentTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\Course object
     *
     * @param \App\Models\Course|ObjectCollection $course The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildStudentQuery The current query, for fluid interface
     */
    public function filterByCourse($course, $comparison = null)
    {
        if ($course instanceof \App\Models\Course) {
            return $this
                ->addUsingAlias(StudentTableMap::COL_COURSE_ID, $course->getId(), $comparison);
        } elseif ($course instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudentTableMap::COL_COURSE_ID, $course->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildStudentQuery The current query, for fluid interface
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
     * Filter the query by a related \App\Models\SchoolYear object
     *
     * @param \App\Models\SchoolYear|ObjectCollection $schoolYear The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildStudentQuery The current query, for fluid interface
     */
    public function filterBySchoolYear($schoolYear, $comparison = null)
    {
        if ($schoolYear instanceof \App\Models\SchoolYear) {
            return $this
                ->addUsingAlias(StudentTableMap::COL_SCHOOL_YEAR_ID, $schoolYear->getId(), $comparison);
        } elseif ($schoolYear instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudentTableMap::COL_SCHOOL_YEAR_ID, $schoolYear->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildStudentQuery The current query, for fluid interface
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
     * Filter the query by a related \App\Models\AdminUser object
     *
     * @param \App\Models\AdminUser|ObjectCollection $adminUser the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStudentQuery The current query, for fluid interface
     */
    public function filterByAdminUser($adminUser, $comparison = null)
    {
        if ($adminUser instanceof \App\Models\AdminUser) {
            return $this
                ->addUsingAlias(StudentTableMap::COL_ID, $adminUser->getStudentId(), $comparison);
        } elseif ($adminUser instanceof ObjectCollection) {
            return $this
                ->useAdminUserQuery()
                ->filterByPrimaryKeys($adminUser->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function joinAdminUser($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useAdminUserQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAdminUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdminUser', '\App\Models\AdminUserQuery');
    }

    /**
     * Filter the query by a related \App\Models\Application object
     *
     * @param \App\Models\Application|ObjectCollection $application the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStudentQuery The current query, for fluid interface
     */
    public function filterByApplication($application, $comparison = null)
    {
        if ($application instanceof \App\Models\Application) {
            return $this
                ->addUsingAlias(StudentTableMap::COL_ID, $application->getStudentId(), $comparison);
        } elseif ($application instanceof ObjectCollection) {
            return $this
                ->useApplicationQuery()
                ->filterByPrimaryKeys($application->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByApplication() only accepts arguments of type \App\Models\Application or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Application relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function joinApplication($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Application');

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
            $this->addJoinObject($join, 'Application');
        }

        return $this;
    }

    /**
     * Use the Application relation Application object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\ApplicationQuery A secondary query class using the current class as primary query
     */
    public function useApplicationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinApplication($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Application', '\App\Models\ApplicationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildStudent $student Object to remove from the list of results
     *
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function prune($student = null)
    {
        if ($student) {
            $this->addUsingAlias(StudentTableMap::COL_ID, $student->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the student table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StudentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            StudentTableMap::clearInstancePool();
            StudentTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(StudentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StudentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            StudentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StudentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildStudentQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(StudentTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildStudentQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(StudentTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildStudentQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(StudentTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildStudentQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(StudentTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildStudentQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(StudentTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildStudentQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(StudentTableMap::COL_CREATED_AT);
    }

} // StudentQuery
