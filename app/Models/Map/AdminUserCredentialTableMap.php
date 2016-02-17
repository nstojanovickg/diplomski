<?php

namespace App\Models\Map;

use App\Models\AdminUserCredential;
use App\Models\AdminUserCredentialQuery;
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
 * This class defines the structure of the 'admin_user_credential' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AdminUserCredentialTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.AdminUserCredentialTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'admin_user_credential';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Models\\AdminUserCredential';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'AdminUserCredential';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the admin_user_id field
     */
    const COL_ADMIN_USER_ID = 'admin_user_credential.admin_user_id';

    /**
     * the column name for the admin_credential_id field
     */
    const COL_ADMIN_CREDENTIAL_ID = 'admin_user_credential.admin_credential_id';

    /**
     * the column name for the perm_read field
     */
    const COL_PERM_READ = 'admin_user_credential.perm_read';

    /**
     * the column name for the perm_write field
     */
    const COL_PERM_WRITE = 'admin_user_credential.perm_write';

    /**
     * the column name for the perm_exec field
     */
    const COL_PERM_EXEC = 'admin_user_credential.perm_exec';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'admin_user_credential.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'admin_user_credential.updated_at';

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
        self::TYPE_PHPNAME       => array('AdminUserId', 'AdminCredentialId', 'PermRead', 'PermWrite', 'PermExec', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('adminUserId', 'adminCredentialId', 'permRead', 'permWrite', 'permExec', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(AdminUserCredentialTableMap::COL_ADMIN_USER_ID, AdminUserCredentialTableMap::COL_ADMIN_CREDENTIAL_ID, AdminUserCredentialTableMap::COL_PERM_READ, AdminUserCredentialTableMap::COL_PERM_WRITE, AdminUserCredentialTableMap::COL_PERM_EXEC, AdminUserCredentialTableMap::COL_CREATED_AT, AdminUserCredentialTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('admin_user_id', 'admin_credential_id', 'perm_read', 'perm_write', 'perm_exec', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('AdminUserId' => 0, 'AdminCredentialId' => 1, 'PermRead' => 2, 'PermWrite' => 3, 'PermExec' => 4, 'CreatedAt' => 5, 'UpdatedAt' => 6, ),
        self::TYPE_CAMELNAME     => array('adminUserId' => 0, 'adminCredentialId' => 1, 'permRead' => 2, 'permWrite' => 3, 'permExec' => 4, 'createdAt' => 5, 'updatedAt' => 6, ),
        self::TYPE_COLNAME       => array(AdminUserCredentialTableMap::COL_ADMIN_USER_ID => 0, AdminUserCredentialTableMap::COL_ADMIN_CREDENTIAL_ID => 1, AdminUserCredentialTableMap::COL_PERM_READ => 2, AdminUserCredentialTableMap::COL_PERM_WRITE => 3, AdminUserCredentialTableMap::COL_PERM_EXEC => 4, AdminUserCredentialTableMap::COL_CREATED_AT => 5, AdminUserCredentialTableMap::COL_UPDATED_AT => 6, ),
        self::TYPE_FIELDNAME     => array('admin_user_id' => 0, 'admin_credential_id' => 1, 'perm_read' => 2, 'perm_write' => 3, 'perm_exec' => 4, 'created_at' => 5, 'updated_at' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('admin_user_credential');
        $this->setPhpName('AdminUserCredential');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Models\\AdminUserCredential');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('admin_user_id', 'AdminUserId', 'INTEGER' , 'admin_user', 'id', true, null, null);
        $this->addForeignPrimaryKey('admin_credential_id', 'AdminCredentialId', 'INTEGER' , 'admin_credential', 'id', true, null, null);
        $this->addColumn('perm_read', 'PermRead', 'INTEGER', false, 4, 0);
        $this->addColumn('perm_write', 'PermWrite', 'INTEGER', false, 4, 0);
        $this->addColumn('perm_exec', 'PermExec', 'INTEGER', false, 4, 0);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('AdminCredential', '\\App\\Models\\AdminCredential', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':admin_credential_id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
        $this->addRelation('AdminUser', '\\App\\Models\\AdminUser', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':admin_user_id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
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
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \App\Models\AdminUserCredential $obj A \App\Models\AdminUserCredential object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize(array((string) $obj->getAdminUserId(), (string) $obj->getAdminCredentialId()));
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \App\Models\AdminUserCredential object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \App\Models\AdminUserCredential) {
                $key = serialize(array((string) $value->getAdminUserId(), (string) $value->getAdminCredentialId()));

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize(array((string) $value[0], (string) $value[1]));
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \App\Models\AdminUserCredential object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('AdminUserId', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('AdminCredentialId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize(array((string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('AdminUserId', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('AdminCredentialId', TableMap::TYPE_PHPNAME, $indexType)]));
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
            $pks = [];

        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('AdminUserId', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 1 + $offset
                : self::translateFieldName('AdminCredentialId', TableMap::TYPE_PHPNAME, $indexType)
        ];

        return $pks;
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
        return $withPrefix ? AdminUserCredentialTableMap::CLASS_DEFAULT : AdminUserCredentialTableMap::OM_CLASS;
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
     * @return array           (AdminUserCredential object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AdminUserCredentialTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AdminUserCredentialTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AdminUserCredentialTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AdminUserCredentialTableMap::OM_CLASS;
            /** @var AdminUserCredential $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AdminUserCredentialTableMap::addInstanceToPool($obj, $key);
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
            $key = AdminUserCredentialTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AdminUserCredentialTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var AdminUserCredential $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AdminUserCredentialTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AdminUserCredentialTableMap::COL_ADMIN_USER_ID);
            $criteria->addSelectColumn(AdminUserCredentialTableMap::COL_ADMIN_CREDENTIAL_ID);
            $criteria->addSelectColumn(AdminUserCredentialTableMap::COL_PERM_READ);
            $criteria->addSelectColumn(AdminUserCredentialTableMap::COL_PERM_WRITE);
            $criteria->addSelectColumn(AdminUserCredentialTableMap::COL_PERM_EXEC);
            $criteria->addSelectColumn(AdminUserCredentialTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(AdminUserCredentialTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.admin_user_id');
            $criteria->addSelectColumn($alias . '.admin_credential_id');
            $criteria->addSelectColumn($alias . '.perm_read');
            $criteria->addSelectColumn($alias . '.perm_write');
            $criteria->addSelectColumn($alias . '.perm_exec');
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
        return Propel::getServiceContainer()->getDatabaseMap(AdminUserCredentialTableMap::DATABASE_NAME)->getTable(AdminUserCredentialTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(AdminUserCredentialTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(AdminUserCredentialTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new AdminUserCredentialTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a AdminUserCredential or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or AdminUserCredential object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AdminUserCredentialTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Models\AdminUserCredential) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AdminUserCredentialTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(AdminUserCredentialTableMap::COL_ADMIN_USER_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(AdminUserCredentialTableMap::COL_ADMIN_CREDENTIAL_ID, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = AdminUserCredentialQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AdminUserCredentialTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AdminUserCredentialTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the admin_user_credential table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AdminUserCredentialQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AdminUserCredential or Criteria object.
     *
     * @param mixed               $criteria Criteria or AdminUserCredential object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AdminUserCredentialTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from AdminUserCredential object
        }


        // Set the correct dbName
        $query = AdminUserCredentialQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // AdminUserCredentialTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AdminUserCredentialTableMap::buildTableMap();
