<?php

namespace App\Models\Map;

use App\Models\AdminUser;
use App\Models\AdminUserQuery;
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
 * This class defines the structure of the 'admin_user' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AdminUserTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.AdminUserTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'admin_user';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Models\\AdminUser';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'AdminUser';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 12;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 12;

    /**
     * the column name for the id field
     */
    const COL_ID = 'admin_user.id';

    /**
     * the column name for the language_id field
     */
    const COL_LANGUAGE_ID = 'admin_user.language_id';

    /**
     * the column name for the professor_id field
     */
    const COL_PROFESSOR_ID = 'admin_user.professor_id';

    /**
     * the column name for the student_id field
     */
    const COL_STUDENT_ID = 'admin_user.student_id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'admin_user.name';

    /**
     * the column name for the login field
     */
    const COL_LOGIN = 'admin_user.login';

    /**
     * the column name for the password field
     */
    const COL_PASSWORD = 'admin_user.password';

    /**
     * the column name for the email field
     */
    const COL_EMAIL = 'admin_user.email';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'admin_user.status';

    /**
     * the column name for the remember_token field
     */
    const COL_REMEMBER_TOKEN = 'admin_user.remember_token';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'admin_user.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'admin_user.updated_at';

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
        self::TYPE_PHPNAME       => array('Id', 'LanguageId', 'ProfessorId', 'StudentId', 'Name', 'Login', 'Password', 'Email', 'Status', 'RememberToken', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'languageId', 'professorId', 'studentId', 'name', 'login', 'password', 'email', 'status', 'rememberToken', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(AdminUserTableMap::COL_ID, AdminUserTableMap::COL_LANGUAGE_ID, AdminUserTableMap::COL_PROFESSOR_ID, AdminUserTableMap::COL_STUDENT_ID, AdminUserTableMap::COL_NAME, AdminUserTableMap::COL_LOGIN, AdminUserTableMap::COL_PASSWORD, AdminUserTableMap::COL_EMAIL, AdminUserTableMap::COL_STATUS, AdminUserTableMap::COL_REMEMBER_TOKEN, AdminUserTableMap::COL_CREATED_AT, AdminUserTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'language_id', 'professor_id', 'student_id', 'name', 'login', 'password', 'email', 'status', 'remember_token', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'LanguageId' => 1, 'ProfessorId' => 2, 'StudentId' => 3, 'Name' => 4, 'Login' => 5, 'Password' => 6, 'Email' => 7, 'Status' => 8, 'RememberToken' => 9, 'CreatedAt' => 10, 'UpdatedAt' => 11, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'languageId' => 1, 'professorId' => 2, 'studentId' => 3, 'name' => 4, 'login' => 5, 'password' => 6, 'email' => 7, 'status' => 8, 'rememberToken' => 9, 'createdAt' => 10, 'updatedAt' => 11, ),
        self::TYPE_COLNAME       => array(AdminUserTableMap::COL_ID => 0, AdminUserTableMap::COL_LANGUAGE_ID => 1, AdminUserTableMap::COL_PROFESSOR_ID => 2, AdminUserTableMap::COL_STUDENT_ID => 3, AdminUserTableMap::COL_NAME => 4, AdminUserTableMap::COL_LOGIN => 5, AdminUserTableMap::COL_PASSWORD => 6, AdminUserTableMap::COL_EMAIL => 7, AdminUserTableMap::COL_STATUS => 8, AdminUserTableMap::COL_REMEMBER_TOKEN => 9, AdminUserTableMap::COL_CREATED_AT => 10, AdminUserTableMap::COL_UPDATED_AT => 11, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'language_id' => 1, 'professor_id' => 2, 'student_id' => 3, 'name' => 4, 'login' => 5, 'password' => 6, 'email' => 7, 'status' => 8, 'remember_token' => 9, 'created_at' => 10, 'updated_at' => 11, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
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
        $this->setName('admin_user');
        $this->setPhpName('AdminUser');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Models\\AdminUser');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('language_id', 'LanguageId', 'INTEGER', 'translation_language', 'id', true, null, null);
        $this->addForeignKey('professor_id', 'ProfessorId', 'INTEGER', 'professor', 'id', false, null, null);
        $this->addForeignKey('student_id', 'StudentId', 'INTEGER', 'student', 'id', false, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 100, null);
        $this->addColumn('login', 'Login', 'VARCHAR', true, 32, null);
        $this->addColumn('password', 'Password', 'VARCHAR', true, 100, null);
        $this->addColumn('email', 'Email', 'VARCHAR', true, 50, null);
        $this->addColumn('status', 'Status', 'CHAR', true, null, 'NEW');
        $this->addColumn('remember_token', 'RememberToken', 'VARCHAR', false, 100, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Professor', '\\App\\Models\\Professor', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':professor_id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
        $this->addRelation('Student', '\\App\\Models\\Student', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':student_id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
        $this->addRelation('TranslationLanguage', '\\App\\Models\\TranslationLanguage', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':language_id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
        $this->addRelation('AdminUserCredential', '\\App\\Models\\AdminUserCredential', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':admin_user_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'AdminUserCredentials', false);
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
     * Method to invalidate the instance pool of all tables related to admin_user     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AdminUserCredentialTableMap::clearInstancePool();
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
        return $withPrefix ? AdminUserTableMap::CLASS_DEFAULT : AdminUserTableMap::OM_CLASS;
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
     * @return array           (AdminUser object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AdminUserTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AdminUserTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AdminUserTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AdminUserTableMap::OM_CLASS;
            /** @var AdminUser $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AdminUserTableMap::addInstanceToPool($obj, $key);
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
            $key = AdminUserTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AdminUserTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var AdminUser $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AdminUserTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AdminUserTableMap::COL_ID);
            $criteria->addSelectColumn(AdminUserTableMap::COL_LANGUAGE_ID);
            $criteria->addSelectColumn(AdminUserTableMap::COL_PROFESSOR_ID);
            $criteria->addSelectColumn(AdminUserTableMap::COL_STUDENT_ID);
            $criteria->addSelectColumn(AdminUserTableMap::COL_NAME);
            $criteria->addSelectColumn(AdminUserTableMap::COL_LOGIN);
            $criteria->addSelectColumn(AdminUserTableMap::COL_PASSWORD);
            $criteria->addSelectColumn(AdminUserTableMap::COL_EMAIL);
            $criteria->addSelectColumn(AdminUserTableMap::COL_STATUS);
            $criteria->addSelectColumn(AdminUserTableMap::COL_REMEMBER_TOKEN);
            $criteria->addSelectColumn(AdminUserTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(AdminUserTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.language_id');
            $criteria->addSelectColumn($alias . '.professor_id');
            $criteria->addSelectColumn($alias . '.student_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.login');
            $criteria->addSelectColumn($alias . '.password');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.remember_token');
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
        return Propel::getServiceContainer()->getDatabaseMap(AdminUserTableMap::DATABASE_NAME)->getTable(AdminUserTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(AdminUserTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(AdminUserTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new AdminUserTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a AdminUser or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or AdminUser object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AdminUserTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Models\AdminUser) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AdminUserTableMap::DATABASE_NAME);
            $criteria->add(AdminUserTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = AdminUserQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AdminUserTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AdminUserTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the admin_user table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AdminUserQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a AdminUser or Criteria object.
     *
     * @param mixed               $criteria Criteria or AdminUser object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AdminUserTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from AdminUser object
        }

        if ($criteria->containsKey(AdminUserTableMap::COL_ID) && $criteria->keyContainsValue(AdminUserTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AdminUserTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = AdminUserQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // AdminUserTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AdminUserTableMap::buildTableMap();
