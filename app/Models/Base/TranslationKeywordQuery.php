<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\TranslationKeyword as ChildTranslationKeyword;
use App\Models\TranslationKeywordQuery as ChildTranslationKeywordQuery;
use App\Models\Map\TranslationKeywordTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'translation_keyword' table.
 *
 *
 *
 * @method     ChildTranslationKeywordQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTranslationKeywordQuery orderByCatalogId($order = Criteria::ASC) Order by the catalog_id column
 * @method     ChildTranslationKeywordQuery orderByKeyword($order = Criteria::ASC) Order by the keyword column
 * @method     ChildTranslationKeywordQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildTranslationKeywordQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildTranslationKeywordQuery groupById() Group by the id column
 * @method     ChildTranslationKeywordQuery groupByCatalogId() Group by the catalog_id column
 * @method     ChildTranslationKeywordQuery groupByKeyword() Group by the keyword column
 * @method     ChildTranslationKeywordQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildTranslationKeywordQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildTranslationKeywordQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTranslationKeywordQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTranslationKeywordQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTranslationKeywordQuery leftJoinTranslationCatalog($relationAlias = null) Adds a LEFT JOIN clause to the query using the TranslationCatalog relation
 * @method     ChildTranslationKeywordQuery rightJoinTranslationCatalog($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TranslationCatalog relation
 * @method     ChildTranslationKeywordQuery innerJoinTranslationCatalog($relationAlias = null) Adds a INNER JOIN clause to the query using the TranslationCatalog relation
 *
 * @method     ChildTranslationKeywordQuery leftJoinTranslationLanguageKeyword($relationAlias = null) Adds a LEFT JOIN clause to the query using the TranslationLanguageKeyword relation
 * @method     ChildTranslationKeywordQuery rightJoinTranslationLanguageKeyword($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TranslationLanguageKeyword relation
 * @method     ChildTranslationKeywordQuery innerJoinTranslationLanguageKeyword($relationAlias = null) Adds a INNER JOIN clause to the query using the TranslationLanguageKeyword relation
 *
 * @method     \App\Models\TranslationCatalogQuery|\App\Models\TranslationLanguageKeywordQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTranslationKeyword findOne(ConnectionInterface $con = null) Return the first ChildTranslationKeyword matching the query
 * @method     ChildTranslationKeyword findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTranslationKeyword matching the query, or a new ChildTranslationKeyword object populated from the query conditions when no match is found
 *
 * @method     ChildTranslationKeyword findOneById(int $id) Return the first ChildTranslationKeyword filtered by the id column
 * @method     ChildTranslationKeyword findOneByCatalogId(int $catalog_id) Return the first ChildTranslationKeyword filtered by the catalog_id column
 * @method     ChildTranslationKeyword findOneByKeyword(string $keyword) Return the first ChildTranslationKeyword filtered by the keyword column
 * @method     ChildTranslationKeyword findOneByCreatedAt(string $created_at) Return the first ChildTranslationKeyword filtered by the created_at column
 * @method     ChildTranslationKeyword findOneByUpdatedAt(string $updated_at) Return the first ChildTranslationKeyword filtered by the updated_at column *

 * @method     ChildTranslationKeyword requirePk($key, ConnectionInterface $con = null) Return the ChildTranslationKeyword by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationKeyword requireOne(ConnectionInterface $con = null) Return the first ChildTranslationKeyword matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTranslationKeyword requireOneById(int $id) Return the first ChildTranslationKeyword filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationKeyword requireOneByCatalogId(int $catalog_id) Return the first ChildTranslationKeyword filtered by the catalog_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationKeyword requireOneByKeyword(string $keyword) Return the first ChildTranslationKeyword filtered by the keyword column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationKeyword requireOneByCreatedAt(string $created_at) Return the first ChildTranslationKeyword filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationKeyword requireOneByUpdatedAt(string $updated_at) Return the first ChildTranslationKeyword filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTranslationKeyword[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTranslationKeyword objects based on current ModelCriteria
 * @method     ChildTranslationKeyword[]|ObjectCollection findById(int $id) Return ChildTranslationKeyword objects filtered by the id column
 * @method     ChildTranslationKeyword[]|ObjectCollection findByCatalogId(int $catalog_id) Return ChildTranslationKeyword objects filtered by the catalog_id column
 * @method     ChildTranslationKeyword[]|ObjectCollection findByKeyword(string $keyword) Return ChildTranslationKeyword objects filtered by the keyword column
 * @method     ChildTranslationKeyword[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildTranslationKeyword objects filtered by the created_at column
 * @method     ChildTranslationKeyword[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildTranslationKeyword objects filtered by the updated_at column
 * @method     ChildTranslationKeyword[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TranslationKeywordQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\TranslationKeywordQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\TranslationKeyword', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTranslationKeywordQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTranslationKeywordQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTranslationKeywordQuery) {
            return $criteria;
        }
        $query = new ChildTranslationKeywordQuery();
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
     * @return ChildTranslationKeyword|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TranslationKeywordTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TranslationKeywordTableMap::DATABASE_NAME);
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
     * @return ChildTranslationKeyword A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, catalog_id, keyword, created_at, updated_at FROM translation_keyword WHERE id = :p0';
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
            /** @var ChildTranslationKeyword $obj */
            $obj = new ChildTranslationKeyword();
            $obj->hydrate($row);
            TranslationKeywordTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildTranslationKeyword|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTranslationKeywordQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TranslationKeywordTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTranslationKeywordQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TranslationKeywordTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTranslationKeywordQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TranslationKeywordTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TranslationKeywordTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TranslationKeywordTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the catalog_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCatalogId(1234); // WHERE catalog_id = 1234
     * $query->filterByCatalogId(array(12, 34)); // WHERE catalog_id IN (12, 34)
     * $query->filterByCatalogId(array('min' => 12)); // WHERE catalog_id > 12
     * </code>
     *
     * @see       filterByTranslationCatalog()
     *
     * @param     mixed $catalogId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTranslationKeywordQuery The current query, for fluid interface
     */
    public function filterByCatalogId($catalogId = null, $comparison = null)
    {
        if (is_array($catalogId)) {
            $useMinMax = false;
            if (isset($catalogId['min'])) {
                $this->addUsingAlias(TranslationKeywordTableMap::COL_CATALOG_ID, $catalogId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($catalogId['max'])) {
                $this->addUsingAlias(TranslationKeywordTableMap::COL_CATALOG_ID, $catalogId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TranslationKeywordTableMap::COL_CATALOG_ID, $catalogId, $comparison);
    }

    /**
     * Filter the query on the keyword column
     *
     * Example usage:
     * <code>
     * $query->filterByKeyword('fooValue');   // WHERE keyword = 'fooValue'
     * $query->filterByKeyword('%fooValue%'); // WHERE keyword LIKE '%fooValue%'
     * </code>
     *
     * @param     string $keyword The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTranslationKeywordQuery The current query, for fluid interface
     */
    public function filterByKeyword($keyword = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($keyword)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $keyword)) {
                $keyword = str_replace('*', '%', $keyword);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TranslationKeywordTableMap::COL_KEYWORD, $keyword, $comparison);
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
     * @return $this|ChildTranslationKeywordQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(TranslationKeywordTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(TranslationKeywordTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TranslationKeywordTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildTranslationKeywordQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(TranslationKeywordTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(TranslationKeywordTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TranslationKeywordTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\TranslationCatalog object
     *
     * @param \App\Models\TranslationCatalog|ObjectCollection $translationCatalog The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTranslationKeywordQuery The current query, for fluid interface
     */
    public function filterByTranslationCatalog($translationCatalog, $comparison = null)
    {
        if ($translationCatalog instanceof \App\Models\TranslationCatalog) {
            return $this
                ->addUsingAlias(TranslationKeywordTableMap::COL_CATALOG_ID, $translationCatalog->getId(), $comparison);
        } elseif ($translationCatalog instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TranslationKeywordTableMap::COL_CATALOG_ID, $translationCatalog->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTranslationCatalog() only accepts arguments of type \App\Models\TranslationCatalog or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TranslationCatalog relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTranslationKeywordQuery The current query, for fluid interface
     */
    public function joinTranslationCatalog($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TranslationCatalog');

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
            $this->addJoinObject($join, 'TranslationCatalog');
        }

        return $this;
    }

    /**
     * Use the TranslationCatalog relation TranslationCatalog object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\TranslationCatalogQuery A secondary query class using the current class as primary query
     */
    public function useTranslationCatalogQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTranslationCatalog($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TranslationCatalog', '\App\Models\TranslationCatalogQuery');
    }

    /**
     * Filter the query by a related \App\Models\TranslationLanguageKeyword object
     *
     * @param \App\Models\TranslationLanguageKeyword|ObjectCollection $translationLanguageKeyword the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTranslationKeywordQuery The current query, for fluid interface
     */
    public function filterByTranslationLanguageKeyword($translationLanguageKeyword, $comparison = null)
    {
        if ($translationLanguageKeyword instanceof \App\Models\TranslationLanguageKeyword) {
            return $this
                ->addUsingAlias(TranslationKeywordTableMap::COL_ID, $translationLanguageKeyword->getKeywordId(), $comparison);
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
     * @return $this|ChildTranslationKeywordQuery The current query, for fluid interface
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
     * @param   ChildTranslationKeyword $translationKeyword Object to remove from the list of results
     *
     * @return $this|ChildTranslationKeywordQuery The current query, for fluid interface
     */
    public function prune($translationKeyword = null)
    {
        if ($translationKeyword) {
            $this->addUsingAlias(TranslationKeywordTableMap::COL_ID, $translationKeyword->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the translation_keyword table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TranslationKeywordTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TranslationKeywordTableMap::clearInstancePool();
            TranslationKeywordTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TranslationKeywordTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TranslationKeywordTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TranslationKeywordTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TranslationKeywordTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildTranslationKeywordQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(TranslationKeywordTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildTranslationKeywordQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(TranslationKeywordTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildTranslationKeywordQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(TranslationKeywordTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildTranslationKeywordQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(TranslationKeywordTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildTranslationKeywordQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(TranslationKeywordTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildTranslationKeywordQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(TranslationKeywordTableMap::COL_CREATED_AT);
    }

} // TranslationKeywordQuery
