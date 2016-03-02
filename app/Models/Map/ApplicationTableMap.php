<?php

namespace App\Models\Map;

use App\Models\Application;
use App\Models\ApplicationQuery;
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
 * This class defines the structure of the 'application' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ApplicationTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ApplicationTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'application';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\App\\Models\\Application';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Application';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the id field
     */
    const COL_ID = 'application.id';

    /**
     * the column name for the student_id field
     */
    const COL_STUDENT_ID = 'application.student_id';

    /**
     * the column name for the subject_id field
     */
    const COL_SUBJECT_ID = 'application.subject_id';

    /**
     * the column name for the period_id field
     */
    const COL_PERIOD_ID = 'application.period_id';

    /**
     * the column name for the school_year_id field
     */
    const COL_SCHOOL_YEAR_ID = 'application.school_year_id';

    /**
     * the column name for the application_date field
     */
    const COL_APPLICATION_DATE = 'application.application_date';

    /**
     * the column name for the exam_date field
     */
    const COL_EXAM_DATE = 'application.exam_date';

    /**
     * the column name for the exam_time field
     */
    const COL_EXAM_TIME = 'application.exam_time';

    /**
     * the column name for the exam_score field
     */
    const COL_EXAM_SCORE = 'application.exam_score';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'application.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'application.updated_at';

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
        self::TYPE_PHPNAME       => array('Id', 'StudentId', 'SubjectId', 'PeriodId', 'SchoolYearId', 'ApplicationDate', 'ExamDate', 'ExamTime', 'ExamScore', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'studentId', 'subjectId', 'periodId', 'schoolYearId', 'applicationDate', 'examDate', 'examTime', 'examScore', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(ApplicationTableMap::COL_ID, ApplicationTableMap::COL_STUDENT_ID, ApplicationTableMap::COL_SUBJECT_ID, ApplicationTableMap::COL_PERIOD_ID, ApplicationTableMap::COL_SCHOOL_YEAR_ID, ApplicationTableMap::COL_APPLICATION_DATE, ApplicationTableMap::COL_EXAM_DATE, ApplicationTableMap::COL_EXAM_TIME, ApplicationTableMap::COL_EXAM_SCORE, ApplicationTableMap::COL_CREATED_AT, ApplicationTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'student_id', 'subject_id', 'period_id', 'school_year_id', 'application_date', 'exam_date', 'exam_time', 'exam_score', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'StudentId' => 1, 'SubjectId' => 2, 'PeriodId' => 3, 'SchoolYearId' => 4, 'ApplicationDate' => 5, 'ExamDate' => 6, 'ExamTime' => 7, 'ExamScore' => 8, 'CreatedAt' => 9, 'UpdatedAt' => 10, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'studentId' => 1, 'subjectId' => 2, 'periodId' => 3, 'schoolYearId' => 4, 'applicationDate' => 5, 'examDate' => 6, 'examTime' => 7, 'examScore' => 8, 'createdAt' => 9, 'updatedAt' => 10, ),
        self::TYPE_COLNAME       => array(ApplicationTableMap::COL_ID => 0, ApplicationTableMap::COL_STUDENT_ID => 1, ApplicationTableMap::COL_SUBJECT_ID => 2, ApplicationTableMap::COL_PERIOD_ID => 3, ApplicationTableMap::COL_SCHOOL_YEAR_ID => 4, ApplicationTableMap::COL_APPLICATION_DATE => 5, ApplicationTableMap::COL_EXAM_DATE => 6, ApplicationTableMap::COL_EXAM_TIME => 7, ApplicationTableMap::COL_EXAM_SCORE => 8, ApplicationTableMap::COL_CREATED_AT => 9, ApplicationTableMap::COL_UPDATED_AT => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'student_id' => 1, 'subject_id' => 2, 'period_id' => 3, 'school_year_id' => 4, 'application_date' => 5, 'exam_date' => 6, 'exam_time' => 7, 'exam_score' => 8, 'created_at' => 9, 'updated_at' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('application');
        $this->setPhpName('Application');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\App\\Models\\Application');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('student_id', 'StudentId', 'INTEGER', 'student', 'id', true, null, null);
        $this->addForeignKey('subject_id', 'SubjectId', 'INTEGER', 'subject', 'id', true, null, null);
        $this->addForeignKey('period_id', 'PeriodId', 'INTEGER', 'period', 'id', true, null, null);
        $this->addForeignKey('school_year_id', 'SchoolYearId', 'INTEGER', 'school_year', 'id', true, null, null);
        $this->addColumn('application_date', 'ApplicationDate', 'DATE', true, null, null);
        $this->addColumn('exam_date', 'ExamDate', 'DATE', false, null, null);
        $this->addColumn('exam_time', 'ExamTime', 'TIME', false, null, '09:00:00');
        $this->addColumn('exam_score', 'ExamScore', 'INTEGER', false, 2, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
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
        $this->addRelation('SchoolYear', '\\App\\Models\\SchoolYear', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':school_year_id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
        $this->addRelation('ApplicationRequest', '\\App\\Models\\ApplicationRequest', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':application_id',
    1 => ':id',
  ),
), null, null, 'ApplicationRequests', false);
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
        return $withPrefix ? ApplicationTableMap::CLASS_DEFAULT : ApplicationTableMap::OM_CLASS;
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
     * @return array           (Application object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ApplicationTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ApplicationTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ApplicationTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ApplicationTableMap::OM_CLASS;
            /** @var Application $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ApplicationTableMap::addInstanceToPool($obj, $key);
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
            $key = ApplicationTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ApplicationTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Application $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ApplicationTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ApplicationTableMap::COL_ID);
            $criteria->addSelectColumn(ApplicationTableMap::COL_STUDENT_ID);
            $criteria->addSelectColumn(ApplicationTableMap::COL_SUBJECT_ID);
            $criteria->addSelectColumn(ApplicationTableMap::COL_PERIOD_ID);
            $criteria->addSelectColumn(ApplicationTableMap::COL_SCHOOL_YEAR_ID);
            $criteria->addSelectColumn(ApplicationTableMap::COL_APPLICATION_DATE);
            $criteria->addSelectColumn(ApplicationTableMap::COL_EXAM_DATE);
            $criteria->addSelectColumn(ApplicationTableMap::COL_EXAM_TIME);
            $criteria->addSelectColumn(ApplicationTableMap::COL_EXAM_SCORE);
            $criteria->addSelectColumn(ApplicationTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(ApplicationTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.student_id');
            $criteria->addSelectColumn($alias . '.subject_id');
            $criteria->addSelectColumn($alias . '.period_id');
            $criteria->addSelectColumn($alias . '.school_year_id');
            $criteria->addSelectColumn($alias . '.application_date');
            $criteria->addSelectColumn($alias . '.exam_date');
            $criteria->addSelectColumn($alias . '.exam_time');
            $criteria->addSelectColumn($alias . '.exam_score');
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
        return Propel::getServiceContainer()->getDatabaseMap(ApplicationTableMap::DATABASE_NAME)->getTable(ApplicationTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ApplicationTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ApplicationTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ApplicationTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Application or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Application object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ApplicationTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \App\Models\Application) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ApplicationTableMap::DATABASE_NAME);
            $criteria->add(ApplicationTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ApplicationQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ApplicationTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ApplicationTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the application table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ApplicationQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Application or Criteria object.
     *
     * @param mixed               $criteria Criteria or Application object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ApplicationTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Application object
        }

        if ($criteria->containsKey(ApplicationTableMap::COL_ID) && $criteria->keyContainsValue(ApplicationTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ApplicationTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ApplicationQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ApplicationTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ApplicationTableMap::buildTableMap();
