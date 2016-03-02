<?php

namespace App\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use App\Models\Application as ChildApplication;
use App\Models\ApplicationQuery as ChildApplicationQuery;
use App\Models\Engagement as ChildEngagement;
use App\Models\EngagementQuery as ChildEngagementQuery;
use App\Models\PeriodSchoolYear as ChildPeriodSchoolYear;
use App\Models\PeriodSchoolYearQuery as ChildPeriodSchoolYearQuery;
use App\Models\SchoolYear as ChildSchoolYear;
use App\Models\SchoolYearQuery as ChildSchoolYearQuery;
use App\Models\Student as ChildStudent;
use App\Models\StudentQuery as ChildStudentQuery;
use App\Models\Map\SchoolYearTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'school_year' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class SchoolYear implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\App\\Models\\Map\\SchoolYearTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the year field.
     * @var        int
     */
    protected $year;

    /**
     * The value for the date_start field.
     * @var        \DateTime
     */
    protected $date_start;

    /**
     * The value for the date_end field.
     * @var        \DateTime
     */
    protected $date_end;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * The value for the created_at field.
     * @var        \DateTime
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * @var        \DateTime
     */
    protected $updated_at;

    /**
     * @var        ObjectCollection|ChildApplication[] Collection to store aggregation of ChildApplication objects.
     */
    protected $collApplications;
    protected $collApplicationsPartial;

    /**
     * @var        ObjectCollection|ChildEngagement[] Collection to store aggregation of ChildEngagement objects.
     */
    protected $collEngagements;
    protected $collEngagementsPartial;

    /**
     * @var        ObjectCollection|ChildPeriodSchoolYear[] Collection to store aggregation of ChildPeriodSchoolYear objects.
     */
    protected $collPeriodSchoolYears;
    protected $collPeriodSchoolYearsPartial;

    /**
     * @var        ObjectCollection|ChildStudent[] Collection to store aggregation of ChildStudent objects.
     */
    protected $collStudents;
    protected $collStudentsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildApplication[]
     */
    protected $applicationsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildEngagement[]
     */
    protected $engagementsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPeriodSchoolYear[]
     */
    protected $periodSchoolYearsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStudent[]
     */
    protected $studentsScheduledForDeletion = null;

    /**
     * Initializes internal state of App\Models\Base\SchoolYear object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>SchoolYear</code> instance.  If
     * <code>obj</code> is an instance of <code>SchoolYear</code>, delegates to
     * <code>equals(SchoolYear)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|SchoolYear The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [year] column value.
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Get the [optionally formatted] temporal [date_start] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateStart($format = 'Y-m-d')
    {
        if ($format === null) {
            return $this->date_start;
        } else {
            return $this->date_start instanceof \DateTime ? $this->date_start->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [date_end] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDateEnd($format = 'Y-m-d')
    {
        if ($format === null) {
            return $this->date_end;
        } else {
            return $this->date_end instanceof \DateTime ? $this->date_end->format($format) : null;
        }
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = 'Y-m-d H:i:s')
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTime ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = 'Y-m-d H:i:s')
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTime ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\SchoolYear The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SchoolYearTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [year] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\SchoolYear The current object (for fluent API support)
     */
    public function setYear($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->year !== $v) {
            $this->year = $v;
            $this->modifiedColumns[SchoolYearTableMap::COL_YEAR] = true;
        }

        return $this;
    } // setYear()

    /**
     * Sets the value of [date_start] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\SchoolYear The current object (for fluent API support)
     */
    public function setDateStart($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_start !== null || $dt !== null) {
            if ($this->date_start === null || $dt === null || $dt->format("Y-m-d") !== $this->date_start->format("Y-m-d")) {
                $this->date_start = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SchoolYearTableMap::COL_DATE_START] = true;
            }
        } // if either are not null

        return $this;
    } // setDateStart()

    /**
     * Sets the value of [date_end] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\SchoolYear The current object (for fluent API support)
     */
    public function setDateEnd($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date_end !== null || $dt !== null) {
            if ($this->date_end === null || $dt === null || $dt->format("Y-m-d") !== $this->date_end->format("Y-m-d")) {
                $this->date_end = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SchoolYearTableMap::COL_DATE_END] = true;
            }
        } // if either are not null

        return $this;
    } // setDateEnd()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return $this|\App\Models\SchoolYear The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[SchoolYearTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\SchoolYear The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SchoolYearTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\SchoolYear The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SchoolYearTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SchoolYearTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SchoolYearTableMap::translateFieldName('Year', TableMap::TYPE_PHPNAME, $indexType)];
            $this->year = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SchoolYearTableMap::translateFieldName('DateStart', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->date_start = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SchoolYearTableMap::translateFieldName('DateEnd', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->date_end = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SchoolYearTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SchoolYearTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SchoolYearTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = SchoolYearTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Models\\SchoolYear'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SchoolYearTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSchoolYearQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collApplications = null;

            $this->collEngagements = null;

            $this->collPeriodSchoolYears = null;

            $this->collStudents = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see SchoolYear::setDeleted()
     * @see SchoolYear::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SchoolYearTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSchoolYearQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SchoolYearTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(SchoolYearTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(SchoolYearTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(SchoolYearTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                SchoolYearTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->applicationsScheduledForDeletion !== null) {
                if (!$this->applicationsScheduledForDeletion->isEmpty()) {
                    \App\Models\ApplicationQuery::create()
                        ->filterByPrimaryKeys($this->applicationsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->applicationsScheduledForDeletion = null;
                }
            }

            if ($this->collApplications !== null) {
                foreach ($this->collApplications as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->engagementsScheduledForDeletion !== null) {
                if (!$this->engagementsScheduledForDeletion->isEmpty()) {
                    \App\Models\EngagementQuery::create()
                        ->filterByPrimaryKeys($this->engagementsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->engagementsScheduledForDeletion = null;
                }
            }

            if ($this->collEngagements !== null) {
                foreach ($this->collEngagements as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->periodSchoolYearsScheduledForDeletion !== null) {
                if (!$this->periodSchoolYearsScheduledForDeletion->isEmpty()) {
                    \App\Models\PeriodSchoolYearQuery::create()
                        ->filterByPrimaryKeys($this->periodSchoolYearsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->periodSchoolYearsScheduledForDeletion = null;
                }
            }

            if ($this->collPeriodSchoolYears !== null) {
                foreach ($this->collPeriodSchoolYears as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->studentsScheduledForDeletion !== null) {
                if (!$this->studentsScheduledForDeletion->isEmpty()) {
                    \App\Models\StudentQuery::create()
                        ->filterByPrimaryKeys($this->studentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->studentsScheduledForDeletion = null;
                }
            }

            if ($this->collStudents !== null) {
                foreach ($this->collStudents as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[SchoolYearTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SchoolYearTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SchoolYearTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SchoolYearTableMap::COL_YEAR)) {
            $modifiedColumns[':p' . $index++]  = 'year';
        }
        if ($this->isColumnModified(SchoolYearTableMap::COL_DATE_START)) {
            $modifiedColumns[':p' . $index++]  = 'date_start';
        }
        if ($this->isColumnModified(SchoolYearTableMap::COL_DATE_END)) {
            $modifiedColumns[':p' . $index++]  = 'date_end';
        }
        if ($this->isColumnModified(SchoolYearTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }
        if ($this->isColumnModified(SchoolYearTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(SchoolYearTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO school_year (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'year':
                        $stmt->bindValue($identifier, $this->year, PDO::PARAM_INT);
                        break;
                    case 'date_start':
                        $stmt->bindValue($identifier, $this->date_start ? $this->date_start->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'date_end':
                        $stmt->bindValue($identifier, $this->date_end ? $this->date_end->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'created_at':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'updated_at':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SchoolYearTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getYear();
                break;
            case 2:
                return $this->getDateStart();
                break;
            case 3:
                return $this->getDateEnd();
                break;
            case 4:
                return $this->getDescription();
                break;
            case 5:
                return $this->getCreatedAt();
                break;
            case 6:
                return $this->getUpdatedAt();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['SchoolYear'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SchoolYear'][$this->hashCode()] = true;
        $keys = SchoolYearTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getYear(),
            $keys[2] => $this->getDateStart(),
            $keys[3] => $this->getDateEnd(),
            $keys[4] => $this->getDescription(),
            $keys[5] => $this->getCreatedAt(),
            $keys[6] => $this->getUpdatedAt(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[2]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[2]];
            $result[$keys[2]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[3]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[3]];
            $result[$keys[3]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[5]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[5]];
            $result[$keys[5]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[6]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[6]];
            $result[$keys[6]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collApplications) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'applications';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'applications';
                        break;
                    default:
                        $key = 'Applications';
                }

                $result[$key] = $this->collApplications->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collEngagements) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'engagements';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'engagements';
                        break;
                    default:
                        $key = 'Engagements';
                }

                $result[$key] = $this->collEngagements->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPeriodSchoolYears) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'periodSchoolYears';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'period_school_years';
                        break;
                    default:
                        $key = 'PeriodSchoolYears';
                }

                $result[$key] = $this->collPeriodSchoolYears->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStudents) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'students';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'students';
                        break;
                    default:
                        $key = 'Students';
                }

                $result[$key] = $this->collStudents->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\App\Models\SchoolYear
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SchoolYearTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\App\Models\SchoolYear
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setYear($value);
                break;
            case 2:
                $this->setDateStart($value);
                break;
            case 3:
                $this->setDateEnd($value);
                break;
            case 4:
                $this->setDescription($value);
                break;
            case 5:
                $this->setCreatedAt($value);
                break;
            case 6:
                $this->setUpdatedAt($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = SchoolYearTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setYear($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDateStart($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDateEnd($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDescription($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCreatedAt($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setUpdatedAt($arr[$keys[6]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\App\Models\SchoolYear The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(SchoolYearTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SchoolYearTableMap::COL_ID)) {
            $criteria->add(SchoolYearTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SchoolYearTableMap::COL_YEAR)) {
            $criteria->add(SchoolYearTableMap::COL_YEAR, $this->year);
        }
        if ($this->isColumnModified(SchoolYearTableMap::COL_DATE_START)) {
            $criteria->add(SchoolYearTableMap::COL_DATE_START, $this->date_start);
        }
        if ($this->isColumnModified(SchoolYearTableMap::COL_DATE_END)) {
            $criteria->add(SchoolYearTableMap::COL_DATE_END, $this->date_end);
        }
        if ($this->isColumnModified(SchoolYearTableMap::COL_DESCRIPTION)) {
            $criteria->add(SchoolYearTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(SchoolYearTableMap::COL_CREATED_AT)) {
            $criteria->add(SchoolYearTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(SchoolYearTableMap::COL_UPDATED_AT)) {
            $criteria->add(SchoolYearTableMap::COL_UPDATED_AT, $this->updated_at);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildSchoolYearQuery::create();
        $criteria->add(SchoolYearTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \App\Models\SchoolYear (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setYear($this->getYear());
        $copyObj->setDateStart($this->getDateStart());
        $copyObj->setDateEnd($this->getDateEnd());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getApplications() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addApplication($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getEngagements() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEngagement($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPeriodSchoolYears() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPeriodSchoolYear($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStudents() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStudent($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \App\Models\SchoolYear Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Application' == $relationName) {
            return $this->initApplications();
        }
        if ('Engagement' == $relationName) {
            return $this->initEngagements();
        }
        if ('PeriodSchoolYear' == $relationName) {
            return $this->initPeriodSchoolYears();
        }
        if ('Student' == $relationName) {
            return $this->initStudents();
        }
    }

    /**
     * Clears out the collApplications collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addApplications()
     */
    public function clearApplications()
    {
        $this->collApplications = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collApplications collection loaded partially.
     */
    public function resetPartialApplications($v = true)
    {
        $this->collApplicationsPartial = $v;
    }

    /**
     * Initializes the collApplications collection.
     *
     * By default this just sets the collApplications collection to an empty array (like clearcollApplications());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initApplications($overrideExisting = true)
    {
        if (null !== $this->collApplications && !$overrideExisting) {
            return;
        }
        $this->collApplications = new ObjectCollection();
        $this->collApplications->setModel('\App\Models\Application');
    }

    /**
     * Gets an array of ChildApplication objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSchoolYear is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildApplication[] List of ChildApplication objects
     * @throws PropelException
     */
    public function getApplications(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collApplicationsPartial && !$this->isNew();
        if (null === $this->collApplications || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collApplications) {
                // return empty collection
                $this->initApplications();
            } else {
                $collApplications = ChildApplicationQuery::create(null, $criteria)
                    ->filterBySchoolYear($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collApplicationsPartial && count($collApplications)) {
                        $this->initApplications(false);

                        foreach ($collApplications as $obj) {
                            if (false == $this->collApplications->contains($obj)) {
                                $this->collApplications->append($obj);
                            }
                        }

                        $this->collApplicationsPartial = true;
                    }

                    return $collApplications;
                }

                if ($partial && $this->collApplications) {
                    foreach ($this->collApplications as $obj) {
                        if ($obj->isNew()) {
                            $collApplications[] = $obj;
                        }
                    }
                }

                $this->collApplications = $collApplications;
                $this->collApplicationsPartial = false;
            }
        }

        return $this->collApplications;
    }

    /**
     * Sets a collection of ChildApplication objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $applications A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSchoolYear The current object (for fluent API support)
     */
    public function setApplications(Collection $applications, ConnectionInterface $con = null)
    {
        /** @var ChildApplication[] $applicationsToDelete */
        $applicationsToDelete = $this->getApplications(new Criteria(), $con)->diff($applications);


        $this->applicationsScheduledForDeletion = $applicationsToDelete;

        foreach ($applicationsToDelete as $applicationRemoved) {
            $applicationRemoved->setSchoolYear(null);
        }

        $this->collApplications = null;
        foreach ($applications as $application) {
            $this->addApplication($application);
        }

        $this->collApplications = $applications;
        $this->collApplicationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Application objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Application objects.
     * @throws PropelException
     */
    public function countApplications(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collApplicationsPartial && !$this->isNew();
        if (null === $this->collApplications || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collApplications) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getApplications());
            }

            $query = ChildApplicationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySchoolYear($this)
                ->count($con);
        }

        return count($this->collApplications);
    }

    /**
     * Method called to associate a ChildApplication object to this object
     * through the ChildApplication foreign key attribute.
     *
     * @param  ChildApplication $l ChildApplication
     * @return $this|\App\Models\SchoolYear The current object (for fluent API support)
     */
    public function addApplication(ChildApplication $l)
    {
        if ($this->collApplications === null) {
            $this->initApplications();
            $this->collApplicationsPartial = true;
        }

        if (!$this->collApplications->contains($l)) {
            $this->doAddApplication($l);
        }

        return $this;
    }

    /**
     * @param ChildApplication $application The ChildApplication object to add.
     */
    protected function doAddApplication(ChildApplication $application)
    {
        $this->collApplications[]= $application;
        $application->setSchoolYear($this);
    }

    /**
     * @param  ChildApplication $application The ChildApplication object to remove.
     * @return $this|ChildSchoolYear The current object (for fluent API support)
     */
    public function removeApplication(ChildApplication $application)
    {
        if ($this->getApplications()->contains($application)) {
            $pos = $this->collApplications->search($application);
            $this->collApplications->remove($pos);
            if (null === $this->applicationsScheduledForDeletion) {
                $this->applicationsScheduledForDeletion = clone $this->collApplications;
                $this->applicationsScheduledForDeletion->clear();
            }
            $this->applicationsScheduledForDeletion[]= clone $application;
            $application->setSchoolYear(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SchoolYear is new, it will return
     * an empty collection; or if this SchoolYear has previously
     * been saved, it will retrieve related Applications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SchoolYear.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildApplication[] List of ChildApplication objects
     */
    public function getApplicationsJoinPeriod(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildApplicationQuery::create(null, $criteria);
        $query->joinWith('Period', $joinBehavior);

        return $this->getApplications($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SchoolYear is new, it will return
     * an empty collection; or if this SchoolYear has previously
     * been saved, it will retrieve related Applications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SchoolYear.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildApplication[] List of ChildApplication objects
     */
    public function getApplicationsJoinSubject(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildApplicationQuery::create(null, $criteria);
        $query->joinWith('Subject', $joinBehavior);

        return $this->getApplications($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SchoolYear is new, it will return
     * an empty collection; or if this SchoolYear has previously
     * been saved, it will retrieve related Applications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SchoolYear.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildApplication[] List of ChildApplication objects
     */
    public function getApplicationsJoinStudent(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildApplicationQuery::create(null, $criteria);
        $query->joinWith('Student', $joinBehavior);

        return $this->getApplications($query, $con);
    }

    /**
     * Clears out the collEngagements collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEngagements()
     */
    public function clearEngagements()
    {
        $this->collEngagements = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collEngagements collection loaded partially.
     */
    public function resetPartialEngagements($v = true)
    {
        $this->collEngagementsPartial = $v;
    }

    /**
     * Initializes the collEngagements collection.
     *
     * By default this just sets the collEngagements collection to an empty array (like clearcollEngagements());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEngagements($overrideExisting = true)
    {
        if (null !== $this->collEngagements && !$overrideExisting) {
            return;
        }
        $this->collEngagements = new ObjectCollection();
        $this->collEngagements->setModel('\App\Models\Engagement');
    }

    /**
     * Gets an array of ChildEngagement objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSchoolYear is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildEngagement[] List of ChildEngagement objects
     * @throws PropelException
     */
    public function getEngagements(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collEngagementsPartial && !$this->isNew();
        if (null === $this->collEngagements || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collEngagements) {
                // return empty collection
                $this->initEngagements();
            } else {
                $collEngagements = ChildEngagementQuery::create(null, $criteria)
                    ->filterBySchoolYear($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collEngagementsPartial && count($collEngagements)) {
                        $this->initEngagements(false);

                        foreach ($collEngagements as $obj) {
                            if (false == $this->collEngagements->contains($obj)) {
                                $this->collEngagements->append($obj);
                            }
                        }

                        $this->collEngagementsPartial = true;
                    }

                    return $collEngagements;
                }

                if ($partial && $this->collEngagements) {
                    foreach ($this->collEngagements as $obj) {
                        if ($obj->isNew()) {
                            $collEngagements[] = $obj;
                        }
                    }
                }

                $this->collEngagements = $collEngagements;
                $this->collEngagementsPartial = false;
            }
        }

        return $this->collEngagements;
    }

    /**
     * Sets a collection of ChildEngagement objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $engagements A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSchoolYear The current object (for fluent API support)
     */
    public function setEngagements(Collection $engagements, ConnectionInterface $con = null)
    {
        /** @var ChildEngagement[] $engagementsToDelete */
        $engagementsToDelete = $this->getEngagements(new Criteria(), $con)->diff($engagements);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->engagementsScheduledForDeletion = clone $engagementsToDelete;

        foreach ($engagementsToDelete as $engagementRemoved) {
            $engagementRemoved->setSchoolYear(null);
        }

        $this->collEngagements = null;
        foreach ($engagements as $engagement) {
            $this->addEngagement($engagement);
        }

        $this->collEngagements = $engagements;
        $this->collEngagementsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Engagement objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Engagement objects.
     * @throws PropelException
     */
    public function countEngagements(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collEngagementsPartial && !$this->isNew();
        if (null === $this->collEngagements || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEngagements) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEngagements());
            }

            $query = ChildEngagementQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySchoolYear($this)
                ->count($con);
        }

        return count($this->collEngagements);
    }

    /**
     * Method called to associate a ChildEngagement object to this object
     * through the ChildEngagement foreign key attribute.
     *
     * @param  ChildEngagement $l ChildEngagement
     * @return $this|\App\Models\SchoolYear The current object (for fluent API support)
     */
    public function addEngagement(ChildEngagement $l)
    {
        if ($this->collEngagements === null) {
            $this->initEngagements();
            $this->collEngagementsPartial = true;
        }

        if (!$this->collEngagements->contains($l)) {
            $this->doAddEngagement($l);
        }

        return $this;
    }

    /**
     * @param ChildEngagement $engagement The ChildEngagement object to add.
     */
    protected function doAddEngagement(ChildEngagement $engagement)
    {
        $this->collEngagements[]= $engagement;
        $engagement->setSchoolYear($this);
    }

    /**
     * @param  ChildEngagement $engagement The ChildEngagement object to remove.
     * @return $this|ChildSchoolYear The current object (for fluent API support)
     */
    public function removeEngagement(ChildEngagement $engagement)
    {
        if ($this->getEngagements()->contains($engagement)) {
            $pos = $this->collEngagements->search($engagement);
            $this->collEngagements->remove($pos);
            if (null === $this->engagementsScheduledForDeletion) {
                $this->engagementsScheduledForDeletion = clone $this->collEngagements;
                $this->engagementsScheduledForDeletion->clear();
            }
            $this->engagementsScheduledForDeletion[]= clone $engagement;
            $engagement->setSchoolYear(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SchoolYear is new, it will return
     * an empty collection; or if this SchoolYear has previously
     * been saved, it will retrieve related Engagements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SchoolYear.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildEngagement[] List of ChildEngagement objects
     */
    public function getEngagementsJoinCourse(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildEngagementQuery::create(null, $criteria);
        $query->joinWith('Course', $joinBehavior);

        return $this->getEngagements($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SchoolYear is new, it will return
     * an empty collection; or if this SchoolYear has previously
     * been saved, it will retrieve related Engagements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SchoolYear.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildEngagement[] List of ChildEngagement objects
     */
    public function getEngagementsJoinProfessor(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildEngagementQuery::create(null, $criteria);
        $query->joinWith('Professor', $joinBehavior);

        return $this->getEngagements($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SchoolYear is new, it will return
     * an empty collection; or if this SchoolYear has previously
     * been saved, it will retrieve related Engagements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SchoolYear.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildEngagement[] List of ChildEngagement objects
     */
    public function getEngagementsJoinSubject(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildEngagementQuery::create(null, $criteria);
        $query->joinWith('Subject', $joinBehavior);

        return $this->getEngagements($query, $con);
    }

    /**
     * Clears out the collPeriodSchoolYears collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPeriodSchoolYears()
     */
    public function clearPeriodSchoolYears()
    {
        $this->collPeriodSchoolYears = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPeriodSchoolYears collection loaded partially.
     */
    public function resetPartialPeriodSchoolYears($v = true)
    {
        $this->collPeriodSchoolYearsPartial = $v;
    }

    /**
     * Initializes the collPeriodSchoolYears collection.
     *
     * By default this just sets the collPeriodSchoolYears collection to an empty array (like clearcollPeriodSchoolYears());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPeriodSchoolYears($overrideExisting = true)
    {
        if (null !== $this->collPeriodSchoolYears && !$overrideExisting) {
            return;
        }
        $this->collPeriodSchoolYears = new ObjectCollection();
        $this->collPeriodSchoolYears->setModel('\App\Models\PeriodSchoolYear');
    }

    /**
     * Gets an array of ChildPeriodSchoolYear objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSchoolYear is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPeriodSchoolYear[] List of ChildPeriodSchoolYear objects
     * @throws PropelException
     */
    public function getPeriodSchoolYears(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPeriodSchoolYearsPartial && !$this->isNew();
        if (null === $this->collPeriodSchoolYears || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPeriodSchoolYears) {
                // return empty collection
                $this->initPeriodSchoolYears();
            } else {
                $collPeriodSchoolYears = ChildPeriodSchoolYearQuery::create(null, $criteria)
                    ->filterBySchoolYear($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPeriodSchoolYearsPartial && count($collPeriodSchoolYears)) {
                        $this->initPeriodSchoolYears(false);

                        foreach ($collPeriodSchoolYears as $obj) {
                            if (false == $this->collPeriodSchoolYears->contains($obj)) {
                                $this->collPeriodSchoolYears->append($obj);
                            }
                        }

                        $this->collPeriodSchoolYearsPartial = true;
                    }

                    return $collPeriodSchoolYears;
                }

                if ($partial && $this->collPeriodSchoolYears) {
                    foreach ($this->collPeriodSchoolYears as $obj) {
                        if ($obj->isNew()) {
                            $collPeriodSchoolYears[] = $obj;
                        }
                    }
                }

                $this->collPeriodSchoolYears = $collPeriodSchoolYears;
                $this->collPeriodSchoolYearsPartial = false;
            }
        }

        return $this->collPeriodSchoolYears;
    }

    /**
     * Sets a collection of ChildPeriodSchoolYear objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $periodSchoolYears A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSchoolYear The current object (for fluent API support)
     */
    public function setPeriodSchoolYears(Collection $periodSchoolYears, ConnectionInterface $con = null)
    {
        /** @var ChildPeriodSchoolYear[] $periodSchoolYearsToDelete */
        $periodSchoolYearsToDelete = $this->getPeriodSchoolYears(new Criteria(), $con)->diff($periodSchoolYears);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->periodSchoolYearsScheduledForDeletion = clone $periodSchoolYearsToDelete;

        foreach ($periodSchoolYearsToDelete as $periodSchoolYearRemoved) {
            $periodSchoolYearRemoved->setSchoolYear(null);
        }

        $this->collPeriodSchoolYears = null;
        foreach ($periodSchoolYears as $periodSchoolYear) {
            $this->addPeriodSchoolYear($periodSchoolYear);
        }

        $this->collPeriodSchoolYears = $periodSchoolYears;
        $this->collPeriodSchoolYearsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PeriodSchoolYear objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PeriodSchoolYear objects.
     * @throws PropelException
     */
    public function countPeriodSchoolYears(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPeriodSchoolYearsPartial && !$this->isNew();
        if (null === $this->collPeriodSchoolYears || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPeriodSchoolYears) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPeriodSchoolYears());
            }

            $query = ChildPeriodSchoolYearQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySchoolYear($this)
                ->count($con);
        }

        return count($this->collPeriodSchoolYears);
    }

    /**
     * Method called to associate a ChildPeriodSchoolYear object to this object
     * through the ChildPeriodSchoolYear foreign key attribute.
     *
     * @param  ChildPeriodSchoolYear $l ChildPeriodSchoolYear
     * @return $this|\App\Models\SchoolYear The current object (for fluent API support)
     */
    public function addPeriodSchoolYear(ChildPeriodSchoolYear $l)
    {
        if ($this->collPeriodSchoolYears === null) {
            $this->initPeriodSchoolYears();
            $this->collPeriodSchoolYearsPartial = true;
        }

        if (!$this->collPeriodSchoolYears->contains($l)) {
            $this->doAddPeriodSchoolYear($l);
        }

        return $this;
    }

    /**
     * @param ChildPeriodSchoolYear $periodSchoolYear The ChildPeriodSchoolYear object to add.
     */
    protected function doAddPeriodSchoolYear(ChildPeriodSchoolYear $periodSchoolYear)
    {
        $this->collPeriodSchoolYears[]= $periodSchoolYear;
        $periodSchoolYear->setSchoolYear($this);
    }

    /**
     * @param  ChildPeriodSchoolYear $periodSchoolYear The ChildPeriodSchoolYear object to remove.
     * @return $this|ChildSchoolYear The current object (for fluent API support)
     */
    public function removePeriodSchoolYear(ChildPeriodSchoolYear $periodSchoolYear)
    {
        if ($this->getPeriodSchoolYears()->contains($periodSchoolYear)) {
            $pos = $this->collPeriodSchoolYears->search($periodSchoolYear);
            $this->collPeriodSchoolYears->remove($pos);
            if (null === $this->periodSchoolYearsScheduledForDeletion) {
                $this->periodSchoolYearsScheduledForDeletion = clone $this->collPeriodSchoolYears;
                $this->periodSchoolYearsScheduledForDeletion->clear();
            }
            $this->periodSchoolYearsScheduledForDeletion[]= clone $periodSchoolYear;
            $periodSchoolYear->setSchoolYear(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SchoolYear is new, it will return
     * an empty collection; or if this SchoolYear has previously
     * been saved, it will retrieve related PeriodSchoolYears from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SchoolYear.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPeriodSchoolYear[] List of ChildPeriodSchoolYear objects
     */
    public function getPeriodSchoolYearsJoinPeriod(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPeriodSchoolYearQuery::create(null, $criteria);
        $query->joinWith('Period', $joinBehavior);

        return $this->getPeriodSchoolYears($query, $con);
    }

    /**
     * Clears out the collStudents collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStudents()
     */
    public function clearStudents()
    {
        $this->collStudents = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStudents collection loaded partially.
     */
    public function resetPartialStudents($v = true)
    {
        $this->collStudentsPartial = $v;
    }

    /**
     * Initializes the collStudents collection.
     *
     * By default this just sets the collStudents collection to an empty array (like clearcollStudents());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStudents($overrideExisting = true)
    {
        if (null !== $this->collStudents && !$overrideExisting) {
            return;
        }
        $this->collStudents = new ObjectCollection();
        $this->collStudents->setModel('\App\Models\Student');
    }

    /**
     * Gets an array of ChildStudent objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSchoolYear is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStudent[] List of ChildStudent objects
     * @throws PropelException
     */
    public function getStudents(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStudentsPartial && !$this->isNew();
        if (null === $this->collStudents || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStudents) {
                // return empty collection
                $this->initStudents();
            } else {
                $collStudents = ChildStudentQuery::create(null, $criteria)
                    ->filterBySchoolYear($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStudentsPartial && count($collStudents)) {
                        $this->initStudents(false);

                        foreach ($collStudents as $obj) {
                            if (false == $this->collStudents->contains($obj)) {
                                $this->collStudents->append($obj);
                            }
                        }

                        $this->collStudentsPartial = true;
                    }

                    return $collStudents;
                }

                if ($partial && $this->collStudents) {
                    foreach ($this->collStudents as $obj) {
                        if ($obj->isNew()) {
                            $collStudents[] = $obj;
                        }
                    }
                }

                $this->collStudents = $collStudents;
                $this->collStudentsPartial = false;
            }
        }

        return $this->collStudents;
    }

    /**
     * Sets a collection of ChildStudent objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $students A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSchoolYear The current object (for fluent API support)
     */
    public function setStudents(Collection $students, ConnectionInterface $con = null)
    {
        /** @var ChildStudent[] $studentsToDelete */
        $studentsToDelete = $this->getStudents(new Criteria(), $con)->diff($students);


        $this->studentsScheduledForDeletion = $studentsToDelete;

        foreach ($studentsToDelete as $studentRemoved) {
            $studentRemoved->setSchoolYear(null);
        }

        $this->collStudents = null;
        foreach ($students as $student) {
            $this->addStudent($student);
        }

        $this->collStudents = $students;
        $this->collStudentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Student objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Student objects.
     * @throws PropelException
     */
    public function countStudents(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStudentsPartial && !$this->isNew();
        if (null === $this->collStudents || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStudents) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStudents());
            }

            $query = ChildStudentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySchoolYear($this)
                ->count($con);
        }

        return count($this->collStudents);
    }

    /**
     * Method called to associate a ChildStudent object to this object
     * through the ChildStudent foreign key attribute.
     *
     * @param  ChildStudent $l ChildStudent
     * @return $this|\App\Models\SchoolYear The current object (for fluent API support)
     */
    public function addStudent(ChildStudent $l)
    {
        if ($this->collStudents === null) {
            $this->initStudents();
            $this->collStudentsPartial = true;
        }

        if (!$this->collStudents->contains($l)) {
            $this->doAddStudent($l);
        }

        return $this;
    }

    /**
     * @param ChildStudent $student The ChildStudent object to add.
     */
    protected function doAddStudent(ChildStudent $student)
    {
        $this->collStudents[]= $student;
        $student->setSchoolYear($this);
    }

    /**
     * @param  ChildStudent $student The ChildStudent object to remove.
     * @return $this|ChildSchoolYear The current object (for fluent API support)
     */
    public function removeStudent(ChildStudent $student)
    {
        if ($this->getStudents()->contains($student)) {
            $pos = $this->collStudents->search($student);
            $this->collStudents->remove($pos);
            if (null === $this->studentsScheduledForDeletion) {
                $this->studentsScheduledForDeletion = clone $this->collStudents;
                $this->studentsScheduledForDeletion->clear();
            }
            $this->studentsScheduledForDeletion[]= clone $student;
            $student->setSchoolYear(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SchoolYear is new, it will return
     * an empty collection; or if this SchoolYear has previously
     * been saved, it will retrieve related Students from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SchoolYear.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStudent[] List of ChildStudent objects
     */
    public function getStudentsJoinCourse(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStudentQuery::create(null, $criteria);
        $query->joinWith('Course', $joinBehavior);

        return $this->getStudents($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->year = null;
        $this->date_start = null;
        $this->date_end = null;
        $this->description = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collApplications) {
                foreach ($this->collApplications as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEngagements) {
                foreach ($this->collEngagements as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPeriodSchoolYears) {
                foreach ($this->collPeriodSchoolYears as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStudents) {
                foreach ($this->collStudents as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collApplications = null;
        $this->collEngagements = null;
        $this->collPeriodSchoolYears = null;
        $this->collStudents = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SchoolYearTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildSchoolYear The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[SchoolYearTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
