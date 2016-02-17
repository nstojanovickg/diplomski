<?php

namespace App\Models\Base;

use \Exception;
use \PDO;
use App\Models\TranslationLanguageKeyword as ChildTranslationLanguageKeyword;
use App\Models\TranslationLanguageKeywordQuery as ChildTranslationLanguageKeywordQuery;
use App\Models\Map\TranslationLanguageKeywordTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'translation_language_keyword' table.
 *
 *
 *
 * @method     ChildTranslationLanguageKeywordQuery orderByLanguageId($order = Criteria::ASC) Order by the language_id column
 * @method     ChildTranslationLanguageKeywordQuery orderByKeywordId($order = Criteria::ASC) Order by the keyword_id column
 * @method     ChildTranslationLanguageKeywordQuery orderByTranslation($order = Criteria::ASC) Order by the translation column
 * @method     ChildTranslationLanguageKeywordQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildTranslationLanguageKeywordQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildTranslationLanguageKeywordQuery groupByLanguageId() Group by the language_id column
 * @method     ChildTranslationLanguageKeywordQuery groupByKeywordId() Group by the keyword_id column
 * @method     ChildTranslationLanguageKeywordQuery groupByTranslation() Group by the translation column
 * @method     ChildTranslationLanguageKeywordQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildTranslationLanguageKeywordQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildTranslationLanguageKeywordQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTranslationLanguageKeywordQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTranslationLanguageKeywordQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTranslationLanguageKeywordQuery leftJoinTranslationLanguage($relationAlias = null) Adds a LEFT JOIN clause to the query using the TranslationLanguage relation
 * @method     ChildTranslationLanguageKeywordQuery rightJoinTranslationLanguage($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TranslationLanguage relation
 * @method     ChildTranslationLanguageKeywordQuery innerJoinTranslationLanguage($relationAlias = null) Adds a INNER JOIN clause to the query using the TranslationLanguage relation
 *
 * @method     ChildTranslationLanguageKeywordQuery leftJoinTranslationKeyword($relationAlias = null) Adds a LEFT JOIN clause to the query using the TranslationKeyword relation
 * @method     ChildTranslationLanguageKeywordQuery rightJoinTranslationKeyword($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TranslationKeyword relation
 * @method     ChildTranslationLanguageKeywordQuery innerJoinTranslationKeyword($relationAlias = null) Adds a INNER JOIN clause to the query using the TranslationKeyword relation
 *
 * @method     \App\Models\TranslationLanguageQuery|\App\Models\TranslationKeywordQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTranslationLanguageKeyword findOne(ConnectionInterface $con = null) Return the first ChildTranslationLanguageKeyword matching the query
 * @method     ChildTranslationLanguageKeyword findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTranslationLanguageKeyword matching the query, or a new ChildTranslationLanguageKeyword object populated from the query conditions when no match is found
 *
 * @method     ChildTranslationLanguageKeyword findOneByLanguageId(int $language_id) Return the first ChildTranslationLanguageKeyword filtered by the language_id column
 * @method     ChildTranslationLanguageKeyword findOneByKeywordId(int $keyword_id) Return the first ChildTranslationLanguageKeyword filtered by the keyword_id column
 * @method     ChildTranslationLanguageKeyword findOneByTranslation(string $translation) Return the first ChildTranslationLanguageKeyword filtered by the translation column
 * @method     ChildTranslationLanguageKeyword findOneByCreatedAt(string $created_at) Return the first ChildTranslationLanguageKeyword filtered by the created_at column
 * @method     ChildTranslationLanguageKeyword findOneByUpdatedAt(string $updated_at) Return the first ChildTranslationLanguageKeyword filtered by the updated_at column *

 * @method     ChildTranslationLanguageKeyword requirePk($key, ConnectionInterface $con = null) Return the ChildTranslationLanguageKeyword by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationLanguageKeyword requireOne(ConnectionInterface $con = null) Return the first ChildTranslationLanguageKeyword matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTranslationLanguageKeyword requireOneByLanguageId(int $language_id) Return the first ChildTranslationLanguageKeyword filtered by the language_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationLanguageKeyword requireOneByKeywordId(int $keyword_id) Return the first ChildTranslationLanguageKeyword filtered by the keyword_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationLanguageKeyword requireOneByTranslation(string $translation) Return the first ChildTranslationLanguageKeyword filtered by the translation column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationLanguageKeyword requireOneByCreatedAt(string $created_at) Return the first ChildTranslationLanguageKeyword filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTranslationLanguageKeyword requireOneByUpdatedAt(string $updated_at) Return the first ChildTranslationLanguageKeyword filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTranslationLanguageKeyword[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTranslationLanguageKeyword objects based on current ModelCriteria
 * @method     ChildTranslationLanguageKeyword[]|ObjectCollection findByLanguageId(int $language_id) Return ChildTranslationLanguageKeyword objects filtered by the language_id column
 * @method     ChildTranslationLanguageKeyword[]|ObjectCollection findByKeywordId(int $keyword_id) Return ChildTranslationLanguageKeyword objects filtered by the keyword_id column
 * @method     ChildTranslationLanguageKeyword[]|ObjectCollection findByTranslation(string $translation) Return ChildTranslationLanguageKeyword objects filtered by the translation column
 * @method     ChildTranslationLanguageKeyword[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildTranslationLanguageKeyword objects filtered by the created_at column
 * @method     ChildTranslationLanguageKeyword[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildTranslationLanguageKeyword objects filtered by the updated_at column
 * @method     ChildTranslationLanguageKeyword[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TranslationLanguageKeywordQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \App\Models\Base\TranslationLanguageKeywordQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\App\\Models\\TranslationLanguageKeyword', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTranslationLanguageKeywordQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTranslationLanguageKeywordQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTranslationLanguageKeywordQuery) {
            return $criteria;
        }
        $query = new ChildTranslationLanguageKeywordQuery();
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
     * @param array[$language_id, $keyword_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildTranslationLanguageKeyword|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TranslationLanguageKeywordTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TranslationLanguageKeywordTableMap::DATABASE_NAME);
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
     * @return ChildTranslationLanguageKeyword A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT language_id, keyword_id, translation, created_at, updated_at FROM translation_language_keyword WHERE language_id = :p0 AND keyword_id = :p1';
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
            /** @var ChildTranslationLanguageKeyword $obj */
            $obj = new ChildTranslationLanguageKeyword();
            $obj->hydrate($row);
            TranslationLanguageKeywordTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildTranslationLanguageKeyword|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTranslationLanguageKeywordQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(TranslationLanguageKeywordTableMap::COL_LANGUAGE_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(TranslationLanguageKeywordTableMap::COL_KEYWORD_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTranslationLanguageKeywordQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(TranslationLanguageKeywordTableMap::COL_LANGUAGE_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(TranslationLanguageKeywordTableMap::COL_KEYWORD_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildTranslationLanguageKeywordQuery The current query, for fluid interface
     */
    public function filterByLanguageId($languageId = null, $comparison = null)
    {
        if (is_array($languageId)) {
            $useMinMax = false;
            if (isset($languageId['min'])) {
                $this->addUsingAlias(TranslationLanguageKeywordTableMap::COL_LANGUAGE_ID, $languageId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($languageId['max'])) {
                $this->addUsingAlias(TranslationLanguageKeywordTableMap::COL_LANGUAGE_ID, $languageId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TranslationLanguageKeywordTableMap::COL_LANGUAGE_ID, $languageId, $comparison);
    }

    /**
     * Filter the query on the keyword_id column
     *
     * Example usage:
     * <code>
     * $query->filterByKeywordId(1234); // WHERE keyword_id = 1234
     * $query->filterByKeywordId(array(12, 34)); // WHERE keyword_id IN (12, 34)
     * $query->filterByKeywordId(array('min' => 12)); // WHERE keyword_id > 12
     * </code>
     *
     * @see       filterByTranslationKeyword()
     *
     * @param     mixed $keywordId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTranslationLanguageKeywordQuery The current query, for fluid interface
     */
    public function filterByKeywordId($keywordId = null, $comparison = null)
    {
        if (is_array($keywordId)) {
            $useMinMax = false;
            if (isset($keywordId['min'])) {
                $this->addUsingAlias(TranslationLanguageKeywordTableMap::COL_KEYWORD_ID, $keywordId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($keywordId['max'])) {
                $this->addUsingAlias(TranslationLanguageKeywordTableMap::COL_KEYWORD_ID, $keywordId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TranslationLanguageKeywordTableMap::COL_KEYWORD_ID, $keywordId, $comparison);
    }

    /**
     * Filter the query on the translation column
     *
     * Example usage:
     * <code>
     * $query->filterByTranslation('fooValue');   // WHERE translation = 'fooValue'
     * $query->filterByTranslation('%fooValue%'); // WHERE translation LIKE '%fooValue%'
     * </code>
     *
     * @param     string $translation The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTranslationLanguageKeywordQuery The current query, for fluid interface
     */
    public function filterByTranslation($translation = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($translation)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $translation)) {
                $translation = str_replace('*', '%', $translation);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TranslationLanguageKeywordTableMap::COL_TRANSLATION, $translation, $comparison);
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
     * @return $this|ChildTranslationLanguageKeywordQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(TranslationLanguageKeywordTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(TranslationLanguageKeywordTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TranslationLanguageKeywordTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildTranslationLanguageKeywordQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(TranslationLanguageKeywordTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(TranslationLanguageKeywordTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TranslationLanguageKeywordTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \App\Models\TranslationLanguage object
     *
     * @param \App\Models\TranslationLanguage|ObjectCollection $translationLanguage The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTranslationLanguageKeywordQuery The current query, for fluid interface
     */
    public function filterByTranslationLanguage($translationLanguage, $comparison = null)
    {
        if ($translationLanguage instanceof \App\Models\TranslationLanguage) {
            return $this
                ->addUsingAlias(TranslationLanguageKeywordTableMap::COL_LANGUAGE_ID, $translationLanguage->getId(), $comparison);
        } elseif ($translationLanguage instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TranslationLanguageKeywordTableMap::COL_LANGUAGE_ID, $translationLanguage->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildTranslationLanguageKeywordQuery The current query, for fluid interface
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
     * Filter the query by a related \App\Models\TranslationKeyword object
     *
     * @param \App\Models\TranslationKeyword|ObjectCollection $translationKeyword The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTranslationLanguageKeywordQuery The current query, for fluid interface
     */
    public function filterByTranslationKeyword($translationKeyword, $comparison = null)
    {
        if ($translationKeyword instanceof \App\Models\TranslationKeyword) {
            return $this
                ->addUsingAlias(TranslationLanguageKeywordTableMap::COL_KEYWORD_ID, $translationKeyword->getId(), $comparison);
        } elseif ($translationKeyword instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TranslationLanguageKeywordTableMap::COL_KEYWORD_ID, $translationKeyword->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByTranslationKeyword() only accepts arguments of type \App\Models\TranslationKeyword or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TranslationKeyword relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTranslationLanguageKeywordQuery The current query, for fluid interface
     */
    public function joinTranslationKeyword($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TranslationKeyword');

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
            $this->addJoinObject($join, 'TranslationKeyword');
        }

        return $this;
    }

    /**
     * Use the TranslationKeyword relation TranslationKeyword object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \App\Models\TranslationKeywordQuery A secondary query class using the current class as primary query
     */
    public function useTranslationKeywordQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTranslationKeyword($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TranslationKeyword', '\App\Models\TranslationKeywordQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTranslationLanguageKeyword $translationLanguageKeyword Object to remove from the list of results
     *
     * @return $this|ChildTranslationLanguageKeywordQuery The current query, for fluid interface
     */
    public function prune($translationLanguageKeyword = null)
    {
        if ($translationLanguageKeyword) {
            $this->addCond('pruneCond0', $this->getAliasedColName(TranslationLanguageKeywordTableMap::COL_LANGUAGE_ID), $translationLanguageKeyword->getLanguageId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(TranslationLanguageKeywordTableMap::COL_KEYWORD_ID), $translationLanguageKeyword->getKeywordId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the translation_language_keyword table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TranslationLanguageKeywordTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TranslationLanguageKeywordTableMap::clearInstancePool();
            TranslationLanguageKeywordTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TranslationLanguageKeywordTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TranslationLanguageKeywordTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TranslationLanguageKeywordTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TranslationLanguageKeywordTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildTranslationLanguageKeywordQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(TranslationLanguageKeywordTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildTranslationLanguageKeywordQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(TranslationLanguageKeywordTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildTranslationLanguageKeywordQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(TranslationLanguageKeywordTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildTranslationLanguageKeywordQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(TranslationLanguageKeywordTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildTranslationLanguageKeywordQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(TranslationLanguageKeywordTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildTranslationLanguageKeywordQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(TranslationLanguageKeywordTableMap::COL_CREATED_AT);
    }

} // TranslationLanguageKeywordQuery
