<?php

namespace App\Models\Map;

use App\Models\SmsCallLog;
use App\Models\SmsCallLogQuery;
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
 * This class defines the structure of the 'sms_call_log' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SmsCallLogTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.SmsCallLogTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'sms_call_log';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Models\\SmsCallLog';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'SmsCallLog';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the id field
     */
    const COL_ID = 'sms_call_log.id';

    /**
     * the column name for the student_id field
     */
    const COL_STUDENT_ID = 'sms_call_log.student_id';

    /**
     * the column name for the subject_id field
     */
    const COL_SUBJECT_ID = 'sms_call_log.subject_id';

    /**
     * the column name for the period_id field
     */
    const COL_PERIOD_ID = 'sms_call_log.period_id';

    /**
     * the column name for the application_date field
     */
    const COL_APPLICATION_DATE = 'sms_call_log.application_date';

    /**
     * the column name for the is_success field
     */
    const COL_IS_SUCCESS = 'sms_call_log.is_success';

    /**
     * the column name for the application_request_id field
     */
    const COL_APPLICATION_REQUEST_ID = 'sms_call_log.application_request_id';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'sms_call_log.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'sms_call_log.updated_at';

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
        self::TYPE_PHPNAME       => array('Id', 'StudentId', 'SubjectId', 'PeriodId', 'ApplicationDate', 'IsSuccess', 'ApplicationRequestId', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'studentId', 'subjectId', 'periodId', 'applicationDate', 'isSuccess', 'applicationRequestId', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(SmsCallLogTableMap::COL_ID, SmsCallLogTableMap::COL_STUDENT_ID, SmsCallLogTableMap::COL_SUBJECT_ID, SmsCallLogTableMap::COL_PERIOD_ID, SmsCallLogTableMap::COL_APPLICATION_DATE, SmsCallLogTableMap::COL_IS_SUCCESS, SmsCallLogTableMap::COL_APPLICATION_REQUEST_ID, SmsCallLogTableMap::COL_CREATED_AT, SmsCallLogTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'student_id', 'subject_id', 'period_id', 'application_date', 'is_success', 'application_request_id', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'StudentId' => 1, 'SubjectId' => 2, 'PeriodId' => 3, 'ApplicationDate' => 4, 'IsSuccess' => 5, 'ApplicationRequestId' => 6, 'CreatedAt' => 7, 'UpdatedAt' => 8, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'studentId' => 1, 'subjectId' => 2, 'periodId' => 3, 'applicationDate' => 4, 'isSuccess' => 5, 'applicationRequestId' => 6, 'createdAt' => 7, 'updatedAt' => 8, ),
        self::TYPE_COLNAME       => array(SmsCallLogTableMap::COL_ID => 0, SmsCallLogTableMap::COL_STUDENT_ID => 1, SmsCallLogTableMap::COL_SUBJECT_ID => 2, SmsCallLogTableMap::COL_PERIOD_ID => 3, SmsCallLogTableMap::COL_APPLICATION_DATE => 4, SmsCallLogTableMap::COL_IS_SUCCESS => 5, SmsCallLogTableMap::COL_APPLICATION_REQUEST_ID => 6, SmsCallLogTableMap::COL_CREATED_AT => 7, SmsCallLogTableMap::COL_UPDATED_AT => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'student_id' => 1, 'subject_id' => 2, 'period_id' => 3, 'application_date' => 4, 'is_success' => 5, 'application_request_id' => 6, 'created_at' => 7, 'updated_at' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $this->setName('sms_call_log');
        $this->setPhpName('SmsCallLog');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Models\\SmsCallLog');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('student_id', 'StudentId', 'INTEGER', 'student', 'id', true, null, null);
        $this->addForeignKey('subject_id', 'SubjectId', 'INTEGER', 'subject', 'id', true, null, null);
        $this->addForeignKey('period_id', 'PeriodId', 'INTEGER', 'period', 'id', true, null, null);
        $this->addColumn('application_date', 'ApplicationDate', 'DATE', true, null, null);
        $this->addColumn('is_success', 'IsSuccess', 'INTEGER', false, 4, 0);
        $this->addForeignKey('application_request_id', 'ApplicationRequestId', 'INTEGER', 'application_request', 'id', true, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('ApplicationRequest', '\\App\\Models\\ApplicationRequest', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':application_request_id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
        $this->addRelation('Period', '\\App\\Models\\Period', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':period_id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
        $this->addRelation('Subject', '\\App\\Models\\Subject', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':subject_id',
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
        return $withPrefix ? SmsCallLogTableMap::CLASS_DEFAULT : SmsCallLogTableMap::OM_CLASS;
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
     * @return array           (SmsCallLog object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SmsCallLogTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SmsCallLogTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SmsCallLogTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SmsCallLogTableMap::OM_CLASS;
            /** @var SmsCallLog $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SmsCallLogTableMap::addInstanceToPool($obj, $key);
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
            $key = SmsCallLogTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SmsCallLogTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var SmsCallLog $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SmsCallLogTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SmsCallLogTableMap::COL_ID);
            $criteria->addSelectColumn(SmsCallLogTableMap::COL_STUDENT_ID);
            $criteria->addSelectColumn(SmsCallLogTableMap::COL_SUBJECT_ID);
            $criteria->addSelectColumn(SmsCallLogTableMap::COL_PERIOD_ID);
            $criteria->addSelectColumn(SmsCallLogTableMap::COL_APPLICATION_DATE);
            $criteria->addSelectColumn(SmsCallLogTableMap::COL_IS_SUCCESS);
            $criteria->addSelectColumn(SmsCallLogTableMap::COL_APPLICATION_REQUEST_ID);
            $criteria->addSelectColumn(SmsCallLogTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(SmsCallLogTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.student_id');
            $criteria->addSelectColumn($alias . '.subject_id');
            $criteria->addSelectColumn($alias . '.period_id');
            $criteria->addSelectColumn($alias . '.application_date');
            $criteria->addSelectColumn($alias . '.is_success');
            $criteria->addSelectColumn($alias . '.application_request_id');
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
        return Propel::getServiceContainer()->getDatabaseMap(SmsCallLogTableMap::DATABASE_NAME)->getTable(SmsCallLogTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SmsCallLogTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SmsCallLogTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SmsCallLogTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a SmsCallLog or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or SmsCallLog object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SmsCallLogTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Models\SmsCallLog) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SmsCallLogTableMap::DATABASE_NAME);
            $criteria->add(SmsCallLogTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = SmsCallLogQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SmsCallLogTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SmsCallLogTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the sms_call_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SmsCallLogQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a SmsCallLog or Criteria object.
     *
     * @param mixed               $criteria Criteria or SmsCallLog object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SmsCallLogTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from SmsCallLog object
        }

        if ($criteria->containsKey(SmsCallLogTableMap::COL_ID) && $criteria->keyContainsValue(SmsCallLogTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.SmsCallLogTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = SmsCallLogQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SmsCallLogTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SmsCallLogTableMap::buildTableMap();
