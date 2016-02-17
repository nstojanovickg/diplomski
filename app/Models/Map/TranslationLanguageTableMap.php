<?php

namespace App\Models\Map;

use App\Models\TranslationLanguage;
use App\Models\TranslationLanguageQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'translation_language' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TranslationLanguageTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.TranslationLanguageTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'translation_language';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Models\\TranslationLanguage';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'TranslationLanguage';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id field
     */
    const COL_ID = 'translation_language.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'translation_language.name';

    /**
     * the column name for the culture field
     */
    const COL_CULTURE = 'translation_language.culture';

    /**
     * the column name for the locale field
     */
    const COL_LOCALE = 'translation_language.locale';

    /**
     * the column name for the is_active field
     */
    const COL_IS_ACTIVE = 'translation_language.is_active';

    /**
     * the column name for the is_default field
     */
    const COL_IS_DEFAULT = 'translation_language.is_default';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'translation_language.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'translation_language.updated_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Culture', 'Locale', 'IsActive', 'IsDefault', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'culture', 'locale', 'isActive', 'isDefault', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(TranslationLanguageTableMap::COL_ID, TranslationLanguageTableMap::COL_NAME, TranslationLanguageTableMap::COL_CULTURE, TranslationLanguageTableMap::COL_LOCALE, TranslationLanguageTableMap::COL_IS_ACTIVE, TranslationLanguageTableMap::COL_IS_DEFAULT, TranslationLanguageTableMap::COL_CREATED_AT, TranslationLanguageTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'culture', 'locale', 'is_active', 'is_default', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Culture' => 2, 'Locale' => 3, 'IsActive' => 4, 'IsDefault' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'culture' => 2, 'locale' => 3, 'isActive' => 4, 'isDefault' => 5, 'createdAt' => 6, 'updatedAt' => 7, ),
        self::TYPE_COLNAME       => array(TranslationLanguageTableMap::COL_ID => 0, TranslationLanguageTableMap::COL_NAME => 1, TranslationLanguageTableMap::COL_CULTURE => 2, TranslationLanguageTableMap::COL_LOCALE => 3, TranslationLanguageTableMap::COL_IS_ACTIVE => 4, TranslationLanguageTableMap::COL_IS_DEFAULT => 5, TranslationLanguageTableMap::COL_CREATED_AT => 6, TranslationLanguageTableMap::COL_UPDATED_AT => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'culture' => 2, 'locale' => 3, 'is_active' => 4, 'is_default' => 5, 'created_at' => 6, 'updated_at' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('translation_language');
        $this->setPhpName('TranslationLanguage');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Models\\TranslationLanguage');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('culture', 'Culture', 'VARCHAR', true, 7, null);
        $this->addColumn('locale', 'Locale', 'VARCHAR', true, 7, null);
        $this->addColumn('is_active', 'IsActive', 'INTEGER', false, 4, 0);
        $this->addColumn('is_default', 'IsDefault', 'INTEGER', false, 4, 0);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('AdminUser', '\\App\\Models\\AdminUser', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':language_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'AdminUsers', false);
        $this->addRelation('TranslationLanguageKeyword', '\\App\\Models\\TranslationLanguageKeyword', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':language_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'TranslationLanguageKeywords', false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to translation_language     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AdminUserTableMap::clearInstancePool();
        TranslationLanguageKeywordTableMap::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? TranslationLanguageTableMap::CLASS_DEFAULT : TranslationLanguageTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (TranslationLanguage object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TranslationLanguageTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TranslationLanguageTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TranslationLanguageTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TranslationLanguageTableMap::OM_CLASS;
            /** @var TranslationLanguage $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TranslationLanguageTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = TranslationLanguageTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TranslationLanguageTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var TranslationLanguage $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TranslationLanguageTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(TranslationLanguageTableMap::COL_ID);
            $criteria->addSelectColumn(TranslationLanguageTableMap::COL_NAME);
            $criteria->addSelectColumn(TranslationLanguageTableMap::COL_CULTURE);
            $criteria->addSelectColumn(TranslationLanguageTableMap::COL_LOCALE);
            $criteria->addSelectColumn(TranslationLanguageTableMap::COL_IS_ACTIVE);
            $criteria->addSelectColumn(TranslationLanguageTableMap::COL_IS_DEFAULT);
            $criteria->addSelectColumn(TranslationLanguageTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(TranslationLanguageTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.culture');
            $criteria->addSelectColumn($alias . '.locale');
            $criteria->addSelectColumn($alias . '.is_active');
            $criteria->addSelectColumn($alias . '.is_default');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(TranslationLanguageTableMap::DATABASE_NAME)->getTable(TranslationLanguageTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TranslationLanguageTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TranslationLanguageTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TranslationLanguageTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a TranslationLanguage or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or TranslationLanguage object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TranslationLanguageTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Models\TranslationLanguage) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TranslationLanguageTableMap::DATABASE_NAME);
            $criteria->add(TranslationLanguageTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = TranslationLanguageQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TranslationLanguageTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TranslationLanguageTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the translation_language table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TranslationLanguageQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a TranslationLanguage or Criteria object.
     *
     * @param mixed               $criteria Criteria or TranslationLanguage object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TranslationLanguageTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from TranslationLanguage object
        }

        if ($criteria->containsKey(TranslationLanguageTableMap::COL_ID) && $criteria->keyContainsValue(TranslationLanguageTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TranslationLanguageTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = TranslationLanguageQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TranslationLanguageTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TranslationLanguageTableMap::buildTableMap();
