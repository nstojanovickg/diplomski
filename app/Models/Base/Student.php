<?php

namespace App\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use App\Models\AdminUser as ChildAdminUser;
use App\Models\AdminUserQuery as ChildAdminUserQuery;
use App\Models\Application as ChildApplication;
use App\Models\ApplicationQuery as ChildApplicationQuery;
use App\Models\Course as ChildCourse;
use App\Models\CourseQuery as ChildCourseQuery;
use App\Models\SchoolYear as ChildSchoolYear;
use App\Models\SchoolYearQuery as ChildSchoolYearQuery;
use App\Models\Student as ChildStudent;
use App\Models\StudentQuery as ChildStudentQuery;
use App\Models\Map\StudentTableMap;
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
 * Base class that represents a row from the 'student' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Student implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\App\\Models\\Map\\StudentTableMap';


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
     * The value for the identification_number field.
     * @var        int
     */
    protected $identification_number;

    /**
     * The value for the school_year_id field.
     * @var        int
     */
    protected $school_year_id;

    /**
     * The value for the course_id field.
     * @var        int
     */
    protected $course_id;

    /**
     * The value for the first_name field.
     * @var        string
     */
    protected $first_name;

    /**
     * The value for the last_name field.
     * @var        string
     */
    protected $last_name;

    /**
     * The value for the birth_place field.
     * @var        string
     */
    protected $birth_place;

    /**
     * The value for the birthday field.
     * @var        \DateTime
     */
    protected $birthday;

    /**
     * The value for the phone_number field.
     * @var        string
     */
    protected $phone_number;

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
     * @var        ChildCourse
     */
    protected $aCourse;

    /**
     * @var        ChildSchoolYear
     */
    protected $aSchoolYear;

    /**
     * @var        ObjectCollection|ChildAdminUser[] Collection to store aggregation of ChildAdminUser objects.
     */
    protected $collAdminUsers;
    protected $collAdminUsersPartial;

    /**
     * @var        ObjectCollection|ChildApplication[] Collection to store aggregation of ChildApplication objects.
     */
    protected $collApplications;
    protected $collApplicationsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAdminUser[]
     */
    protected $adminUsersScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildApplication[]
     */
    protected $applicationsScheduledForDeletion = null;

    /**
     * Initializes internal state of App\Models\Base\Student object.
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
     * Compares this with another <code>Student</code> instance.  If
     * <code>obj</code> is an instance of <code>Student</code>, delegates to
     * <code>equals(Student)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Student The current object, for fluid interface
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
     * Get the [identification_number] column value.
     *
     * @return int
     */
    public function getIdentificationNumber()
    {
        return $this->identification_number;
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
     * Get the [course_id] column value.
     *
     * @return int
     */
    public function getCourseId()
    {
        return $this->course_id;
    }

    /**
     * Get the [first_name] column value.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Get the [last_name] column value.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Get the [birth_place] column value.
     *
     * @return string
     */
    public function getBirthPlace()
    {
        return $this->birth_place;
    }

    /**
     * Get the [optionally formatted] temporal [birthday] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getBirthday($format = 'Y-m-d')
    {
        if ($format === null) {
            return $this->birthday;
        } else {
            return $this->birthday instanceof \DateTime ? $this->birthday->format($format) : null;
        }
    }

    /**
     * Get the [phone_number] column value.
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
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
     * @return $this|\App\Models\Student The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[StudentTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [identification_number] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\Student The current object (for fluent API support)
     */
    public function setIdentificationNumber($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->identification_number !== $v) {
            $this->identification_number = $v;
            $this->modifiedColumns[StudentTableMap::COL_IDENTIFICATION_NUMBER] = true;
        }

        return $this;
    } // setIdentificationNumber()

    /**
     * Set the value of [school_year_id] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\Student The current object (for fluent API support)
     */
    public function setSchoolYearId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->school_year_id !== $v) {
            $this->school_year_id = $v;
            $this->modifiedColumns[StudentTableMap::COL_SCHOOL_YEAR_ID] = true;
        }

        if ($this->aSchoolYear !== null && $this->aSchoolYear->getId() !== $v) {
            $this->aSchoolYear = null;
        }

        return $this;
    } // setSchoolYearId()

    /**
     * Set the value of [course_id] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\Student The current object (for fluent API support)
     */
    public function setCourseId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->course_id !== $v) {
            $this->course_id = $v;
            $this->modifiedColumns[StudentTableMap::COL_COURSE_ID] = true;
        }

        if ($this->aCourse !== null && $this->aCourse->getId() !== $v) {
            $this->aCourse = null;
        }

        return $this;
    } // setCourseId()

    /**
     * Set the value of [first_name] column.
     *
     * @param string $v new value
     * @return $this|\App\Models\Student The current object (for fluent API support)
     */
    public function setFirstName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->first_name !== $v) {
            $this->first_name = $v;
            $this->modifiedColumns[StudentTableMap::COL_FIRST_NAME] = true;
        }

        return $this;
    } // setFirstName()

    /**
     * Set the value of [last_name] column.
     *
     * @param string $v new value
     * @return $this|\App\Models\Student The current object (for fluent API support)
     */
    public function setLastName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->last_name !== $v) {
            $this->last_name = $v;
            $this->modifiedColumns[StudentTableMap::COL_LAST_NAME] = true;
        }

        return $this;
    } // setLastName()

    /**
     * Set the value of [birth_place] column.
     *
     * @param string $v new value
     * @return $this|\App\Models\Student The current object (for fluent API support)
     */
    public function setBirthPlace($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->birth_place !== $v) {
            $this->birth_place = $v;
            $this->modifiedColumns[StudentTableMap::COL_BIRTH_PLACE] = true;
        }

        return $this;
    } // setBirthPlace()

    /**
     * Sets the value of [birthday] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\Student The current object (for fluent API support)
     */
    public function setBirthday($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->birthday !== null || $dt !== null) {
            if ($this->birthday === null || $dt === null || $dt->format("Y-m-d") !== $this->birthday->format("Y-m-d")) {
                $this->birthday = $dt === null ? null : clone $dt;
                $this->modifiedColumns[StudentTableMap::COL_BIRTHDAY] = true;
            }
        } // if either are not null

        return $this;
    } // setBirthday()

    /**
     * Set the value of [phone_number] column.
     *
     * @param string $v new value
     * @return $this|\App\Models\Student The current object (for fluent API support)
     */
    public function setPhoneNumber($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone_number !== $v) {
            $this->phone_number = $v;
            $this->modifiedColumns[StudentTableMap::COL_PHONE_NUMBER] = true;
        }

        return $this;
    } // setPhoneNumber()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\Student The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[StudentTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\Student The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[StudentTableMap::COL_UPDATED_AT] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : StudentTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : StudentTableMap::translateFieldName('IdentificationNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->identification_number = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : StudentTableMap::translateFieldName('SchoolYearId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->school_year_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : StudentTableMap::translateFieldName('CourseId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->course_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : StudentTableMap::translateFieldName('FirstName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->first_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : StudentTableMap::translateFieldName('LastName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->last_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : StudentTableMap::translateFieldName('BirthPlace', TableMap::TYPE_PHPNAME, $indexType)];
            $this->birth_place = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : StudentTableMap::translateFieldName('Birthday', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->birthday = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : StudentTableMap::translateFieldName('PhoneNumber', TableMap::TYPE_PHPNAME, $indexType)];
            $this->phone_number = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : StudentTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : StudentTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 11; // 11 = StudentTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Models\\Student'), 0, $e);
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
        if ($this->aSchoolYear !== null && $this->school_year_id !== $this->aSchoolYear->getId()) {
            $this->aSchoolYear = null;
        }
        if ($this->aCourse !== null && $this->course_id !== $this->aCourse->getId()) {
            $this->aCourse = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(StudentTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildStudentQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCourse = null;
            $this->aSchoolYear = null;
            $this->collAdminUsers = null;

            $this->collApplications = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Student::setDeleted()
     * @see Student::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(StudentTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildStudentQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(StudentTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(StudentTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(StudentTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(StudentTableMap::COL_UPDATED_AT)) {
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
                StudentTableMap::addInstanceToPool($this);
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

            if ($this->aCourse !== null) {
                if ($this->aCourse->isModified() || $this->aCourse->isNew()) {
                    $affectedRows += $this->aCourse->save($con);
                }
                $this->setCourse($this->aCourse);
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

            if ($this->adminUsersScheduledForDeletion !== null) {
                if (!$this->adminUsersScheduledForDeletion->isEmpty()) {
                    \App\Models\AdminUserQuery::create()
                        ->filterByPrimaryKeys($this->adminUsersScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->adminUsersScheduledForDeletion = null;
                }
            }

            if ($this->collAdminUsers !== null) {
                foreach ($this->collAdminUsers as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

        $this->modifiedColumns[StudentTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . StudentTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(StudentTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(StudentTableMap::COL_IDENTIFICATION_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'identification_number';
        }
        if ($this->isColumnModified(StudentTableMap::COL_SCHOOL_YEAR_ID)) {
            $modifiedColumns[':p' . $index++]  = 'school_year_id';
        }
        if ($this->isColumnModified(StudentTableMap::COL_COURSE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'course_id';
        }
        if ($this->isColumnModified(StudentTableMap::COL_FIRST_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'first_name';
        }
        if ($this->isColumnModified(StudentTableMap::COL_LAST_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'last_name';
        }
        if ($this->isColumnModified(StudentTableMap::COL_BIRTH_PLACE)) {
            $modifiedColumns[':p' . $index++]  = 'birth_place';
        }
        if ($this->isColumnModified(StudentTableMap::COL_BIRTHDAY)) {
            $modifiedColumns[':p' . $index++]  = 'birthday';
        }
        if ($this->isColumnModified(StudentTableMap::COL_PHONE_NUMBER)) {
            $modifiedColumns[':p' . $index++]  = 'phone_number';
        }
        if ($this->isColumnModified(StudentTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(StudentTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO student (%s) VALUES (%s)',
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
                    case 'identification_number':
                        $stmt->bindValue($identifier, $this->identification_number, PDO::PARAM_INT);
                        break;
                    case 'school_year_id':
                        $stmt->bindValue($identifier, $this->school_year_id, PDO::PARAM_INT);
                        break;
                    case 'course_id':
                        $stmt->bindValue($identifier, $this->course_id, PDO::PARAM_INT);
                        break;
                    case 'first_name':
                        $stmt->bindValue($identifier, $this->first_name, PDO::PARAM_STR);
                        break;
                    case 'last_name':
                        $stmt->bindValue($identifier, $this->last_name, PDO::PARAM_STR);
                        break;
                    case 'birth_place':
                        $stmt->bindValue($identifier, $this->birth_place, PDO::PARAM_STR);
                        break;
                    case 'birthday':
                        $stmt->bindValue($identifier, $this->birthday ? $this->birthday->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'phone_number':
                        $stmt->bindValue($identifier, $this->phone_number, PDO::PARAM_STR);
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
        $pos = StudentTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdentificationNumber();
                break;
            case 2:
                return $this->getSchoolYearId();
                break;
            case 3:
                return $this->getCourseId();
                break;
            case 4:
                return $this->getFirstName();
                break;
            case 5:
                return $this->getLastName();
                break;
            case 6:
                return $this->getBirthPlace();
                break;
            case 7:
                return $this->getBirthday();
                break;
            case 8:
                return $this->getPhoneNumber();
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

        if (isset($alreadyDumpedObjects['Student'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Student'][$this->hashCode()] = true;
        $keys = StudentTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getIdentificationNumber(),
            $keys[2] => $this->getSchoolYearId(),
            $keys[3] => $this->getCourseId(),
            $keys[4] => $this->getFirstName(),
            $keys[5] => $this->getLastName(),
            $keys[6] => $this->getBirthPlace(),
            $keys[7] => $this->getBirthday(),
            $keys[8] => $this->getPhoneNumber(),
            $keys[9] => $this->getCreatedAt(),
            $keys[10] => $this->getUpdatedAt(),
        );

        $utc = new \DateTimeZone('utc');
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
            if (null !== $this->aCourse) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'course';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'course';
                        break;
                    default:
                        $key = 'Course';
                }

                $result[$key] = $this->aCourse->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
            if (null !== $this->collAdminUsers) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'adminUsers';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'admin_users';
                        break;
                    default:
                        $key = 'AdminUsers';
                }

                $result[$key] = $this->collAdminUsers->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
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
     * @return $this|\App\Models\Student
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = StudentTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\App\Models\Student
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setIdentificationNumber($value);
                break;
            case 2:
                $this->setSchoolYearId($value);
                break;
            case 3:
                $this->setCourseId($value);
                break;
            case 4:
                $this->setFirstName($value);
                break;
            case 5:
                $this->setLastName($value);
                break;
            case 6:
                $this->setBirthPlace($value);
                break;
            case 7:
                $this->setBirthday($value);
                break;
            case 8:
                $this->setPhoneNumber($value);
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
        $keys = StudentTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setIdentificationNumber($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setSchoolYearId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCourseId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setFirstName($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setLastName($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setBirthPlace($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setBirthday($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setPhoneNumber($arr[$keys[8]]);
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
     * @return $this|\App\Models\Student The current object, for fluid interface
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
        $criteria = new Criteria(StudentTableMap::DATABASE_NAME);

        if ($this->isColumnModified(StudentTableMap::COL_ID)) {
            $criteria->add(StudentTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(StudentTableMap::COL_IDENTIFICATION_NUMBER)) {
            $criteria->add(StudentTableMap::COL_IDENTIFICATION_NUMBER, $this->identification_number);
        }
        if ($this->isColumnModified(StudentTableMap::COL_SCHOOL_YEAR_ID)) {
            $criteria->add(StudentTableMap::COL_SCHOOL_YEAR_ID, $this->school_year_id);
        }
        if ($this->isColumnModified(StudentTableMap::COL_COURSE_ID)) {
            $criteria->add(StudentTableMap::COL_COURSE_ID, $this->course_id);
        }
        if ($this->isColumnModified(StudentTableMap::COL_FIRST_NAME)) {
            $criteria->add(StudentTableMap::COL_FIRST_NAME, $this->first_name);
        }
        if ($this->isColumnModified(StudentTableMap::COL_LAST_NAME)) {
            $criteria->add(StudentTableMap::COL_LAST_NAME, $this->last_name);
        }
        if ($this->isColumnModified(StudentTableMap::COL_BIRTH_PLACE)) {
            $criteria->add(StudentTableMap::COL_BIRTH_PLACE, $this->birth_place);
        }
        if ($this->isColumnModified(StudentTableMap::COL_BIRTHDAY)) {
            $criteria->add(StudentTableMap::COL_BIRTHDAY, $this->birthday);
        }
        if ($this->isColumnModified(StudentTableMap::COL_PHONE_NUMBER)) {
            $criteria->add(StudentTableMap::COL_PHONE_NUMBER, $this->phone_number);
        }
        if ($this->isColumnModified(StudentTableMap::COL_CREATED_AT)) {
            $criteria->add(StudentTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(StudentTableMap::COL_UPDATED_AT)) {
            $criteria->add(StudentTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildStudentQuery::create();
        $criteria->add(StudentTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \App\Models\Student (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIdentificationNumber($this->getIdentificationNumber());
        $copyObj->setSchoolYearId($this->getSchoolYearId());
        $copyObj->setCourseId($this->getCourseId());
        $copyObj->setFirstName($this->getFirstName());
        $copyObj->setLastName($this->getLastName());
        $copyObj->setBirthPlace($this->getBirthPlace());
        $copyObj->setBirthday($this->getBirthday());
        $copyObj->setPhoneNumber($this->getPhoneNumber());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAdminUsers() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdminUser($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getApplications() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addApplication($relObj->copy($deepCopy));
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
     * @return \App\Models\Student Clone of current object.
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
     * Declares an association between this object and a ChildCourse object.
     *
     * @param  ChildCourse $v
     * @return $this|\App\Models\Student The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCourse(ChildCourse $v = null)
    {
        if ($v === null) {
            $this->setCourseId(NULL);
        } else {
            $this->setCourseId($v->getId());
        }

        $this->aCourse = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCourse object, it will not be re-added.
        if ($v !== null) {
            $v->addStudent($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCourse object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCourse The associated ChildCourse object.
     * @throws PropelException
     */
    public function getCourse(ConnectionInterface $con = null)
    {
        if ($this->aCourse === null && ($this->course_id !== null)) {
            $this->aCourse = ChildCourseQuery::create()->findPk($this->course_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCourse->addStudents($this);
             */
        }

        return $this->aCourse;
    }

    /**
     * Declares an association between this object and a ChildSchoolYear object.
     *
     * @param  ChildSchoolYear $v
     * @return $this|\App\Models\Student The current object (for fluent API support)
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
            $v->addStudent($this);
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
                $this->aSchoolYear->addStudents($this);
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
        if ('AdminUser' == $relationName) {
            return $this->initAdminUsers();
        }
        if ('Application' == $relationName) {
            return $this->initApplications();
        }
    }

    /**
     * Clears out the collAdminUsers collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAdminUsers()
     */
    public function clearAdminUsers()
    {
        $this->collAdminUsers = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAdminUsers collection loaded partially.
     */
    public function resetPartialAdminUsers($v = true)
    {
        $this->collAdminUsersPartial = $v;
    }

    /**
     * Initializes the collAdminUsers collection.
     *
     * By default this just sets the collAdminUsers collection to an empty array (like clearcollAdminUsers());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdminUsers($overrideExisting = true)
    {
        if (null !== $this->collAdminUsers && !$overrideExisting) {
            return;
        }
        $this->collAdminUsers = new ObjectCollection();
        $this->collAdminUsers->setModel('\App\Models\AdminUser');
    }

    /**
     * Gets an array of ChildAdminUser objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildStudent is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAdminUser[] List of ChildAdminUser objects
     * @throws PropelException
     */
    public function getAdminUsers(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAdminUsersPartial && !$this->isNew();
        if (null === $this->collAdminUsers || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdminUsers) {
                // return empty collection
                $this->initAdminUsers();
            } else {
                $collAdminUsers = ChildAdminUserQuery::create(null, $criteria)
                    ->filterByStudent($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAdminUsersPartial && count($collAdminUsers)) {
                        $this->initAdminUsers(false);

                        foreach ($collAdminUsers as $obj) {
                            if (false == $this->collAdminUsers->contains($obj)) {
                                $this->collAdminUsers->append($obj);
                            }
                        }

                        $this->collAdminUsersPartial = true;
                    }

                    return $collAdminUsers;
                }

                if ($partial && $this->collAdminUsers) {
                    foreach ($this->collAdminUsers as $obj) {
                        if ($obj->isNew()) {
                            $collAdminUsers[] = $obj;
                        }
                    }
                }

                $this->collAdminUsers = $collAdminUsers;
                $this->collAdminUsersPartial = false;
            }
        }

        return $this->collAdminUsers;
    }

    /**
     * Sets a collection of ChildAdminUser objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $adminUsers A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildStudent The current object (for fluent API support)
     */
    public function setAdminUsers(Collection $adminUsers, ConnectionInterface $con = null)
    {
        /** @var ChildAdminUser[] $adminUsersToDelete */
        $adminUsersToDelete = $this->getAdminUsers(new Criteria(), $con)->diff($adminUsers);


        $this->adminUsersScheduledForDeletion = $adminUsersToDelete;

        foreach ($adminUsersToDelete as $adminUserRemoved) {
            $adminUserRemoved->setStudent(null);
        }

        $this->collAdminUsers = null;
        foreach ($adminUsers as $adminUser) {
            $this->addAdminUser($adminUser);
        }

        $this->collAdminUsers = $adminUsers;
        $this->collAdminUsersPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AdminUser objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related AdminUser objects.
     * @throws PropelException
     */
    public function countAdminUsers(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAdminUsersPartial && !$this->isNew();
        if (null === $this->collAdminUsers || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdminUsers) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdminUsers());
            }

            $query = ChildAdminUserQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByStudent($this)
                ->count($con);
        }

        return count($this->collAdminUsers);
    }

    /**
     * Method called to associate a ChildAdminUser object to this object
     * through the ChildAdminUser foreign key attribute.
     *
     * @param  ChildAdminUser $l ChildAdminUser
     * @return $this|\App\Models\Student The current object (for fluent API support)
     */
    public function addAdminUser(ChildAdminUser $l)
    {
        if ($this->collAdminUsers === null) {
            $this->initAdminUsers();
            $this->collAdminUsersPartial = true;
        }

        if (!$this->collAdminUsers->contains($l)) {
            $this->doAddAdminUser($l);
        }

        return $this;
    }

    /**
     * @param ChildAdminUser $adminUser The ChildAdminUser object to add.
     */
    protected function doAddAdminUser(ChildAdminUser $adminUser)
    {
        $this->collAdminUsers[]= $adminUser;
        $adminUser->setStudent($this);
    }

    /**
     * @param  ChildAdminUser $adminUser The ChildAdminUser object to remove.
     * @return $this|ChildStudent The current object (for fluent API support)
     */
    public function removeAdminUser(ChildAdminUser $adminUser)
    {
        if ($this->getAdminUsers()->contains($adminUser)) {
            $pos = $this->collAdminUsers->search($adminUser);
            $this->collAdminUsers->remove($pos);
            if (null === $this->adminUsersScheduledForDeletion) {
                $this->adminUsersScheduledForDeletion = clone $this->collAdminUsers;
                $this->adminUsersScheduledForDeletion->clear();
            }
            $this->adminUsersScheduledForDeletion[]= $adminUser;
            $adminUser->setStudent(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Student is new, it will return
     * an empty collection; or if this Student has previously
     * been saved, it will retrieve related AdminUsers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Student.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAdminUser[] List of ChildAdminUser objects
     */
    public function getAdminUsersJoinProfessor(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAdminUserQuery::create(null, $criteria);
        $query->joinWith('Professor', $joinBehavior);

        return $this->getAdminUsers($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Student is new, it will return
     * an empty collection; or if this Student has previously
     * been saved, it will retrieve related AdminUsers from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Student.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAdminUser[] List of ChildAdminUser objects
     */
    public function getAdminUsersJoinTranslationLanguage(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAdminUserQuery::create(null, $criteria);
        $query->joinWith('TranslationLanguage', $joinBehavior);

        return $this->getAdminUsers($query, $con);
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
     * If this ChildStudent is new, it will return
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
                    ->filterByStudent($this)
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
     * @return $this|ChildStudent The current object (for fluent API support)
     */
    public function setApplications(Collection $applications, ConnectionInterface $con = null)
    {
        /** @var ChildApplication[] $applicationsToDelete */
        $applicationsToDelete = $this->getApplications(new Criteria(), $con)->diff($applications);


        $this->applicationsScheduledForDeletion = $applicationsToDelete;

        foreach ($applicationsToDelete as $applicationRemoved) {
            $applicationRemoved->setStudent(null);
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
                ->filterByStudent($this)
                ->count($con);
        }

        return count($this->collApplications);
    }

    /**
     * Method called to associate a ChildApplication object to this object
     * through the ChildApplication foreign key attribute.
     *
     * @param  ChildApplication $l ChildApplication
     * @return $this|\App\Models\Student The current object (for fluent API support)
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
        $application->setStudent($this);
    }

    /**
     * @param  ChildApplication $application The ChildApplication object to remove.
     * @return $this|ChildStudent The current object (for fluent API support)
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
            $application->setStudent(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Student is new, it will return
     * an empty collection; or if this Student has previously
     * been saved, it will retrieve related Applications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Student.
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
     * Otherwise if this Student is new, it will return
     * an empty collection; or if this Student has previously
     * been saved, it will retrieve related Applications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Student.
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
     * Otherwise if this Student is new, it will return
     * an empty collection; or if this Student has previously
     * been saved, it will retrieve related Applications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Student.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildApplication[] List of ChildApplication objects
     */
    public function getApplicationsJoinSchoolYear(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildApplicationQuery::create(null, $criteria);
        $query->joinWith('SchoolYear', $joinBehavior);

        return $this->getApplications($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aCourse) {
            $this->aCourse->removeStudent($this);
        }
        if (null !== $this->aSchoolYear) {
            $this->aSchoolYear->removeStudent($this);
        }
        $this->id = null;
        $this->identification_number = null;
        $this->school_year_id = null;
        $this->course_id = null;
        $this->first_name = null;
        $this->last_name = null;
        $this->birth_place = null;
        $this->birthday = null;
        $this->phone_number = null;
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
            if ($this->collAdminUsers) {
                foreach ($this->collAdminUsers as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collApplications) {
                foreach ($this->collApplications as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAdminUsers = null;
        $this->collApplications = null;
        $this->aCourse = null;
        $this->aSchoolYear = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(StudentTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildStudent The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[StudentTableMap::COL_UPDATED_AT] = true;

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
