<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\TranslationLanguage as ChildTranslationLanguage;
use App\Models\TranslationLanguageQuery as ChildTranslationLanguageQuery;
use App\Models\Map\TranslationLanguageTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'translation_language' table.
 *
 *
 *
 * @method     ChildTranslationLanguageQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTranslationLanguageQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildTranslationLanguageQuery orderByCulture($order = Criteria::ASC) Order by the culture column
 * @method     ChildTranslationLanguageQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildTranslationLanguageQuery orderByIsActive($order = Criteria::ASC) Order by the is_active column
 * @method     ChildTranslationLanguageQuery orderByIsDefault($order = Criteria::ASC) Order by the is_default column
 * @method     ChildTranslationLanguageQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildTranslationLanguageQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildTranslationLanguageQuery groupById() Group by the id column
 * @method     ChildTranslationLanguageQuery groupByName() Group by the name column
 * @method     ChildTranslationLanguageQuery groupByCulture() Group by the culture column
 * @method     ChildTranslationLanguageQuery groupByLocale() Group by the locale column
 * @method     ChildTranslationLanguageQuery groupByIsActive() Group by the is_active column
 * @method     ChildTranslationLanguageQuery groupByIsDefault() Group by the is_default column
 * @method     ChildTranslationLanguageQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildTranslationLanguageQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildTranslationLanguageQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTranslationLanguageQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTranslationLanguageQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTranslationLanguageQuery leftJoinAdminUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdminUser relation
 * @method     ChildTranslationLanguageQuery rightJoinAdminUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdminUser relation
 * @method     ChildTranslationLanguageQuery innerJoinAdminUser($relationAlias = null) Adds a INNER JOIN clause to the query using the AdminUser relation
 *
 * @method     ChildTranslationLanguageQuery leftJoinTranslationLanguageKeyword($relationAlias = null) Adds a LEFT JOIN clause to the query using the TranslationLanguageKeyword relation
 * @method     ChildTranslationLanguageQuery rightJoinTranslationLanguageKeyword($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TranslationLanguageKeyword relation
 * @method     ChildTranslationLanguageQuery innerJoinTranslationLanguageKeyword($relationAlias = null) Adds a INNER JOIN clause to the query using the TranslationLanguageKeyword relation
 *
 * @method     \App\Models\AdminUserQuery|\App\Models\TranslationLanguageKeywordQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTranslationLanguage findOne(ConnectionInterface $con = null) Return the first ChildTranslationLanguage matching the query
 * @method     ChildTranslationLanguage findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTranslationLanguage matching the query, or a new ChildTranslationLanguage object populated from the query conditions when no match is found
 *
 * @method     ChildTranslationLanguage findOneById(int $id) Return the first ChildTranslationLanguage filtered by the id column
 * @method     ChildTranslationLanguage findOneByName(string $name) Return the first ChildTranslationLanguage filtered by the name column
 * @method     ChildTranslationLanguage findOneByCulture(string $culture) Return the first ChildTranslationLanguage filtered by the culture column
 * @method     ChildTranslationLanguage findOneByLocale(string $locale) Return the first ChildTranslationLanguage filtered by the locale column
 * @method     ChildTranslationLanguage findOneByIsActive(int $is_active) Return the first ChildTranslationLanguage filtered by the is_active column
 * @method     ChildTranslationLanguage findOneByIsDefault(int $is_default) Return the first ChildTranslationLanguage filtered by the is_default column
 * @method     ChildTranslationLanguage findOneByCreatedAt(string $created_at) Return the first ChildTranslationLanguage filtered by the created_at column
 * @method     ChildTranslationLanguage findOneByUpdatedAt(string $updated_at) Return the first ChildTranslationLanguage filtered by the updated_at column *

 * @method     ChildTranslationLanguage requirePk($key, ConnectionInterface $con = null) Return the ChildTranslationLanguage by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationLanguage requireOne(ConnectionInterface $con = null) Return the first ChildTranslationLanguage matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTranslationLanguage requireOneById(int $id) Return the first ChildTranslationLanguage filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationLanguage requireOneByName(string $name) Return the first ChildTranslationLanguage filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationLanguage requireOneByCulture(string $culture) Return the first ChildTranslationLanguage filtered by the culture column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationLanguage requireOneByLocale(string $locale) Return the first ChildTranslationLanguage filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationLanguage requireOneByIsActive(int $is_active) Return the first ChildTranslationLanguage filtered by the is_active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationLanguage requireOneByIsDefault(int $is_default) Return the first ChildTranslationLanguage filtered by the is_default column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationLanguage requireOneByCreatedAt(string $created_at) Return the first ChildTranslationLanguage filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationLanguage requireOneByUpdatedAt(string $updated_at) Return the first ChildTranslationLanguage filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTranslationLanguage[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTranslationLanguage objects based on current ModelCriteria
 * @method     ChildTranslationLanguage[]|ObjectCollection findById(int $id) Return ChildTranslationLanguage objects filtered by the id column
 * @method     ChildTranslationLanguage[]|ObjectCollection findByName(string $name) Return ChildTranslationLanguage objects filtered by the name column
 * @method     ChildTranslationLanguage[]|ObjectCollection findByCulture(string $culture) Return ChildTranslationLanguage objects filtered by the culture column
 * @method     ChildTranslationLanguage[]|ObjectCollection findByLocale(string $locale) Return ChildTranslationLanguage objects filtered by the locale column
 * @method     ChildTranslationLanguage[]|ObjectCollection findByIsActive(int $is_active) Return ChildTranslationLanguage objects filtered by the is_active column
 * @method     ChildTranslationLanguage[]|ObjectCollection findByIsDefault(int $is_default) Return ChildTranslationLanguage objects filtered by the is_default column
 * @method     ChildTranslationLanguage[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildTranslationLanguage objects filtered by the created_at column
 * @method     ChildTranslationLanguage[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildTranslationLanguage objects filtered by the updated_at column
 * @method     ChildTranslationLanguage[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TranslationLanguageQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\TranslationLanguageQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\TranslationLanguage', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTranslationLanguageQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTranslationLanguageQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTranslationLanguageQuery) {
            return $criteria;
        }
        $query = new ChildTranslationLanguageQuery();
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
     * @return ChildTranslationLanguage|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TranslationLanguageTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TranslationLanguageTableMap::DATABASE_NAME);
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
     * @return ChildTranslationLanguage A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, culture, locale, is_active, is_default, created_at, updated_at FROM translation_language WHERE id = :p0';
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
            /** @var ChildTranslationLanguage $obj */
            $obj = new ChildTranslationLanguage();
            $obj->hydrate($row);
            TranslationLanguageTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildTranslationLanguage|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TranslationLanguageTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TranslationLanguageTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TranslationLanguageTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TranslationLanguageTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TranslationLanguageTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildTranslationLanguageQuery The current query, for fluid interface
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

        return $this->addUsingAlias(TranslationLanguageTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the culture column
     *
     * Example usage:
     * <code>
     * $query->filterByCulture('fooValue');   // WHERE culture = 'fooValue'
     * $query->filterByCulture('%fooValue%'); // WHERE culture LIKE '%fooValue%'
     * </code>
     *
     * @param     string $culture The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function filterByCulture($culture = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($culture)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $culture)) {
                $culture = str_replace('*', '%', $culture);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TranslationLanguageTableMap::COL_CULTURE, $culture, $comparison);
    }

    /**
     * Filter the query on the locale column
     *
     * Example usage:
     * <code>
     * $query->filterByLocale('fooValue');   // WHERE locale = 'fooValue'
     * $query->filterByLocale('%fooValue%'); // WHERE locale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locale The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $locale)) {
                $locale = str_replace('*', '%', $locale);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TranslationLanguageTableMap::COL_LOCALE, $locale, $comparison);
    }

    /**
     * Filter the query on the is_active column
     *
     * Example usage:
     * <code>
     * $query->filterByIsActive(1234); // WHERE is_active = 1234
     * $query->filterByIsActive(array(12, 34)); // WHERE is_active IN (12, 34)
     * $query->filterByIsActive(array('min' => 12)); // WHERE is_active > 12
     * </code>
     *
     * @param     mixed $isActive The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function filterByIsActive($isActive = null, $comparison = null)
    {
        if (is_array($isActive)) {
            $useMinMax = false;
            if (isset($isActive['min'])) {
                $this->addUsingAlias(TranslationLanguageTableMap::COL_IS_ACTIVE, $isActive['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isActive['max'])) {
                $this->addUsingAlias(TranslationLanguageTableMap::COL_IS_ACTIVE, $isActive['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TranslationLanguageTableMap::COL_IS_ACTIVE, $isActive, $comparison);
    }

    /**
     * Filter the query on the is_default column
     *
     * Example usage:
     * <code>
     * $query->filterByIsDefault(1234); // WHERE is_default = 1234
     * $query->filterByIsDefault(array(12, 34)); // WHERE is_default IN (12, 34)
     * $query->filterByIsDefault(array('min' => 12)); // WHERE is_default > 12
     * </code>
     *
     * @param     mixed $isDefault The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function filterByIsDefault($isDefault = null, $comparison = null)
    {
        if (is_array($isDefault)) {
            $useMinMax = false;
            if (isset($isDefault['min'])) {
                $this->addUsingAlias(TranslationLanguageTableMap::COL_IS_DEFAULT, $isDefault['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isDefault['max'])) {
                $this->addUsingAlias(TranslationLanguageTableMap::COL_IS_DEFAULT, $isDefault['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TranslationLanguageTableMap::COL_IS_DEFAULT, $isDefault, $comparison);
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
     * @return $this|ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(TranslationLanguageTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(TranslationLanguageTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TranslationLanguageTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(TranslationLanguageTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(TranslationLanguageTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TranslationLanguageTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\AdminUser object
     *
     * @param \App\Models\AdminUser|ObjectCollection $adminUser the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function filterByAdminUser($adminUser, $comparison = null)
    {
        if ($adminUser instanceof \App\Models\AdminUser) {
            return $this
                ->addUsingAlias(TranslationLanguageTableMap::COL_ID, $adminUser->getLanguageId(), $comparison);
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
     * @return $this|ChildTranslationLanguageQuery The current query, for fluid interface
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
     * Filter the query by a related \App\Models\TranslationLanguageKeyword object
     *
     * @param \App\Models\TranslationLanguageKeyword|ObjectCollection $translationLanguageKeyword the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function filterByTranslationLanguageKeyword($translationLanguageKeyword, $comparison = null)
    {
        if ($translationLanguageKeyword instanceof \App\Models\TranslationLanguageKeyword) {
            return $this
                ->addUsingAlias(TranslationLanguageTableMap::COL_ID, $translationLanguageKeyword->getLanguageId(), $comparison);
        } elseif ($translationLanguageKeyword instanceof ObjectCollection) {
            return $this
                ->useTranslationLanguageKeywordQuery()
                ->filterByPrimaryKeys($translationLanguageKeyword->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTranslationLanguageKeyword() only accepts arguments of type \App\Models\TranslationLanguageKeyword or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TranslationLanguageKeyword relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function joinTranslationLanguageKeyword($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TranslationLanguageKeyword');

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
            $this->addJoinObject($join, 'TranslationLanguageKeyword');
        }

        return $this;
    }

    /**
     * Use the TranslationLanguageKeyword relation TranslationLanguageKeyword object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\TranslationLanguageKeywordQuery A secondary query class using the current class as primary query
     */
    public function useTranslationLanguageKeywordQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTranslationLanguageKeyword($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TranslationLanguageKeyword', '\App\Models\TranslationLanguageKeywordQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTranslationLanguage $translationLanguage Object to remove from the list of results
     *
     * @return $this|ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function prune($translationLanguage = null)
    {
        if ($translationLanguage) {
            $this->addUsingAlias(TranslationLanguageTableMap::COL_ID, $translationLanguage->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the translation_language table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TranslationLanguageTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TranslationLanguageTableMap::clearInstancePool();
            TranslationLanguageTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TranslationLanguageTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TranslationLanguageTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TranslationLanguageTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TranslationLanguageTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(TranslationLanguageTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(TranslationLanguageTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(TranslationLanguageTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(TranslationLanguageTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(TranslationLanguageTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildTranslationLanguageQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(TranslationLanguageTableMap::COL_CREATED_AT);
    }

} // TranslationLanguageQuery
