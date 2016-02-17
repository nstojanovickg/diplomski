<?php

namespace App\Models\Map;

use App\Models\Student;
use App\Models\StudentQuery;
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
 * This class defines the structure of the 'student' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class StudentTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.StudentTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'student';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Models\\Student';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Student';

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
    const COL_ID = 'student.id';

    /**
     * the column name for the identification_number field
     */
    const COL_IDENTIFICATION_NUMBER = 'student.identification_number';

    /**
     * the column name for the school_year_id field
     */
    const COL_SCHOOL_YEAR_ID = 'student.school_year_id';

    /**
     * the column name for the course_id field
     */
    const COL_COURSE_ID = 'student.course_id';

    /**
     * the column name for the first_name field
     */
    const COL_FIRST_NAME = 'student.first_name';

    /**
     * the column name for the last_name field
     */
    const COL_LAST_NAME = 'student.last_name';

    /**
     * the column name for the birth_place field
     */
    const COL_BIRTH_PLACE = 'student.birth_place';

    /**
     * the column name for the birthday field
     */
    const COL_BIRTHDAY = 'student.birthday';

    /**
     * the column name for the account_amount field
     */
    const COL_ACCOUNT_AMOUNT = 'student.account_amount';

    /**
     * the column name for the phone_number field
     */
    const COL_PHONE_NUMBER = 'student.phone_number';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'student.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'student.updated_at';

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
        self::TYPE_PHPNAME       => array('Id', 'IdentificationNumber', 'SchoolYearId', 'CourseId', 'FirstName', 'LastName', 'BirthPlace', 'Birthday', 'AccountAmount', 'PhoneNumber', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'identificationNumber', 'schoolYearId', 'courseId', 'firstName', 'lastName', 'birthPlace', 'birthday', 'accountAmount', 'phoneNumber', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(StudentTableMap::COL_ID, StudentTableMap::COL_IDENTIFICATION_NUMBER, StudentTableMap::COL_SCHOOL_YEAR_ID, StudentTableMap::COL_COURSE_ID, StudentTableMap::COL_FIRST_NAME, StudentTableMap::COL_LAST_NAME, StudentTableMap::COL_BIRTH_PLACE, StudentTableMap::COL_BIRTHDAY, StudentTableMap::COL_ACCOUNT_AMOUNT, StudentTableMap::COL_PHONE_NUMBER, StudentTableMap::COL_CREATED_AT, StudentTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'identification_number', 'school_year_id', 'course_id', 'first_name', 'last_name', 'birth_place', 'birthday', 'account_amount', 'phone_number', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'IdentificationNumber' => 1, 'SchoolYearId' => 2, 'CourseId' => 3, 'FirstName' => 4, 'LastName' => 5, 'BirthPlace' => 6, 'Birthday' => 7, 'AccountAmount' => 8, 'PhoneNumber' => 9, 'CreatedAt' => 10, 'UpdatedAt' => 11, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'identificationNumber' => 1, 'schoolYearId' => 2, 'courseId' => 3, 'firstName' => 4, 'lastName' => 5, 'birthPlace' => 6, 'birthday' => 7, 'accountAmount' => 8, 'phoneNumber' => 9, 'createdAt' => 10, 'updatedAt' => 11, ),
        self::TYPE_COLNAME       => array(StudentTableMap::COL_ID => 0, StudentTableMap::COL_IDENTIFICATION_NUMBER => 1, StudentTableMap::COL_SCHOOL_YEAR_ID => 2, StudentTableMap::COL_COURSE_ID => 3, StudentTableMap::COL_FIRST_NAME => 4, StudentTableMap::COL_LAST_NAME => 5, StudentTableMap::COL_BIRTH_PLACE => 6, StudentTableMap::COL_BIRTHDAY => 7, StudentTableMap::COL_ACCOUNT_AMOUNT => 8, StudentTableMap::COL_PHONE_NUMBER => 9, StudentTableMap::COL_CREATED_AT => 10, StudentTableMap::COL_UPDATED_AT => 11, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'identification_number' => 1, 'school_year_id' => 2, 'course_id' => 3, 'first_name' => 4, 'last_name' => 5, 'birth_place' => 6, 'birthday' => 7, 'account_amount' => 8, 'phone_number' => 9, 'created_at' => 10, 'updated_at' => 11, ),
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
        $this->setName('student');
        $this->setPhpName('Student');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Models\\Student');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('identification_number', 'IdentificationNumber', 'INTEGER', true, null, null);
        $this->addForeignKey('school_year_id', 'SchoolYearId', 'INTEGER', 'school_year', 'id', true, null, null);
        $this->addForeignKey('course_id', 'CourseId', 'INTEGER', 'course', 'id', true, null, null);
        $this->addColumn('first_name', 'FirstName', 'VARCHAR', true, 100, null);
        $this->addColumn('last_name', 'LastName', 'VARCHAR', true, 100, null);
        $this->addColumn('birth_place', 'BirthPlace', 'VARCHAR', true, 100, null);
        $this->addColumn('birthday', 'Birthday', 'DATE', false, null, null);
        $this->addColumn('account_amount', 'AccountAmount', 'FLOAT', false, 6, 0);
        $this->addColumn('phone_number', 'PhoneNumber', 'VARCHAR', true, 20, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Course', '\\App\\Models\\Course', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':course_id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
        $this->addRelation('SchoolYear', '\\App\\Models\\SchoolYear', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':school_year_id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
        $this->addRelation('AdminUser', '\\App\\Models\\AdminUser', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':student_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'AdminUsers', false);
        $this->addRelation('Application', '\\App\\Models\\Application', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':student_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'Applications', false);
        $this->addRelation('SmsCallLog', '\\App\\Models\\SmsCallLog', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':student_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'SmsCallLogs', false);
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
     * Method to invalidate the instance pool of all tables related to student     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AdminUserTableMap::clearInstancePool();
        ApplicationTableMap::clearInstancePool();
        SmsCallLogTableMap::clearInstancePool();
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
        return $withPrefix ? StudentTableMap::CLASS_DEFAULT : StudentTableMap::OM_CLASS;
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
     * @return array           (Student object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = StudentTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = StudentTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + StudentTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = StudentTableMap::OM_CLASS;
            /** @var Student $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            StudentTableMap::addInstanceToPool($obj, $key);
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
            $key = StudentTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = StudentTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Student $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                StudentTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(StudentTableMap::COL_ID);
            $criteria->addSelectColumn(StudentTableMap::COL_IDENTIFICATION_NUMBER);
            $criteria->addSelectColumn(StudentTableMap::COL_SCHOOL_YEAR_ID);
            $criteria->addSelectColumn(StudentTableMap::COL_COURSE_ID);
            $criteria->addSelectColumn(StudentTableMap::COL_FIRST_NAME);
            $criteria->addSelectColumn(StudentTableMap::COL_LAST_NAME);
            $criteria->addSelectColumn(StudentTableMap::COL_BIRTH_PLACE);
            $criteria->addSelectColumn(StudentTableMap::COL_BIRTHDAY);
            $criteria->addSelectColumn(StudentTableMap::COL_ACCOUNT_AMOUNT);
            $criteria->addSelectColumn(StudentTableMap::COL_PHONE_NUMBER);
            $criteria->addSelectColumn(StudentTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(StudentTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.identification_number');
            $criteria->addSelectColumn($alias . '.school_year_id');
            $criteria->addSelectColumn($alias . '.course_id');
            $criteria->addSelectColumn($alias . '.first_name');
            $criteria->addSelectColumn($alias . '.last_name');
            $criteria->addSelectColumn($alias . '.birth_place');
            $criteria->addSelectColumn($alias . '.birthday');
            $criteria->addSelectColumn($alias . '.account_amount');
            $criteria->addSelectColumn($alias . '.phone_number');
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
        return Propel::getServiceContainer()->getDatabaseMap(StudentTableMap::DATABASE_NAME)->getTable(StudentTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(StudentTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(StudentTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new StudentTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Student or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Student object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(StudentTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Models\Student) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(StudentTableMap::DATABASE_NAME);
            $criteria->add(StudentTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = StudentQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            StudentTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                StudentTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the student table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return StudentQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Student or Criteria object.
     *
     * @param mixed               $criteria Criteria or Student object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StudentTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Student object
        }

        if ($criteria->containsKey(StudentTableMap::COL_ID) && $criteria->keyContainsValue(StudentTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.StudentTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = StudentQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // StudentTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
StudentTableMap::buildTableMap();
