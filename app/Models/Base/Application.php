<?php

namespace App\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use App\Models\Application as ChildApplication;
use App\Models\ApplicationQuery as ChildApplicationQuery;
use App\Models\ApplicationRequest as ChildApplicationRequest;
use App\Models\ApplicationRequestQuery as ChildApplicationRequestQuery;
use App\Models\Period as ChildPeriod;
use App\Models\PeriodQuery as ChildPeriodQuery;
use App\Models\SchoolYear as ChildSchoolYear;
use App\Models\SchoolYearQuery as ChildSchoolYearQuery;
use App\Models\Student as ChildStudent;
use App\Models\StudentQuery as ChildStudentQuery;
use App\Models\Subject as ChildSubject;
use App\Models\SubjectQuery as ChildSubjectQuery;
use App\Models\Map\ApplicationTableMap;
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
 * Base class that represents a row from the 'application' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Application implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\App\\Models\\Map\\ApplicationTableMap';


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
     * The value for the student_id field.
     * @var        int
     */
    protected $student_id;

    /**
     * The value for the subject_id field.
     * @var        int
     */
    protected $subject_id;

    /**
     * The value for the period_id field.
     * @var        int
     */
    protected $period_id;

    /**
     * The value for the school_year_id field.
     * @var        int
     */
    protected $school_year_id;

    /**
     * The value for the application_date field.
     * @var        \DateTime
     */
    protected $application_date;

    /**
     * The value for the exam_date field.
     * @var        \DateTime
     */
    protected $exam_date;

    /**
     * The value for the exam_time field.
     * Note: this column has a database default value of: '09:00:00'
     * @var        \DateTime
     */
    protected $exam_time;

    /**
     * The value for the exam_score field.
     * @var        int
     */
    protected $exam_score;

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
     * @var        ChildPeriod
     */
    protected $aPeriod;

    /**
     * @var        ChildSubject
     */
    protected $aSubject;

    /**
     * @var        ChildStudent
     */
    protected $aStudent;

    /**
     * @var        ChildSchoolYear
     */
    protected $aSchoolYear;

    /**
     * @var        ObjectCollection|ChildApplicationRequest[] Collection to store aggregation of ChildApplicationRequest objects.
     */
    protected $collApplicationRequests;
    protected $collApplicationRequestsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildApplicationRequest[]
     */
    protected $applicationRequestsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->exam_time = PropelDateTime::newInstance('09:00:00', null, 'DateTime');
    }

    /**
     * Initializes internal state of App\Models\Base\Application object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
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
     * Compares this with another <code>Application</code> instance.  If
     * <code>obj</code> is an instance of <code>Application</code>, delegates to
     * <code>equals(Application)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Application The current object, for fluid interface
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
     * Get the [student_id] column value.
     *
     * @return int
     */
    public function getStudentId()
    {
        return $this->student_id;
    }

    /**
     * Get the [subject_id] column value.
     *
     * @return int
     */
    public function getSubjectId()
    {
        return $this->subject_id;
    }

    /**
     * Get the [period_id] column value.
     *
     * @return int
     */
    public function getPeriodId()
    {
        return $this->period_id;
    }

    /**
     * Get the [school_year_id] column value.
     *
     * @return int
     */
    public function getSchoolYearId()
    {
        return $this->school_year_id;
    }

    /**
     * Get the [optionally formatted] temporal [application_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getApplicationDate($format = 'Y-m-d')
    {
        if ($format === null) {
            return $this->application_date;
        } else {
            return $this->application_date instanceof \DateTime ? $this->application_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [exam_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getExamDate($format = 'Y-m-d')
    {
        if ($format === null) {
            return $this->exam_date;
        } else {
            return $this->exam_date instanceof \DateTime ? $this->exam_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [exam_time] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getExamTime($format = 'H:i:s')
    {
        if ($format === null) {
            return $this->exam_time;
        } else {
            return $this->exam_time instanceof \DateTime ? $this->exam_time->format($format) : null;
        }
    }

    /**
     * Get the [exam_score] column value.
     *
     * @return int
     */
    public function getExamScore()
    {
        return $this->exam_score;
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
     * @return $this|\App\Models\Application The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ApplicationTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [student_id] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\Application The current object (for fluent API support)
     */
    public function setStudentId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->student_id !== $v) {
            $this->student_id = $v;
            $this->modifiedColumns[ApplicationTableMap::COL_STUDENT_ID] = true;
        }

        if ($this->aStudent !== null && $this->aStudent->getId() !== $v) {
            $this->aStudent = null;
        }

        return $this;
    } // setStudentId()

    /**
     * Set the value of [subject_id] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\Application The current object (for fluent API support)
     */
    public function setSubjectId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->subject_id !== $v) {
            $this->subject_id = $v;
            $this->modifiedColumns[ApplicationTableMap::COL_SUBJECT_ID] = true;
        }

        if ($this->aSubject !== null && $this->aSubject->getId() !== $v) {
            $this->aSubject = null;
        }

        return $this;
    } // setSubjectId()

    /**
     * Set the value of [period_id] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\Application The current object (for fluent API support)
     */
    public function setPeriodId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->period_id !== $v) {
            $this->period_id = $v;
            $this->modifiedColumns[ApplicationTableMap::COL_PERIOD_ID] = true;
        }

        if ($this->aPeriod !== null && $this->aPeriod->getId() !== $v) {
            $this->aPeriod = null;
        }

        return $this;
    } // setPeriodId()

    /**
     * Set the value of [school_year_id] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\Application The current object (for fluent API support)
     */
    public function setSchoolYearId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->school_year_id !== $v) {
            $this->school_year_id = $v;
            $this->modifiedColumns[ApplicationTableMap::COL_SCHOOL_YEAR_ID] = true;
        }

        if ($this->aSchoolYear !== null && $this->aSchoolYear->getId() !== $v) {
            $this->aSchoolYear = null;
        }

        return $this;
    } // setSchoolYearId()

    /**
     * Sets the value of [application_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\Application The current object (for fluent API support)
     */
    public function setApplicationDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->application_date !== null || $dt !== null) {
            if ($this->application_date === null || $dt === null || $dt->format("Y-m-d") !== $this->application_date->format("Y-m-d")) {
                $this->application_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ApplicationTableMap::COL_APPLICATION_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setApplicationDate()

    /**
     * Sets the value of [exam_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\Application The current object (for fluent API support)
     */
    public function setExamDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->exam_date !== null || $dt !== null) {
            if ($this->exam_date === null || $dt === null || $dt->format("Y-m-d") !== $this->exam_date->format("Y-m-d")) {
                $this->exam_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ApplicationTableMap::COL_EXAM_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setExamDate()

    /**
     * Sets the value of [exam_time] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\Application The current object (for fluent API support)
     */
    public function setExamTime($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->exam_time !== null || $dt !== null) {
            if ( ($dt != $this->exam_time) // normalized values don't match
                || ($dt->format('H:i:s') === '09:00:00') // or the entered value matches the default
                 ) {
                $this->exam_time = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ApplicationTableMap::COL_EXAM_TIME] = true;
            }
        } // if either are not null

        return $this;
    } // setExamTime()

    /**
     * Set the value of [exam_score] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\Application The current object (for fluent API support)
     */
    public function setExamScore($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->exam_score !== $v) {
            $this->exam_score = $v;
            $this->modifiedColumns[ApplicationTableMap::COL_EXAM_SCORE] = true;
        }

        return $this;
    } // setExamScore()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\Application The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ApplicationTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\Application The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ApplicationTableMap::COL_UPDATED_AT] = true;
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
            if ($this->exam_time && $this->exam_time->format('H:i:s') !== '09:00:00') {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ApplicationTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ApplicationTableMap::translateFieldName('StudentId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->student_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ApplicationTableMap::translateFieldName('SubjectId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subject_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ApplicationTableMap::translateFieldName('PeriodId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->period_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ApplicationTableMap::translateFieldName('SchoolYearId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->school_year_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ApplicationTableMap::translateFieldName('ApplicationDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->application_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ApplicationTableMap::translateFieldName('ExamDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->exam_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ApplicationTableMap::translateFieldName('ExamTime', TableMap::TYPE_PHPNAME, $indexType)];
            $this->exam_time = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ApplicationTableMap::translateFieldName('ExamScore', TableMap::TYPE_PHPNAME, $indexType)];
            $this->exam_score = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ApplicationTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : ApplicationTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 11; // 11 = ApplicationTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Models\\Application'), 0, $e);
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
        if ($this->aStudent !== null && $this->student_id !== $this->aStudent->getId()) {
            $this->aStudent = null;
        }
        if ($this->aSubject !== null && $this->subject_id !== $this->aSubject->getId()) {
            $this->aSubject = null;
        }
        if ($this->aPeriod !== null && $this->period_id !== $this->aPeriod->getId()) {
            $this->aPeriod = null;
        }
        if ($this->aSchoolYear !== null && $this->school_year_id !== $this->aSchoolYear->getId()) {
            $this->aSchoolYear = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(ApplicationTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildApplicationQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPeriod = null;
            $this->aSubject = null;
            $this->aStudent = null;
            $this->aSchoolYear = null;
            $this->collApplicationRequests = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Application::setDeleted()
     * @see Application::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ApplicationTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildApplicationQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ApplicationTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(ApplicationTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(ApplicationTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(ApplicationTableMap::COL_UPDATED_AT)) {
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
                ApplicationTableMap::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aPeriod !== null) {
                if ($this->aPeriod->isModified() || $this->aPeriod->isNew()) {
                    $affectedRows += $this->aPeriod->save($con);
                }
                $this->setPeriod($this->aPeriod);
            }

            if ($this->aSubject !== null) {
                if ($this->aSubject->isModified() || $this->aSubject->isNew()) {
                    $affectedRows += $this->aSubject->save($con);
                }
                $this->setSubject($this->aSubject);
            }

            if ($this->aStudent !== null) {
                if ($this->aStudent->isModified() || $this->aStudent->isNew()) {
                    $affectedRows += $this->aStudent->save($con);
                }
                $this->setStudent($this->aStudent);
            }

            if ($this->aSchoolYear !== null) {
                if ($this->aSchoolYear->isModified() || $this->aSchoolYear->isNew()) {
                    $affectedRows += $this->aSchoolYear->save($con);
                }
                $this->setSchoolYear($this->aSchoolYear);
            }

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

            if ($this->applicationRequestsScheduledForDeletion !== null) {
                if (!$this->applicationRequestsScheduledForDeletion->isEmpty()) {
                    foreach ($this->applicationRequestsScheduledForDeletion as $applicationRequest) {
                        // need to save related object because we set the relation to null
                        $applicationRequest->save($con);
                    }
                    $this->applicationRequestsScheduledForDeletion = null;
                }
            }

            if ($this->collApplicationRequests !== null) {
                foreach ($this->collApplicationRequests as $referrerFK) {
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

        $this->modifiedColumns[ApplicationTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ApplicationTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ApplicationTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_STUDENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'student_id';
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_SUBJECT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'subject_id';
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_PERIOD_ID)) {
            $modifiedColumns[':p' . $index++]  = 'period_id';
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_SCHOOL_YEAR_ID)) {
            $modifiedColumns[':p' . $index++]  = 'school_year_id';
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_APPLICATION_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'application_date';
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_EXAM_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'exam_date';
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_EXAM_TIME)) {
            $modifiedColumns[':p' . $index++]  = 'exam_time';
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_EXAM_SCORE)) {
            $modifiedColumns[':p' . $index++]  = 'exam_score';
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO application (%s) VALUES (%s)',
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
                    case 'student_id':
                        $stmt->bindValue($identifier, $this->student_id, PDO::PARAM_INT);
                        break;
                    case 'subject_id':
                        $stmt->bindValue($identifier, $this->subject_id, PDO::PARAM_INT);
                        break;
                    case 'period_id':
                        $stmt->bindValue($identifier, $this->period_id, PDO::PARAM_INT);
                        break;
                    case 'school_year_id':
                        $stmt->bindValue($identifier, $this->school_year_id, PDO::PARAM_INT);
                        break;
                    case 'application_date':
                        $stmt->bindValue($identifier, $this->application_date ? $this->application_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'exam_date':
                        $stmt->bindValue($identifier, $this->exam_date ? $this->exam_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'exam_time':
                        $stmt->bindValue($identifier, $this->exam_time ? $this->exam_time->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'exam_score':
                        $stmt->bindValue($identifier, $this->exam_score, PDO::PARAM_INT);
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
        $pos = ApplicationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getStudentId();
                break;
            case 2:
                return $this->getSubjectId();
                break;
            case 3:
                return $this->getPeriodId();
                break;
            case 4:
                return $this->getSchoolYearId();
                break;
            case 5:
                return $this->getApplicationDate();
                break;
            case 6:
                return $this->getExamDate();
                break;
            case 7:
                return $this->getExamTime();
                break;
            case 8:
                return $this->getExamScore();
                break;
            case 9:
                return $this->getCreatedAt();
                break;
            case 10:
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

        if (isset($alreadyDumpedObjects['Application'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Application'][$this->hashCode()] = true;
        $keys = ApplicationTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getStudentId(),
            $keys[2] => $this->getSubjectId(),
            $keys[3] => $this->getPeriodId(),
            $keys[4] => $this->getSchoolYearId(),
            $keys[5] => $this->getApplicationDate(),
            $keys[6] => $this->getExamDate(),
            $keys[7] => $this->getExamTime(),
            $keys[8] => $this->getExamScore(),
            $keys[9] => $this->getCreatedAt(),
            $keys[10] => $this->getUpdatedAt(),
        );

        $utc = new \DateTimeZone('utc');
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

        if ($result[$keys[7]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[7]];
            $result[$keys[7]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[9]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[9]];
            $result[$keys[9]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[10]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[10]];
            $result[$keys[10]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aPeriod) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'period';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'period';
                        break;
                    default:
                        $key = 'Period';
                }

                $result[$key] = $this->aPeriod->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSubject) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'subject';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'subject';
                        break;
                    default:
                        $key = 'Subject';
                }

                $result[$key] = $this->aSubject->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aStudent) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'student';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'student';
                        break;
                    default:
                        $key = 'Student';
                }

                $result[$key] = $this->aStudent->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSchoolYear) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'schoolYear';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'school_year';
                        break;
                    default:
                        $key = 'SchoolYear';
                }

                $result[$key] = $this->aSchoolYear->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collApplicationRequests) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'applicationRequests';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'application_requests';
                        break;
                    default:
                        $key = 'ApplicationRequests';
                }

                $result[$key] = $this->collApplicationRequests->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\App\Models\Application
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ApplicationTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\App\Models\Application
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setStudentId($value);
                break;
            case 2:
                $this->setSubjectId($value);
                break;
            case 3:
                $this->setPeriodId($value);
                break;
            case 4:
                $this->setSchoolYearId($value);
                break;
            case 5:
                $this->setApplicationDate($value);
                break;
            case 6:
                $this->setExamDate($value);
                break;
            case 7:
                $this->setExamTime($value);
                break;
            case 8:
                $this->setExamScore($value);
                break;
            case 9:
                $this->setCreatedAt($value);
                break;
            case 10:
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
        $keys = ApplicationTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setStudentId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setSubjectId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPeriodId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setSchoolYearId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setApplicationDate($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setExamDate($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setExamTime($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setExamScore($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setCreatedAt($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setUpdatedAt($arr[$keys[10]]);
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
     * @return $this|\App\Models\Application The current object, for fluid interface
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
        $criteria = new Criteria(ApplicationTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ApplicationTableMap::COL_ID)) {
            $criteria->add(ApplicationTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_STUDENT_ID)) {
            $criteria->add(ApplicationTableMap::COL_STUDENT_ID, $this->student_id);
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_SUBJECT_ID)) {
            $criteria->add(ApplicationTableMap::COL_SUBJECT_ID, $this->subject_id);
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_PERIOD_ID)) {
            $criteria->add(ApplicationTableMap::COL_PERIOD_ID, $this->period_id);
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_SCHOOL_YEAR_ID)) {
            $criteria->add(ApplicationTableMap::COL_SCHOOL_YEAR_ID, $this->school_year_id);
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_APPLICATION_DATE)) {
            $criteria->add(ApplicationTableMap::COL_APPLICATION_DATE, $this->application_date);
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_EXAM_DATE)) {
            $criteria->add(ApplicationTableMap::COL_EXAM_DATE, $this->exam_date);
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_EXAM_TIME)) {
            $criteria->add(ApplicationTableMap::COL_EXAM_TIME, $this->exam_time);
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_EXAM_SCORE)) {
            $criteria->add(ApplicationTableMap::COL_EXAM_SCORE, $this->exam_score);
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_CREATED_AT)) {
            $criteria->add(ApplicationTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(ApplicationTableMap::COL_UPDATED_AT)) {
            $criteria->add(ApplicationTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildApplicationQuery::create();
        $criteria->add(ApplicationTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \App\Models\Application (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setStudentId($this->getStudentId());
        $copyObj->setSubjectId($this->getSubjectId());
        $copyObj->setPeriodId($this->getPeriodId());
        $copyObj->setSchoolYearId($this->getSchoolYearId());
        $copyObj->setApplicationDate($this->getApplicationDate());
        $copyObj->setExamDate($this->getExamDate());
        $copyObj->setExamTime($this->getExamTime());
        $copyObj->setExamScore($this->getExamScore());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getApplicationRequests() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addApplicationRequest($relObj->copy($deepCopy));
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
     * @return \App\Models\Application Clone of current object.
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
     * Declares an association between this object and a ChildPeriod object.
     *
     * @param  ChildPeriod $v
     * @return $this|\App\Models\Application The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPeriod(ChildPeriod $v = null)
    {
        if ($v === null) {
            $this->setPeriodId(NULL);
        } else {
            $this->setPeriodId($v->getId());
        }

        $this->aPeriod = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPeriod object, it will not be re-added.
        if ($v !== null) {
            $v->addApplication($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPeriod object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPeriod The associated ChildPeriod object.
     * @throws PropelException
     */
    public function getPeriod(ConnectionInterface $con = null)
    {
        if ($this->aPeriod === null && ($this->period_id !== null)) {
            $this->aPeriod = ChildPeriodQuery::create()->findPk($this->period_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPeriod->addApplications($this);
             */
        }

        return $this->aPeriod;
    }

    /**
     * Declares an association between this object and a ChildSubject object.
     *
     * @param  ChildSubject $v
     * @return $this|\App\Models\Application The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSubject(ChildSubject $v = null)
    {
        if ($v === null) {
            $this->setSubjectId(NULL);
        } else {
            $this->setSubjectId($v->getId());
        }

        $this->aSubject = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSubject object, it will not be re-added.
        if ($v !== null) {
            $v->addApplication($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSubject object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSubject The associated ChildSubject object.
     * @throws PropelException
     */
    public function getSubject(ConnectionInterface $con = null)
    {
        if ($this->aSubject === null && ($this->subject_id !== null)) {
            $this->aSubject = ChildSubjectQuery::create()->findPk($this->subject_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSubject->addApplications($this);
             */
        }

        return $this->aSubject;
    }

    /**
     * Declares an association between this object and a ChildStudent object.
     *
     * @param  ChildStudent $v
     * @return $this|\App\Models\Application The current object (for fluent API support)
     * @throws PropelException
     */
    public function setStudent(ChildStudent $v = null)
    {
        if ($v === null) {
            $this->setStudentId(NULL);
        } else {
            $this->setStudentId($v->getId());
        }

        $this->aStudent = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildStudent object, it will not be re-added.
        if ($v !== null) {
            $v->addApplication($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildStudent object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildStudent The associated ChildStudent object.
     * @throws PropelException
     */
    public function getStudent(ConnectionInterface $con = null)
    {
        if ($this->aStudent === null && ($this->student_id !== null)) {
            $this->aStudent = ChildStudentQuery::create()->findPk($this->student_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aStudent->addApplications($this);
             */
        }

        return $this->aStudent;
    }

    /**
     * Declares an association between this object and a ChildSchoolYear object.
     *
     * @param  ChildSchoolYear $v
     * @return $this|\App\Models\Application The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSchoolYear(ChildSchoolYear $v = null)
    {
        if ($v === null) {
            $this->setSchoolYearId(NULL);
        } else {
            $this->setSchoolYearId($v->getId());
        }

        $this->aSchoolYear = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSchoolYear object, it will not be re-added.
        if ($v !== null) {
            $v->addApplication($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSchoolYear object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSchoolYear The associated ChildSchoolYear object.
     * @throws PropelException
     */
    public function getSchoolYear(ConnectionInterface $con = null)
    {
        if ($this->aSchoolYear === null && ($this->school_year_id !== null)) {
            $this->aSchoolYear = ChildSchoolYearQuery::create()->findPk($this->school_year_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSchoolYear->addApplications($this);
             */
        }

        return $this->aSchoolYear;
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
        if ('ApplicationRequest' == $relationName) {
            return $this->initApplicationRequests();
        }
    }

    /**
     * Clears out the collApplicationRequests collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addApplicationRequests()
     */
    public function clearApplicationRequests()
    {
        $this->collApplicationRequests = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collApplicationRequests collection loaded partially.
     */
    public function resetPartialApplicationRequests($v = true)
    {
        $this->collApplicationRequestsPartial = $v;
    }

    /**
     * Initializes the collApplicationRequests collection.
     *
     * By default this just sets the collApplicationRequests collection to an empty array (like clearcollApplicationRequests());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initApplicationRequests($overrideExisting = true)
    {
        if (null !== $this->collApplicationRequests && !$overrideExisting) {
            return;
        }
        $this->collApplicationRequests = new ObjectCollection();
        $this->collApplicationRequests->setModel('\App\Models\ApplicationRequest');
    }

    /**
     * Gets an array of ChildApplicationRequest objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildApplication is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildApplicationRequest[] List of ChildApplicationRequest objects
     * @throws PropelException
     */
    public function getApplicationRequests(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collApplicationRequestsPartial && !$this->isNew();
        if (null === $this->collApplicationRequests || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collApplicationRequests) {
                // return empty collection
                $this->initApplicationRequests();
            } else {
                $collApplicationRequests = ChildApplicationRequestQuery::create(null, $criteria)
                    ->filterByApplication($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collApplicationRequestsPartial && count($collApplicationRequests)) {
                        $this->initApplicationRequests(false);

                        foreach ($collApplicationRequests as $obj) {
                            if (false == $this->collApplicationRequests->contains($obj)) {
                                $this->collApplicationRequests->append($obj);
                            }
                        }

                        $this->collApplicationRequestsPartial = true;
                    }

                    return $collApplicationRequests;
                }

                if ($partial && $this->collApplicationRequests) {
                    foreach ($this->collApplicationRequests as $obj) {
                        if ($obj->isNew()) {
                            $collApplicationRequests[] = $obj;
                        }
                    }
                }

                $this->collApplicationRequests = $collApplicationRequests;
                $this->collApplicationRequestsPartial = false;
            }
        }

        return $this->collApplicationRequests;
    }

    /**
     * Sets a collection of ChildApplicationRequest objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $applicationRequests A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildApplication The current object (for fluent API support)
     */
    public function setApplicationRequests(Collection $applicationRequests, ConnectionInterface $con = null)
    {
        /** @var ChildApplicationRequest[] $applicationRequestsToDelete */
        $applicationRequestsToDelete = $this->getApplicationRequests(new Criteria(), $con)->diff($applicationRequests);


        $this->applicationRequestsScheduledForDeletion = $applicationRequestsToDelete;

        foreach ($applicationRequestsToDelete as $applicationRequestRemoved) {
            $applicationRequestRemoved->setApplication(null);
        }

        $this->collApplicationRequests = null;
        foreach ($applicationRequests as $applicationRequest) {
            $this->addApplicationRequest($applicationRequest);
        }

        $this->collApplicationRequests = $applicationRequests;
        $this->collApplicationRequestsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ApplicationRequest objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ApplicationRequest objects.
     * @throws PropelException
     */
    public function countApplicationRequests(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collApplicationRequestsPartial && !$this->isNew();
        if (null === $this->collApplicationRequests || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collApplicationRequests) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getApplicationRequests());
            }

            $query = ChildApplicationRequestQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByApplication($this)
                ->count($con);
        }

        return count($this->collApplicationRequests);
    }

    /**
     * Method called to associate a ChildApplicationRequest object to this object
     * through the ChildApplicationRequest foreign key attribute.
     *
     * @param  ChildApplicationRequest $l ChildApplicationRequest
     * @return $this|\App\Models\Application The current object (for fluent API support)
     */
    public function addApplicationRequest(ChildApplicationRequest $l)
    {
        if ($this->collApplicationRequests === null) {
            $this->initApplicationRequests();
            $this->collApplicationRequestsPartial = true;
        }

        if (!$this->collApplicationRequests->contains($l)) {
            $this->doAddApplicationRequest($l);
        }

        return $this;
    }

    /**
     * @param ChildApplicationRequest $applicationRequest The ChildApplicationRequest object to add.
     */
    protected function doAddApplicationRequest(ChildApplicationRequest $applicationRequest)
    {
        $this->collApplicationRequests[]= $applicationRequest;
        $applicationRequest->setApplication($this);
    }

    /**
     * @param  ChildApplicationRequest $applicationRequest The ChildApplicationRequest object to remove.
     * @return $this|ChildApplication The current object (for fluent API support)
     */
    public function removeApplicationRequest(ChildApplicationRequest $applicationRequest)
    {
        if ($this->getApplicationRequests()->contains($applicationRequest)) {
            $pos = $this->collApplicationRequests->search($applicationRequest);
            $this->collApplicationRequests->remove($pos);
            if (null === $this->applicationRequestsScheduledForDeletion) {
                $this->applicationRequestsScheduledForDeletion = clone $this->collApplicationRequests;
                $this->applicationRequestsScheduledForDeletion->clear();
            }
            $this->applicationRequestsScheduledForDeletion[]= $applicationRequest;
            $applicationRequest->setApplication(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPeriod) {
            $this->aPeriod->removeApplication($this);
        }
        if (null !== $this->aSubject) {
            $this->aSubject->removeApplication($this);
        }
        if (null !== $this->aStudent) {
            $this->aStudent->removeApplication($this);
        }
        if (null !== $this->aSchoolYear) {
            $this->aSchoolYear->removeApplication($this);
        }
        $this->id = null;
        $this->student_id = null;
        $this->subject_id = null;
        $this->period_id = null;
        $this->school_year_id = null;
        $this->application_date = null;
        $this->exam_date = null;
        $this->exam_time = null;
        $this->exam_score = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
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
            if ($this->collApplicationRequests) {
                foreach ($this->collApplicationRequests as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collApplicationRequests = null;
        $this->aPeriod = null;
        $this->aSubject = null;
        $this->aStudent = null;
        $this->aSchoolYear = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ApplicationTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildApplication The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[ApplicationTableMap::COL_UPDATED_AT] = true;

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
