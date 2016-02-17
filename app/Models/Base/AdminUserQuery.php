<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\AdminUser as ChildAdminUser;
use App\Models\AdminUserQuery as ChildAdminUserQuery;
use App\Models\Map\AdminUserTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'admin_user' table.
 *
 *
 *
 * @method     ChildAdminUserQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAdminUserQuery orderByLanguageId($order = Criteria::ASC) Order by the language_id column
 * @method     ChildAdminUserQuery orderByProfessorId($order = Criteria::ASC) Order by the professor_id column
 * @method     ChildAdminUserQuery orderByStudentId($order = Criteria::ASC) Order by the student_id column
 * @method     ChildAdminUserQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildAdminUserQuery orderByLogin($order = Criteria::ASC) Order by the login column
 * @method     ChildAdminUserQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     ChildAdminUserQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildAdminUserQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildAdminUserQuery orderByRememberToken($order = Criteria::ASC) Order by the remember_token column
 * @method     ChildAdminUserQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildAdminUserQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildAdminUserQuery groupById() Group by the id column
 * @method     ChildAdminUserQuery groupByLanguageId() Group by the language_id column
 * @method     ChildAdminUserQuery groupByProfessorId() Group by the professor_id column
 * @method     ChildAdminUserQuery groupByStudentId() Group by the student_id column
 * @method     ChildAdminUserQuery groupByName() Group by the name column
 * @method     ChildAdminUserQuery groupByLogin() Group by the login column
 * @method     ChildAdminUserQuery groupByPassword() Group by the password column
 * @method     ChildAdminUserQuery groupByEmail() Group by the email column
 * @method     ChildAdminUserQuery groupByStatus() Group by the status column
 * @method     ChildAdminUserQuery groupByRememberToken() Group by the remember_token column
 * @method     ChildAdminUserQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildAdminUserQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildAdminUserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAdminUserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAdminUserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAdminUserQuery leftJoinProfessor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Professor relation
 * @method     ChildAdminUserQuery rightJoinProfessor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Professor relation
 * @method     ChildAdminUserQuery innerJoinProfessor($relationAlias = null) Adds a INNER JOIN clause to the query using the Professor relation
 *
 * @method     ChildAdminUserQuery leftJoinStudent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Student relation
 * @method     ChildAdminUserQuery rightJoinStudent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Student relation
 * @method     ChildAdminUserQuery innerJoinStudent($relationAlias = null) Adds a INNER JOIN clause to the query using the Student relation
 *
 * @method     ChildAdminUserQuery leftJoinTranslationLanguage($relationAlias = null) Adds a LEFT JOIN clause to the query using the TranslationLanguage relation
 * @method     ChildAdminUserQuery rightJoinTranslationLanguage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TranslationLanguage relation
 * @method     ChildAdminUserQuery innerJoinTranslationLanguage($relationAlias = null) Adds a INNER JOIN clause to the query using the TranslationLanguage relation
 *
 * @method     ChildAdminUserQuery leftJoinAdminUserCredential($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdminUserCredential relation
 * @method     ChildAdminUserQuery rightJoinAdminUserCredential($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdminUserCredential relation
 * @method     ChildAdminUserQuery innerJoinAdminUserCredential($relationAlias = null) Adds a INNER JOIN clause to the query using the AdminUserCredential relation
 *
 * @method     \App\Models\ProfessorQuery|\App\Models\StudentQuery|\App\Models\TranslationLanguageQuery|\App\Models\AdminUserCredentialQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAdminUser findOne(ConnectionInterface $con = null) Return the first ChildAdminUser matching the query
 * @method     ChildAdminUser findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAdminUser matching the query, or a new ChildAdminUser object populated from the query conditions when no match is found
 *
 * @method     ChildAdminUser findOneById(int $id) Return the first ChildAdminUser filtered by the id column
 * @method     ChildAdminUser findOneByLanguageId(int $language_id) Return the first ChildAdminUser filtered by the language_id column
 * @method     ChildAdminUser findOneByProfessorId(int $professor_id) Return the first ChildAdminUser filtered by the professor_id column
 * @method     ChildAdminUser findOneByStudentId(int $student_id) Return the first ChildAdminUser filtered by the student_id column
 * @method     ChildAdminUser findOneByName(string $name) Return the first ChildAdminUser filtered by the name column
 * @method     ChildAdminUser findOneByLogin(string $login) Return the first ChildAdminUser filtered by the login column
 * @method     ChildAdminUser findOneByPassword(string $password) Return the first ChildAdminUser filtered by the password column
 * @method     ChildAdminUser findOneByEmail(string $email) Return the first ChildAdminUser filtered by the email column
 * @method     ChildAdminUser findOneByStatus(string $status) Return the first ChildAdminUser filtered by the status column
 * @method     ChildAdminUser findOneByRememberToken(string $remember_token) Return the first ChildAdminUser filtered by the remember_token column
 * @method     ChildAdminUser findOneByCreatedAt(string $created_at) Return the first ChildAdminUser filtered by the created_at column
 * @method     ChildAdminUser findOneByUpdatedAt(string $updated_at) Return the first ChildAdminUser filtered by the updated_at column *

 * @method     ChildAdminUser requirePk($key, ConnectionInterface $con = null) Return the ChildAdminUser by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUser requireOne(ConnectionInterface $con = null) Return the first ChildAdminUser matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAdminUser requireOneById(int $id) Return the first ChildAdminUser filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUser requireOneByLanguageId(int $language_id) Return the first ChildAdminUser filtered by the language_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUser requireOneByProfessorId(int $professor_id) Return the first ChildAdminUser filtered by the professor_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUser requireOneByStudentId(int $student_id) Return the first ChildAdminUser filtered by the student_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUser requireOneByName(string $name) Return the first ChildAdminUser filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUser requireOneByLogin(string $login) Return the first ChildAdminUser filtered by the login column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUser requireOneByPassword(string $password) Return the first ChildAdminUser filtered by the password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUser requireOneByEmail(string $email) Return the first ChildAdminUser filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUser requireOneByStatus(string $status) Return the first ChildAdminUser filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUser requireOneByRememberToken(string $remember_token) Return the first ChildAdminUser filtered by the remember_token column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUser requireOneByCreatedAt(string $created_at) Return the first ChildAdminUser filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAdminUser requireOneByUpdatedAt(string $updated_at) Return the first ChildAdminUser filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAdminUser[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAdminUser objects based on current ModelCriteria
 * @method     ChildAdminUser[]|ObjectCollection findById(int $id) Return ChildAdminUser objects filtered by the id column
 * @method     ChildAdminUser[]|ObjectCollection findByLanguageId(int $language_id) Return ChildAdminUser objects filtered by the language_id column
 * @method     ChildAdminUser[]|ObjectCollection findByProfessorId(int $professor_id) Return ChildAdminUser objects filtered by the professor_id column
 * @method     ChildAdminUser[]|ObjectCollection findByStudentId(int $student_id) Return ChildAdminUser objects filtered by the student_id column
 * @method     ChildAdminUser[]|ObjectCollection findByName(string $name) Return ChildAdminUser objects filtered by the name column
 * @method     ChildAdminUser[]|ObjectCollection findByLogin(string $login) Return ChildAdminUser objects filtered by the login column
 * @method     ChildAdminUser[]|ObjectCollection findByPassword(string $password) Return ChildAdminUser objects filtered by the password column
 * @method     ChildAdminUser[]|ObjectCollection findByEmail(string $email) Return ChildAdminUser objects filtered by the email column
 * @method     ChildAdminUser[]|ObjectCollection findByStatus(string $status) Return ChildAdminUser objects filtered by the status column
 * @method     ChildAdminUser[]|ObjectCollection findByRememberToken(string $remember_token) Return ChildAdminUser objects filtered by the remember_token column
 * @method     ChildAdminUser[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildAdminUser objects filtered by the created_at column
 * @method     ChildAdminUser[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildAdminUser objects filtered by the updated_at column
 * @method     ChildAdminUser[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AdminUserQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\AdminUserQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\AdminUser', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAdminUserQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAdminUserQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAdminUserQuery) {
            return $criteria;
        }
        $query = new ChildAdminUserQuery();
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
     * @return ChildAdminUser|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AdminUserTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AdminUserTableMap::DATABASE_NAME);
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
     * @return ChildAdminUser A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, language_id, professor_id, student_id, name, login, password, email, status, remember_token, created_at, updated_at FROM admin_user WHERE id = :p0';
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
            /** @var ChildAdminUser $obj */
            $obj = new ChildAdminUser();
            $obj->hydrate($row);
            AdminUserTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildAdminUser|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AdminUserTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AdminUserTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AdminUserTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AdminUserTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdminUserTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the language_id column
     *
     * Example usage:
     * <code>
     * $query->filterByLanguageId(1234); // WHERE language_id = 1234
     * $query->filterByLanguageId(array(12, 34)); // WHERE language_id IN (12, 34)
     * $query->filterByLanguageId(array('min' => 12)); // WHERE language_id > 12
     * </code>
     *
     * @see       filterByTranslationLanguage()
     *
     * @param     mixed $languageId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterByLanguageId($languageId = null, $comparison = null)
    {
        if (is_array($languageId)) {
            $useMinMax = false;
            if (isset($languageId['min'])) {
                $this->addUsingAlias(AdminUserTableMap::COL_LANGUAGE_ID, $languageId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($languageId['max'])) {
                $this->addUsingAlias(AdminUserTableMap::COL_LANGUAGE_ID, $languageId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdminUserTableMap::COL_LANGUAGE_ID, $languageId, $comparison);
    }

    /**
     * Filter the query on the professor_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProfessorId(1234); // WHERE professor_id = 1234
     * $query->filterByProfessorId(array(12, 34)); // WHERE professor_id IN (12, 34)
     * $query->filterByProfessorId(array('min' => 12)); // WHERE professor_id > 12
     * </code>
     *
     * @see       filterByProfessor()
     *
     * @param     mixed $professorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterByProfessorId($professorId = null, $comparison = null)
    {
        if (is_array($professorId)) {
            $useMinMax = false;
            if (isset($professorId['min'])) {
                $this->addUsingAlias(AdminUserTableMap::COL_PROFESSOR_ID, $professorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($professorId['max'])) {
                $this->addUsingAlias(AdminUserTableMap::COL_PROFESSOR_ID, $professorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdminUserTableMap::COL_PROFESSOR_ID, $professorId, $comparison);
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
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterByStudentId($studentId = null, $comparison = null)
    {
        if (is_array($studentId)) {
            $useMinMax = false;
            if (isset($studentId['min'])) {
                $this->addUsingAlias(AdminUserTableMap::COL_STUDENT_ID, $studentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studentId['max'])) {
                $this->addUsingAlias(AdminUserTableMap::COL_STUDENT_ID, $studentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdminUserTableMap::COL_STUDENT_ID, $studentId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdminUserTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the login column
     *
     * Example usage:
     * <code>
     * $query->filterByLogin('fooValue');   // WHERE login = 'fooValue'
     * $query->filterByLogin('%fooValue%'); // WHERE login LIKE '%fooValue%'
     * </code>
     *
     * @param     string $login The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterByLogin($login = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($login)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $login)) {
                $login = str_replace('*', '%', $login);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdminUserTableMap::COL_LOGIN, $login, $comparison);
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%'); // WHERE password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $password)) {
                $password = str_replace('*', '%', $password);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdminUserTableMap::COL_PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdminUserTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%'); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $status)) {
                $status = str_replace('*', '%', $status);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdminUserTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the remember_token column
     *
     * Example usage:
     * <code>
     * $query->filterByRememberToken('fooValue');   // WHERE remember_token = 'fooValue'
     * $query->filterByRememberToken('%fooValue%'); // WHERE remember_token LIKE '%fooValue%'
     * </code>
     *
     * @param     string $rememberToken The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterByRememberToken($rememberToken = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($rememberToken)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $rememberToken)) {
                $rememberToken = str_replace('*', '%', $rememberToken);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdminUserTableMap::COL_REMEMBER_TOKEN, $rememberToken, $comparison);
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
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(AdminUserTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(AdminUserTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdminUserTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(AdminUserTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(AdminUserTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdminUserTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\Professor object
     *
     * @param \App\Models\Professor|ObjectCollection $professor The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterByProfessor($professor, $comparison = null)
    {
        if ($professor instanceof \App\Models\Professor) {
            return $this
                ->addUsingAlias(AdminUserTableMap::COL_PROFESSOR_ID, $professor->getId(), $comparison);
        } elseif ($professor instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdminUserTableMap::COL_PROFESSOR_ID, $professor->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProfessor() only accepts arguments of type \App\Models\Professor or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Professor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function joinProfessor($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Professor');

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
            $this->addJoinObject($join, 'Professor');
        }

        return $this;
    }

    /**
     * Use the Professor relation Professor object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\ProfessorQuery A secondary query class using the current class as primary query
     */
    public function useProfessorQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProfessor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Professor', '\App\Models\ProfessorQuery');
    }

    /**
     * Filter the query by a related \App\Models\Student object
     *
     * @param \App\Models\Student|ObjectCollection $student The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterByStudent($student, $comparison = null)
    {
        if ($student instanceof \App\Models\Student) {
            return $this
                ->addUsingAlias(AdminUserTableMap::COL_STUDENT_ID, $student->getId(), $comparison);
        } elseif ($student instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdminUserTableMap::COL_STUDENT_ID, $student->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function joinStudent($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useStudentQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinStudent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Student', '\App\Models\StudentQuery');
    }

    /**
     * Filter the query by a related \App\Models\TranslationLanguage object
     *
     * @param \App\Models\TranslationLanguage|ObjectCollection $translationLanguage The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterByTranslationLanguage($translationLanguage, $comparison = null)
    {
        if ($translationLanguage instanceof \App\Models\TranslationLanguage) {
            return $this
                ->addUsingAlias(AdminUserTableMap::COL_LANGUAGE_ID, $translationLanguage->getId(), $comparison);
        } elseif ($translationLanguage instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdminUserTableMap::COL_LANGUAGE_ID, $translationLanguage->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTranslationLanguage() only accepts arguments of type \App\Models\TranslationLanguage or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TranslationLanguage relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function joinTranslationLanguage($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TranslationLanguage');

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
            $this->addJoinObject($join, 'TranslationLanguage');
        }

        return $this;
    }

    /**
     * Use the TranslationLanguage relation TranslationLanguage object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\TranslationLanguageQuery A secondary query class using the current class as primary query
     */
    public function useTranslationLanguageQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTranslationLanguage($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TranslationLanguage', '\App\Models\TranslationLanguageQuery');
    }

    /**
     * Filter the query by a related \App\Models\AdminUserCredential object
     *
     * @param \App\Models\AdminUserCredential|ObjectCollection $adminUserCredential the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAdminUserQuery The current query, for fluid interface
     */
    public function filterByAdminUserCredential($adminUserCredential, $comparison = null)
    {
        if ($adminUserCredential instanceof \App\Models\AdminUserCredential) {
            return $this
                ->addUsingAlias(AdminUserTableMap::COL_ID, $adminUserCredential->getAdminUserId(), $comparison);
        } elseif ($adminUserCredential instanceof ObjectCollection) {
            return $this
                ->useAdminUserCredentialQuery()
                ->filterByPrimaryKeys($adminUserCredential->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAdminUserCredential() only accepts arguments of type \App\Models\AdminUserCredential or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdminUserCredential relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function joinAdminUserCredential($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdminUserCredential');

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
            $this->addJoinObject($join, 'AdminUserCredential');
        }

        return $this;
    }

    /**
     * Use the AdminUserCredential relation AdminUserCredential object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\AdminUserCredentialQuery A secondary query class using the current class as primary query
     */
    public function useAdminUserCredentialQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAdminUserCredential($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdminUserCredential', '\App\Models\AdminUserCredentialQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAdminUser $adminUser Object to remove from the list of results
     *
     * @return $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function prune($adminUser = null)
    {
        if ($adminUser) {
            $this->addUsingAlias(AdminUserTableMap::COL_ID, $adminUser->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the admin_user table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AdminUserTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AdminUserTableMap::clearInstancePool();
            AdminUserTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AdminUserTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AdminUserTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AdminUserTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AdminUserTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(AdminUserTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(AdminUserTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(AdminUserTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(AdminUserTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(AdminUserTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildAdminUserQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(AdminUserTableMap::COL_CREATED_AT);
    }

} // AdminUserQuery
