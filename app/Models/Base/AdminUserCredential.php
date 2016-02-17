<?php

namespace App\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use App\Models\AdminCredential as ChildAdminCredential;
use App\Models\AdminCredentialQuery as ChildAdminCredentialQuery;
use App\Models\AdminUser as ChildAdminUser;
use App\Models\AdminUserCredential as ChildAdminUserCredential;
use App\Models\AdminUserCredentialQuery as ChildAdminUserCredentialQuery;
use App\Models\AdminUserQuery as ChildAdminUserQuery;
use App\Models\Map\AdminUserCredentialTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'admin_user_credential' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class AdminUserCredential implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\App\\Models\\Map\\AdminUserCredentialTableMap';


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
     * The value for the admin_user_id field.
     * @var        int
     */
    protected $admin_user_id;

    /**
     * The value for the admin_credential_id field.
     * @var        int
     */
    protected $admin_credential_id;

    /**
     * The value for the perm_read field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $perm_read;

    /**
     * The value for the perm_write field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $perm_write;

    /**
     * The value for the perm_exec field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $perm_exec;

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
     * @var        ChildAdminCredential
     */
    protected $aAdminCredential;

    /**
     * @var        ChildAdminUser
     */
    protected $aAdminUser;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->perm_read = 0;
        $this->perm_write = 0;
        $this->perm_exec = 0;
    }

    /**
     * Initializes internal state of App\Models\Base\AdminUserCredential object.
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
     * Compares this with another <code>AdminUserCredential</code> instance.  If
     * <code>obj</code> is an instance of <code>AdminUserCredential</code>, delegates to
     * <code>equals(AdminUserCredential)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|AdminUserCredential The current object, for fluid interface
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
     * Get the [admin_user_id] column value.
     *
     * @return int
     */
    public function getAdminUserId()
    {
        return $this->admin_user_id;
    }

    /**
     * Get the [admin_credential_id] column value.
     *
     * @return int
     */
    public function getAdminCredentialId()
    {
        return $this->admin_credential_id;
    }

    /**
     * Get the [perm_read] column value.
     *
     * @return int
     */
    public function getPermRead()
    {
        return $this->perm_read;
    }

    /**
     * Get the [perm_write] column value.
     *
     * @return int
     */
    public function getPermWrite()
    {
        return $this->perm_write;
    }

    /**
     * Get the [perm_exec] column value.
     *
     * @return int
     */
    public function getPermExec()
    {
        return $this->perm_exec;
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
     * Set the value of [admin_user_id] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\AdminUserCredential The current object (for fluent API support)
     */
    public function setAdminUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->admin_user_id !== $v) {
            $this->admin_user_id = $v;
            $this->modifiedColumns[AdminUserCredentialTableMap::COL_ADMIN_USER_ID] = true;
        }

        if ($this->aAdminUser !== null && $this->aAdminUser->getId() !== $v) {
            $this->aAdminUser = null;
        }

        return $this;
    } // setAdminUserId()

    /**
     * Set the value of [admin_credential_id] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\AdminUserCredential The current object (for fluent API support)
     */
    public function setAdminCredentialId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->admin_credential_id !== $v) {
            $this->admin_credential_id = $v;
            $this->modifiedColumns[AdminUserCredentialTableMap::COL_ADMIN_CREDENTIAL_ID] = true;
        }

        if ($this->aAdminCredential !== null && $this->aAdminCredential->getId() !== $v) {
            $this->aAdminCredential = null;
        }

        return $this;
    } // setAdminCredentialId()

    /**
     * Set the value of [perm_read] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\AdminUserCredential The current object (for fluent API support)
     */
    public function setPermRead($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->perm_read !== $v) {
            $this->perm_read = $v;
            $this->modifiedColumns[AdminUserCredentialTableMap::COL_PERM_READ] = true;
        }

        return $this;
    } // setPermRead()

    /**
     * Set the value of [perm_write] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\AdminUserCredential The current object (for fluent API support)
     */
    public function setPermWrite($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->perm_write !== $v) {
            $this->perm_write = $v;
            $this->modifiedColumns[AdminUserCredentialTableMap::COL_PERM_WRITE] = true;
        }

        return $this;
    } // setPermWrite()

    /**
     * Set the value of [perm_exec] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\AdminUserCredential The current object (for fluent API support)
     */
    public function setPermExec($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->perm_exec !== $v) {
            $this->perm_exec = $v;
            $this->modifiedColumns[AdminUserCredentialTableMap::COL_PERM_EXEC] = true;
        }

        return $this;
    } // setPermExec()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\AdminUserCredential The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AdminUserCredentialTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\AdminUserCredential The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AdminUserCredentialTableMap::COL_UPDATED_AT] = true;
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
            if ($this->perm_read !== 0) {
                return false;
            }

            if ($this->perm_write !== 0) {
                return false;
            }

            if ($this->perm_exec !== 0) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AdminUserCredentialTableMap::translateFieldName('AdminUserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->admin_user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AdminUserCredentialTableMap::translateFieldName('AdminCredentialId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->admin_credential_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AdminUserCredentialTableMap::translateFieldName('PermRead', TableMap::TYPE_PHPNAME, $indexType)];
            $this->perm_read = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AdminUserCredentialTableMap::translateFieldName('PermWrite', TableMap::TYPE_PHPNAME, $indexType)];
            $this->perm_write = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AdminUserCredentialTableMap::translateFieldName('PermExec', TableMap::TYPE_PHPNAME, $indexType)];
            $this->perm_exec = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AdminUserCredentialTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AdminUserCredentialTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = AdminUserCredentialTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Models\\AdminUserCredential'), 0, $e);
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
        if ($this->aAdminUser !== null && $this->admin_user_id !== $this->aAdminUser->getId()) {
            $this->aAdminUser = null;
        }
        if ($this->aAdminCredential !== null && $this->admin_credential_id !== $this->aAdminCredential->getId()) {
            $this->aAdminCredential = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(AdminUserCredentialTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAdminUserCredentialQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAdminCredential = null;
            $this->aAdminUser = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see AdminUserCredential::setDeleted()
     * @see AdminUserCredential::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AdminUserCredentialTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAdminUserCredentialQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AdminUserCredentialTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(AdminUserCredentialTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(AdminUserCredentialTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(AdminUserCredentialTableMap::COL_UPDATED_AT)) {
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
                AdminUserCredentialTableMap::addInstanceToPool($this);
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

            if ($this->aAdminCredential !== null) {
                if ($this->aAdminCredential->isModified() || $this->aAdminCredential->isNew()) {
                    $affectedRows += $this->aAdminCredential->save($con);
                }
                $this->setAdminCredential($this->aAdminCredential);
            }

            if ($this->aAdminUser !== null) {
                if ($this->aAdminUser->isModified() || $this->aAdminUser->isNew()) {
                    $affectedRows += $this->aAdminUser->save($con);
                }
                $this->setAdminUser($this->aAdminUser);
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AdminUserCredentialTableMap::COL_ADMIN_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'admin_user_id';
        }
        if ($this->isColumnModified(AdminUserCredentialTableMap::COL_ADMIN_CREDENTIAL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'admin_credential_id';
        }
        if ($this->isColumnModified(AdminUserCredentialTableMap::COL_PERM_READ)) {
            $modifiedColumns[':p' . $index++]  = 'perm_read';
        }
        if ($this->isColumnModified(AdminUserCredentialTableMap::COL_PERM_WRITE)) {
            $modifiedColumns[':p' . $index++]  = 'perm_write';
        }
        if ($this->isColumnModified(AdminUserCredentialTableMap::COL_PERM_EXEC)) {
            $modifiedColumns[':p' . $index++]  = 'perm_exec';
        }
        if ($this->isColumnModified(AdminUserCredentialTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(AdminUserCredentialTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO admin_user_credential (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'admin_user_id':
                        $stmt->bindValue($identifier, $this->admin_user_id, PDO::PARAM_INT);
                        break;
                    case 'admin_credential_id':
                        $stmt->bindValue($identifier, $this->admin_credential_id, PDO::PARAM_INT);
                        break;
                    case 'perm_read':
                        $stmt->bindValue($identifier, $this->perm_read, PDO::PARAM_INT);
                        break;
                    case 'perm_write':
                        $stmt->bindValue($identifier, $this->perm_write, PDO::PARAM_INT);
                        break;
                    case 'perm_exec':
                        $stmt->bindValue($identifier, $this->perm_exec, PDO::PARAM_INT);
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
        $pos = AdminUserCredentialTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getAdminUserId();
                break;
            case 1:
                return $this->getAdminCredentialId();
                break;
            case 2:
                return $this->getPermRead();
                break;
            case 3:
                return $this->getPermWrite();
                break;
            case 4:
                return $this->getPermExec();
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

        if (isset($alreadyDumpedObjects['AdminUserCredential'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AdminUserCredential'][$this->hashCode()] = true;
        $keys = AdminUserCredentialTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getAdminUserId(),
            $keys[1] => $this->getAdminCredentialId(),
            $keys[2] => $this->getPermRead(),
            $keys[3] => $this->getPermWrite(),
            $keys[4] => $this->getPermExec(),
            $keys[5] => $this->getCreatedAt(),
            $keys[6] => $this->getUpdatedAt(),
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

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAdminCredential) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'adminCredential';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'admin_credential';
                        break;
                    default:
                        $key = 'AdminCredential';
                }

                $result[$key] = $this->aAdminCredential->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAdminUser) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'adminUser';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'admin_user';
                        break;
                    default:
                        $key = 'AdminUser';
                }

                $result[$key] = $this->aAdminUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\App\Models\AdminUserCredential
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AdminUserCredentialTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\App\Models\AdminUserCredential
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setAdminUserId($value);
                break;
            case 1:
                $this->setAdminCredentialId($value);
                break;
            case 2:
                $this->setPermRead($value);
                break;
            case 3:
                $this->setPermWrite($value);
                break;
            case 4:
                $this->setPermExec($value);
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
        $keys = AdminUserCredentialTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setAdminUserId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setAdminCredentialId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPermRead($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPermWrite($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPermExec($arr[$keys[4]]);
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
     * @return $this|\App\Models\AdminUserCredential The current object, for fluid interface
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
        $criteria = new Criteria(AdminUserCredentialTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AdminUserCredentialTableMap::COL_ADMIN_USER_ID)) {
            $criteria->add(AdminUserCredentialTableMap::COL_ADMIN_USER_ID, $this->admin_user_id);
        }
        if ($this->isColumnModified(AdminUserCredentialTableMap::COL_ADMIN_CREDENTIAL_ID)) {
            $criteria->add(AdminUserCredentialTableMap::COL_ADMIN_CREDENTIAL_ID, $this->admin_credential_id);
        }
        if ($this->isColumnModified(AdminUserCredentialTableMap::COL_PERM_READ)) {
            $criteria->add(AdminUserCredentialTableMap::COL_PERM_READ, $this->perm_read);
        }
        if ($this->isColumnModified(AdminUserCredentialTableMap::COL_PERM_WRITE)) {
            $criteria->add(AdminUserCredentialTableMap::COL_PERM_WRITE, $this->perm_write);
        }
        if ($this->isColumnModified(AdminUserCredentialTableMap::COL_PERM_EXEC)) {
            $criteria->add(AdminUserCredentialTableMap::COL_PERM_EXEC, $this->perm_exec);
        }
        if ($this->isColumnModified(AdminUserCredentialTableMap::COL_CREATED_AT)) {
            $criteria->add(AdminUserCredentialTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(AdminUserCredentialTableMap::COL_UPDATED_AT)) {
            $criteria->add(AdminUserCredentialTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildAdminUserCredentialQuery::create();
        $criteria->add(AdminUserCredentialTableMap::COL_ADMIN_USER_ID, $this->admin_user_id);
        $criteria->add(AdminUserCredentialTableMap::COL_ADMIN_CREDENTIAL_ID, $this->admin_credential_id);

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
        $validPk = null !== $this->getAdminUserId() &&
            null !== $this->getAdminCredentialId();

        $validPrimaryKeyFKs = 2;
        $primaryKeyFKs = [];

        //relation fk_aduscd_adcd to table admin_credential
        if ($this->aAdminCredential && $hash = spl_object_hash($this->aAdminCredential)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        //relation fk_aduscd_adus to table admin_user
        if ($this->aAdminUser && $hash = spl_object_hash($this->aAdminUser)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getAdminUserId();
        $pks[1] = $this->getAdminCredentialId();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setAdminUserId($keys[0]);
        $this->setAdminCredentialId($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getAdminUserId()) && (null === $this->getAdminCredentialId());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \App\Models\AdminUserCredential (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAdminUserId($this->getAdminUserId());
        $copyObj->setAdminCredentialId($this->getAdminCredentialId());
        $copyObj->setPermRead($this->getPermRead());
        $copyObj->setPermWrite($this->getPermWrite());
        $copyObj->setPermExec($this->getPermExec());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());
        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return \App\Models\AdminUserCredential Clone of current object.
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
     * Declares an association between this object and a ChildAdminCredential object.
     *
     * @param  ChildAdminCredential $v
     * @return $this|\App\Models\AdminUserCredential The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAdminCredential(ChildAdminCredential $v = null)
    {
        if ($v === null) {
            $this->setAdminCredentialId(NULL);
        } else {
            $this->setAdminCredentialId($v->getId());
        }

        $this->aAdminCredential = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAdminCredential object, it will not be re-added.
        if ($v !== null) {
            $v->addAdminUserCredential($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAdminCredential object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildAdminCredential The associated ChildAdminCredential object.
     * @throws PropelException
     */
    public function getAdminCredential(ConnectionInterface $con = null)
    {
        if ($this->aAdminCredential === null && ($this->admin_credential_id !== null)) {
            $this->aAdminCredential = ChildAdminCredentialQuery::create()->findPk($this->admin_credential_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAdminCredential->addAdminUserCredentials($this);
             */
        }

        return $this->aAdminCredential;
    }

    /**
     * Declares an association between this object and a ChildAdminUser object.
     *
     * @param  ChildAdminUser $v
     * @return $this|\App\Models\AdminUserCredential The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAdminUser(ChildAdminUser $v = null)
    {
        if ($v === null) {
            $this->setAdminUserId(NULL);
        } else {
            $this->setAdminUserId($v->getId());
        }

        $this->aAdminUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAdminUser object, it will not be re-added.
        if ($v !== null) {
            $v->addAdminUserCredential($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAdminUser object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildAdminUser The associated ChildAdminUser object.
     * @throws PropelException
     */
    public function getAdminUser(ConnectionInterface $con = null)
    {
        if ($this->aAdminUser === null && ($this->admin_user_id !== null)) {
            $this->aAdminUser = ChildAdminUserQuery::create()->findPk($this->admin_user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAdminUser->addAdminUserCredentials($this);
             */
        }

        return $this->aAdminUser;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aAdminCredential) {
            $this->aAdminCredential->removeAdminUserCredential($this);
        }
        if (null !== $this->aAdminUser) {
            $this->aAdminUser->removeAdminUserCredential($this);
        }
        $this->admin_user_id = null;
        $this->admin_credential_id = null;
        $this->perm_read = null;
        $this->perm_write = null;
        $this->perm_exec = null;
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
        } // if ($deep)

        $this->aAdminCredential = null;
        $this->aAdminUser = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AdminUserCredentialTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildAdminUserCredential The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[AdminUserCredentialTableMap::COL_UPDATED_AT] = true;

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
