<?php

namespace App\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use App\Models\Application as ChildApplication;
use App\Models\ApplicationQuery as ChildApplicationQuery;
use App\Models\Engagement as ChildEngagement;
use App\Models\EngagementQuery as ChildEngagementQuery;
use App\Models\SmsCallLog as ChildSmsCallLog;
use App\Models\SmsCallLogQuery as ChildSmsCallLogQuery;
use App\Models\StudyProgram as ChildStudyProgram;
use App\Models\StudyProgramQuery as ChildStudyProgramQuery;
use App\Models\Subject as ChildSubject;
use App\Models\SubjectQuery as ChildSubjectQuery;
use App\Models\Map\SubjectTableMap;
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
 * Base class that represents a row from the 'subject' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Subject implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\App\\Models\\Map\\SubjectTableMap';


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
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the code field.
     * @var        string
     */
    protected $code;

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
     * @var        ObjectCollection|ChildSmsCallLog[] Collection to store aggregation of ChildSmsCallLog objects.
     */
    protected $collSmsCallLogs;
    protected $collSmsCallLogsPartial;

    /**
     * @var        ObjectCollection|ChildStudyProgram[] Collection to store aggregation of ChildStudyProgram objects.
     */
    protected $collStudyPrograms;
    protected $collStudyProgramsPartial;

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
     * @var ObjectCollection|ChildSmsCallLog[]
     */
    protected $smsCallLogsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStudyProgram[]
     */
    protected $studyProgramsScheduledForDeletion = null;

    /**
     * Initializes internal state of App\Models\Base\Subject object.
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
     * Compares this with another <code>Subject</code> instance.  If
     * <code>obj</code> is an instance of <code>Subject</code>, delegates to
     * <code>equals(Subject)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Subject The current object, for fluid interface
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
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [code] column value.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
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
     * @return $this|\App\Models\Subject The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[SubjectTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\App\Models\Subject The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[SubjectTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [code] column.
     *
     * @param string $v new value
     * @return $this|\App\Models\Subject The current object (for fluent API support)
     */
    public function setCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->code !== $v) {
            $this->code = $v;
            $this->modifiedColumns[SubjectTableMap::COL_CODE] = true;
        }

        return $this;
    } // setCode()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\Subject The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SubjectTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\Subject The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SubjectTableMap::COL_UPDATED_AT] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SubjectTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SubjectTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SubjectTableMap::translateFieldName('Code', TableMap::TYPE_PHPNAME, $indexType)];
            $this->code = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SubjectTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SubjectTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = SubjectTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Models\\Subject'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(SubjectTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSubjectQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collApplications = null;

            $this->collEngagements = null;

            $this->collSmsCallLogs = null;

            $this->collStudyPrograms = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Subject::setDeleted()
     * @see Subject::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SubjectTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSubjectQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SubjectTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(SubjectTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(SubjectTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(SubjectTableMap::COL_UPDATED_AT)) {
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
                SubjectTableMap::addInstanceToPool($this);
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

            if ($this->smsCallLogsScheduledForDeletion !== null) {
                if (!$this->smsCallLogsScheduledForDeletion->isEmpty()) {
                    \App\Models\SmsCallLogQuery::create()
                        ->filterByPrimaryKeys($this->smsCallLogsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->smsCallLogsScheduledForDeletion = null;
                }
            }

            if ($this->collSmsCallLogs !== null) {
                foreach ($this->collSmsCallLogs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->studyProgramsScheduledForDeletion !== null) {
                if (!$this->studyProgramsScheduledForDeletion->isEmpty()) {
                    \App\Models\StudyProgramQuery::create()
                        ->filterByPrimaryKeys($this->studyProgramsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->studyProgramsScheduledForDeletion = null;
                }
            }

            if ($this->collStudyPrograms !== null) {
                foreach ($this->collStudyPrograms as $referrerFK) {
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

        $this->modifiedColumns[SubjectTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SubjectTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SubjectTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(SubjectTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(SubjectTableMap::COL_CODE)) {
            $modifiedColumns[':p' . $index++]  = 'code';
        }
        if ($this->isColumnModified(SubjectTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(SubjectTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO subject (%s) VALUES (%s)',
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
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'code':
                        $stmt->bindValue($identifier, $this->code, PDO::PARAM_STR);
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
        $pos = SubjectTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
                return $this->getCode();
                break;
            case 3:
                return $this->getCreatedAt();
                break;
            case 4:
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

        if (isset($alreadyDumpedObjects['Subject'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Subject'][$this->hashCode()] = true;
        $keys = SubjectTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getCode(),
            $keys[3] => $this->getCreatedAt(),
            $keys[4] => $this->getUpdatedAt(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[3]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[3]];
            $result[$keys[3]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[4]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[4]];
            $result[$keys[4]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
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
            if (null !== $this->collSmsCallLogs) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'smsCallLogs';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'sms_call_logs';
                        break;
                    default:
                        $key = 'SmsCallLogs';
                }

                $result[$key] = $this->collSmsCallLogs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStudyPrograms) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'studyPrograms';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'study_programs';
                        break;
                    default:
                        $key = 'StudyPrograms';
                }

                $result[$key] = $this->collStudyPrograms->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\App\Models\Subject
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SubjectTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\App\Models\Subject
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setCode($value);
                break;
            case 3:
                $this->setCreatedAt($value);
                break;
            case 4:
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
        $keys = SubjectTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setCode($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCreatedAt($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setUpdatedAt($arr[$keys[4]]);
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
     * @return $this|\App\Models\Subject The current object, for fluid interface
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
        $criteria = new Criteria(SubjectTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SubjectTableMap::COL_ID)) {
            $criteria->add(SubjectTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(SubjectTableMap::COL_NAME)) {
            $criteria->add(SubjectTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(SubjectTableMap::COL_CODE)) {
            $criteria->add(SubjectTableMap::COL_CODE, $this->code);
        }
        if ($this->isColumnModified(SubjectTableMap::COL_CREATED_AT)) {
            $criteria->add(SubjectTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(SubjectTableMap::COL_UPDATED_AT)) {
            $criteria->add(SubjectTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildSubjectQuery::create();
        $criteria->add(SubjectTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \App\Models\Subject (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setCode($this->getCode());
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

            foreach ($this->getSmsCallLogs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSmsCallLog($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStudyPrograms() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStudyProgram($relObj->copy($deepCopy));
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
     * @return \App\Models\Subject Clone of current object.
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
        if ('SmsCallLog' == $relationName) {
            return $this->initSmsCallLogs();
        }
        if ('StudyProgram' == $relationName) {
            return $this->initStudyPrograms();
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
     * If this ChildSubject is new, it will return
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
                    ->filterBySubject($this)
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
     * @return $this|ChildSubject The current object (for fluent API support)
     */
    public function setApplications(Collection $applications, ConnectionInterface $con = null)
    {
        /** @var ChildApplication[] $applicationsToDelete */
        $applicationsToDelete = $this->getApplications(new Criteria(), $con)->diff($applications);


        $this->applicationsScheduledForDeletion = $applicationsToDelete;

        foreach ($applicationsToDelete as $applicationRemoved) {
            $applicationRemoved->setSubject(null);
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
                ->filterBySubject($this)
                ->count($con);
        }

        return count($this->collApplications);
    }

    /**
     * Method called to associate a ChildApplication object to this object
     * through the ChildApplication foreign key attribute.
     *
     * @param  ChildApplication $l ChildApplication
     * @return $this|\App\Models\Subject The current object (for fluent API support)
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
        $application->setSubject($this);
    }

    /**
     * @param  ChildApplication $application The ChildApplication object to remove.
     * @return $this|ChildSubject The current object (for fluent API support)
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
            $application->setSubject(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Subject is new, it will return
     * an empty collection; or if this Subject has previously
     * been saved, it will retrieve related Applications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Subject.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildApplication[] List of ChildApplication objects
     */
    public function getApplicationsJoinOralExamInvitation(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildApplicationQuery::create(null, $criteria);
        $query->joinWith('OralExamInvitation', $joinBehavior);

        return $this->getApplications($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Subject is new, it will return
     * an empty collection; or if this Subject has previously
     * been saved, it will retrieve related Applications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Subject.
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
     * Otherwise if this Subject is new, it will return
     * an empty collection; or if this Subject has previously
     * been saved, it will retrieve related Applications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Subject.
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
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Subject is new, it will return
     * an empty collection; or if this Subject has previously
     * been saved, it will retrieve related Applications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Subject.
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
     * If this ChildSubject is new, it will return
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
                    ->filterBySubject($this)
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
     * @return $this|ChildSubject The current object (for fluent API support)
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
            $engagementRemoved->setSubject(null);
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
                ->filterBySubject($this)
                ->count($con);
        }

        return count($this->collEngagements);
    }

    /**
     * Method called to associate a ChildEngagement object to this object
     * through the ChildEngagement foreign key attribute.
     *
     * @param  ChildEngagement $l ChildEngagement
     * @return $this|\App\Models\Subject The current object (for fluent API support)
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
        $engagement->setSubject($this);
    }

    /**
     * @param  ChildEngagement $engagement The ChildEngagement object to remove.
     * @return $this|ChildSubject The current object (for fluent API support)
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
            $engagement->setSubject(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Subject is new, it will return
     * an empty collection; or if this Subject has previously
     * been saved, it will retrieve related Engagements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Subject.
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
     * Otherwise if this Subject is new, it will return
     * an empty collection; or if this Subject has previously
     * been saved, it will retrieve related Engagements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Subject.
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
     * Otherwise if this Subject is new, it will return
     * an empty collection; or if this Subject has previously
     * been saved, it will retrieve related Engagements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Subject.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildEngagement[] List of ChildEngagement objects
     */
    public function getEngagementsJoinSchoolYear(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildEngagementQuery::create(null, $criteria);
        $query->joinWith('SchoolYear', $joinBehavior);

        return $this->getEngagements($query, $con);
    }

    /**
     * Clears out the collSmsCallLogs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSmsCallLogs()
     */
    public function clearSmsCallLogs()
    {
        $this->collSmsCallLogs = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSmsCallLogs collection loaded partially.
     */
    public function resetPartialSmsCallLogs($v = true)
    {
        $this->collSmsCallLogsPartial = $v;
    }

    /**
     * Initializes the collSmsCallLogs collection.
     *
     * By default this just sets the collSmsCallLogs collection to an empty array (like clearcollSmsCallLogs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSmsCallLogs($overrideExisting = true)
    {
        if (null !== $this->collSmsCallLogs && !$overrideExisting) {
            return;
        }
        $this->collSmsCallLogs = new ObjectCollection();
        $this->collSmsCallLogs->setModel('\App\Models\SmsCallLog');
    }

    /**
     * Gets an array of ChildSmsCallLog objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSubject is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSmsCallLog[] List of ChildSmsCallLog objects
     * @throws PropelException
     */
    public function getSmsCallLogs(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSmsCallLogsPartial && !$this->isNew();
        if (null === $this->collSmsCallLogs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSmsCallLogs) {
                // return empty collection
                $this->initSmsCallLogs();
            } else {
                $collSmsCallLogs = ChildSmsCallLogQuery::create(null, $criteria)
                    ->filterBySubject($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSmsCallLogsPartial && count($collSmsCallLogs)) {
                        $this->initSmsCallLogs(false);

                        foreach ($collSmsCallLogs as $obj) {
                            if (false == $this->collSmsCallLogs->contains($obj)) {
                                $this->collSmsCallLogs->append($obj);
                            }
                        }

                        $this->collSmsCallLogsPartial = true;
                    }

                    return $collSmsCallLogs;
                }

                if ($partial && $this->collSmsCallLogs) {
                    foreach ($this->collSmsCallLogs as $obj) {
                        if ($obj->isNew()) {
                            $collSmsCallLogs[] = $obj;
                        }
                    }
                }

                $this->collSmsCallLogs = $collSmsCallLogs;
                $this->collSmsCallLogsPartial = false;
            }
        }

        return $this->collSmsCallLogs;
    }

    /**
     * Sets a collection of ChildSmsCallLog objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $smsCallLogs A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSubject The current object (for fluent API support)
     */
    public function setSmsCallLogs(Collection $smsCallLogs, ConnectionInterface $con = null)
    {
        /** @var ChildSmsCallLog[] $smsCallLogsToDelete */
        $smsCallLogsToDelete = $this->getSmsCallLogs(new Criteria(), $con)->diff($smsCallLogs);


        $this->smsCallLogsScheduledForDeletion = $smsCallLogsToDelete;

        foreach ($smsCallLogsToDelete as $smsCallLogRemoved) {
            $smsCallLogRemoved->setSubject(null);
        }

        $this->collSmsCallLogs = null;
        foreach ($smsCallLogs as $smsCallLog) {
            $this->addSmsCallLog($smsCallLog);
        }

        $this->collSmsCallLogs = $smsCallLogs;
        $this->collSmsCallLogsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SmsCallLog objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related SmsCallLog objects.
     * @throws PropelException
     */
    public function countSmsCallLogs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSmsCallLogsPartial && !$this->isNew();
        if (null === $this->collSmsCallLogs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSmsCallLogs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSmsCallLogs());
            }

            $query = ChildSmsCallLogQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySubject($this)
                ->count($con);
        }

        return count($this->collSmsCallLogs);
    }

    /**
     * Method called to associate a ChildSmsCallLog object to this object
     * through the ChildSmsCallLog foreign key attribute.
     *
     * @param  ChildSmsCallLog $l ChildSmsCallLog
     * @return $this|\App\Models\Subject The current object (for fluent API support)
     */
    public function addSmsCallLog(ChildSmsCallLog $l)
    {
        if ($this->collSmsCallLogs === null) {
            $this->initSmsCallLogs();
            $this->collSmsCallLogsPartial = true;
        }

        if (!$this->collSmsCallLogs->contains($l)) {
            $this->doAddSmsCallLog($l);
        }

        return $this;
    }

    /**
     * @param ChildSmsCallLog $smsCallLog The ChildSmsCallLog object to add.
     */
    protected function doAddSmsCallLog(ChildSmsCallLog $smsCallLog)
    {
        $this->collSmsCallLogs[]= $smsCallLog;
        $smsCallLog->setSubject($this);
    }

    /**
     * @param  ChildSmsCallLog $smsCallLog The ChildSmsCallLog object to remove.
     * @return $this|ChildSubject The current object (for fluent API support)
     */
    public function removeSmsCallLog(ChildSmsCallLog $smsCallLog)
    {
        if ($this->getSmsCallLogs()->contains($smsCallLog)) {
            $pos = $this->collSmsCallLogs->search($smsCallLog);
            $this->collSmsCallLogs->remove($pos);
            if (null === $this->smsCallLogsScheduledForDeletion) {
                $this->smsCallLogsScheduledForDeletion = clone $this->collSmsCallLogs;
                $this->smsCallLogsScheduledForDeletion->clear();
            }
            $this->smsCallLogsScheduledForDeletion[]= clone $smsCallLog;
            $smsCallLog->setSubject(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Subject is new, it will return
     * an empty collection; or if this Subject has previously
     * been saved, it will retrieve related SmsCallLogs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Subject.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSmsCallLog[] List of ChildSmsCallLog objects
     */
    public function getSmsCallLogsJoinApplicationRequest(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSmsCallLogQuery::create(null, $criteria);
        $query->joinWith('ApplicationRequest', $joinBehavior);

        return $this->getSmsCallLogs($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Subject is new, it will return
     * an empty collection; or if this Subject has previously
     * been saved, it will retrieve related SmsCallLogs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Subject.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSmsCallLog[] List of ChildSmsCallLog objects
     */
    public function getSmsCallLogsJoinPeriod(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSmsCallLogQuery::create(null, $criteria);
        $query->joinWith('Period', $joinBehavior);

        return $this->getSmsCallLogs($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Subject is new, it will return
     * an empty collection; or if this Subject has previously
     * been saved, it will retrieve related SmsCallLogs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Subject.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSmsCallLog[] List of ChildSmsCallLog objects
     */
    public function getSmsCallLogsJoinStudent(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSmsCallLogQuery::create(null, $criteria);
        $query->joinWith('Student', $joinBehavior);

        return $this->getSmsCallLogs($query, $con);
    }

    /**
     * Clears out the collStudyPrograms collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStudyPrograms()
     */
    public function clearStudyPrograms()
    {
        $this->collStudyPrograms = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStudyPrograms collection loaded partially.
     */
    public function resetPartialStudyPrograms($v = true)
    {
        $this->collStudyProgramsPartial = $v;
    }

    /**
     * Initializes the collStudyPrograms collection.
     *
     * By default this just sets the collStudyPrograms collection to an empty array (like clearcollStudyPrograms());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStudyPrograms($overrideExisting = true)
    {
        if (null !== $this->collStudyPrograms && !$overrideExisting) {
            return;
        }
        $this->collStudyPrograms = new ObjectCollection();
        $this->collStudyPrograms->setModel('\App\Models\StudyProgram');
    }

    /**
     * Gets an array of ChildStudyProgram objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSubject is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStudyProgram[] List of ChildStudyProgram objects
     * @throws PropelException
     */
    public function getStudyPrograms(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStudyProgramsPartial && !$this->isNew();
        if (null === $this->collStudyPrograms || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStudyPrograms) {
                // return empty collection
                $this->initStudyPrograms();
            } else {
                $collStudyPrograms = ChildStudyProgramQuery::create(null, $criteria)
                    ->filterBySubject($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStudyProgramsPartial && count($collStudyPrograms)) {
                        $this->initStudyPrograms(false);

                        foreach ($collStudyPrograms as $obj) {
                            if (false == $this->collStudyPrograms->contains($obj)) {
                                $this->collStudyPrograms->append($obj);
                            }
                        }

                        $this->collStudyProgramsPartial = true;
                    }

                    return $collStudyPrograms;
                }

                if ($partial && $this->collStudyPrograms) {
                    foreach ($this->collStudyPrograms as $obj) {
                        if ($obj->isNew()) {
                            $collStudyPrograms[] = $obj;
                        }
                    }
                }

                $this->collStudyPrograms = $collStudyPrograms;
                $this->collStudyProgramsPartial = false;
            }
        }

        return $this->collStudyPrograms;
    }

    /**
     * Sets a collection of ChildStudyProgram objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $studyPrograms A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSubject The current object (for fluent API support)
     */
    public function setStudyPrograms(Collection $studyPrograms, ConnectionInterface $con = null)
    {
        /** @var ChildStudyProgram[] $studyProgramsToDelete */
        $studyProgramsToDelete = $this->getStudyPrograms(new Criteria(), $con)->diff($studyPrograms);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->studyProgramsScheduledForDeletion = clone $studyProgramsToDelete;

        foreach ($studyProgramsToDelete as $studyProgramRemoved) {
            $studyProgramRemoved->setSubject(null);
        }

        $this->collStudyPrograms = null;
        foreach ($studyPrograms as $studyProgram) {
            $this->addStudyProgram($studyProgram);
        }

        $this->collStudyPrograms = $studyPrograms;
        $this->collStudyProgramsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related StudyProgram objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related StudyProgram objects.
     * @throws PropelException
     */
    public function countStudyPrograms(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStudyProgramsPartial && !$this->isNew();
        if (null === $this->collStudyPrograms || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStudyPrograms) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStudyPrograms());
            }

            $query = ChildStudyProgramQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySubject($this)
                ->count($con);
        }

        return count($this->collStudyPrograms);
    }

    /**
     * Method called to associate a ChildStudyProgram object to this object
     * through the ChildStudyProgram foreign key attribute.
     *
     * @param  ChildStudyProgram $l ChildStudyProgram
     * @return $this|\App\Models\Subject The current object (for fluent API support)
     */
    public function addStudyProgram(ChildStudyProgram $l)
    {
        if ($this->collStudyPrograms === null) {
            $this->initStudyPrograms();
            $this->collStudyProgramsPartial = true;
        }

        if (!$this->collStudyPrograms->contains($l)) {
            $this->doAddStudyProgram($l);
        }

        return $this;
    }

    /**
     * @param ChildStudyProgram $studyProgram The ChildStudyProgram object to add.
     */
    protected function doAddStudyProgram(ChildStudyProgram $studyProgram)
    {
        $this->collStudyPrograms[]= $studyProgram;
        $studyProgram->setSubject($this);
    }

    /**
     * @param  ChildStudyProgram $studyProgram The ChildStudyProgram object to remove.
     * @return $this|ChildSubject The current object (for fluent API support)
     */
    public function removeStudyProgram(ChildStudyProgram $studyProgram)
    {
        if ($this->getStudyPrograms()->contains($studyProgram)) {
            $pos = $this->collStudyPrograms->search($studyProgram);
            $this->collStudyPrograms->remove($pos);
            if (null === $this->studyProgramsScheduledForDeletion) {
                $this->studyProgramsScheduledForDeletion = clone $this->collStudyPrograms;
                $this->studyProgramsScheduledForDeletion->clear();
            }
            $this->studyProgramsScheduledForDeletion[]= clone $studyProgram;
            $studyProgram->setSubject(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Subject is new, it will return
     * an empty collection; or if this Subject has previously
     * been saved, it will retrieve related StudyPrograms from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Subject.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStudyProgram[] List of ChildStudyProgram objects
     */
    public function getStudyProgramsJoinCourse(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStudyProgramQuery::create(null, $criteria);
        $query->joinWith('Course', $joinBehavior);

        return $this->getStudyPrograms($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->code = null;
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
            if ($this->collSmsCallLogs) {
                foreach ($this->collSmsCallLogs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStudyPrograms) {
                foreach ($this->collStudyPrograms as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collApplications = null;
        $this->collEngagements = null;
        $this->collSmsCallLogs = null;
        $this->collStudyPrograms = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SubjectTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildSubject The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[SubjectTableMap::COL_UPDATED_AT] = true;

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
