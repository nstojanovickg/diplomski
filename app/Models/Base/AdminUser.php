<?php

namespace App\Models\Base;

use \DateTime;
use \Exception;
use \PDO;
use App\Models\AdminUser as ChildAdminUser;
use App\Models\AdminUserCredential as ChildAdminUserCredential;
use App\Models\AdminUserCredentialQuery as ChildAdminUserCredentialQuery;
use App\Models\AdminUserQuery as ChildAdminUserQuery;
use App\Models\Professor as ChildProfessor;
use App\Models\ProfessorQuery as ChildProfessorQuery;
use App\Models\Student as ChildStudent;
use App\Models\StudentQuery as ChildStudentQuery;
use App\Models\TranslationLanguage as ChildTranslationLanguage;
use App\Models\TranslationLanguageQuery as ChildTranslationLanguageQuery;
use App\Models\Map\AdminUserTableMap;
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
 * Base class that represents a row from the 'admin_user' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class AdminUser implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\App\\Models\\Map\\AdminUserTableMap';


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
     * The value for the language_id field.
     * @var        int
     */
    protected $language_id;

    /**
     * The value for the professor_id field.
     * @var        int
     */
    protected $professor_id;

    /**
     * The value for the student_id field.
     * @var        int
     */
    protected $student_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the login field.
     * @var        string
     */
    protected $login;

    /**
     * The value for the password field.
     * @var        string
     */
    protected $password;

    /**
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the status field.
     * Note: this column has a database default value of: 'NEW'
     * @var        string
     */
    protected $status;

    /**
     * The value for the remember_token field.
     * @var        string
     */
    protected $remember_token;

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
     * @var        ChildProfessor
     */
    protected $aProfessor;

    /**
     * @var        ChildStudent
     */
    protected $aStudent;

    /**
     * @var        ChildTranslationLanguage
     */
    protected $aTranslationLanguage;

    /**
     * @var        ObjectCollection|ChildAdminUserCredential[] Collection to store aggregation of ChildAdminUserCredential objects.
     */
    protected $collAdminUserCredentials;
    protected $collAdminUserCredentialsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAdminUserCredential[]
     */
    protected $adminUserCredentialsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->status = 'NEW';
    }

    /**
     * Initializes internal state of App\Models\Base\AdminUser object.
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
     * Compares this with another <code>AdminUser</code> instance.  If
     * <code>obj</code> is an instance of <code>AdminUser</code>, delegates to
     * <code>equals(AdminUser)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|AdminUser The current object, for fluid interface
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
     * Get the [language_id] column value.
     *
     * @return int
     */
    public function getLanguageId()
    {
        return $this->language_id;
    }

    /**
     * Get the [professor_id] column value.
     *
     * @return int
     */
    public function getProfessorId()
    {
        return $this->professor_id;
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
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [login] column value.
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Get the [password] column value.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [status] column value.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the [remember_token] column value.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
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
     * @return $this|\App\Models\AdminUser The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[AdminUserTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [language_id] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\AdminUser The current object (for fluent API support)
     */
    public function setLanguageId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->language_id !== $v) {
            $this->language_id = $v;
            $this->modifiedColumns[AdminUserTableMap::COL_LANGUAGE_ID] = true;
        }

        if ($this->aTranslationLanguage !== null && $this->aTranslationLanguage->getId() !== $v) {
            $this->aTranslationLanguage = null;
        }

        return $this;
    } // setLanguageId()

    /**
     * Set the value of [professor_id] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\AdminUser The current object (for fluent API support)
     */
    public function setProfessorId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->professor_id !== $v) {
            $this->professor_id = $v;
            $this->modifiedColumns[AdminUserTableMap::COL_PROFESSOR_ID] = true;
        }

        if ($this->aProfessor !== null && $this->aProfessor->getId() !== $v) {
            $this->aProfessor = null;
        }

        return $this;
    } // setProfessorId()

    /**
     * Set the value of [student_id] column.
     *
     * @param int $v new value
     * @return $this|\App\Models\AdminUser The current object (for fluent API support)
     */
    public function setStudentId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->student_id !== $v) {
            $this->student_id = $v;
            $this->modifiedColumns[AdminUserTableMap::COL_STUDENT_ID] = true;
        }

        if ($this->aStudent !== null && $this->aStudent->getId() !== $v) {
            $this->aStudent = null;
        }

        return $this;
    } // setStudentId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\App\Models\AdminUser The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[AdminUserTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [login] column.
     *
     * @param string $v new value
     * @return $this|\App\Models\AdminUser The current object (for fluent API support)
     */
    public function setLogin($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->login !== $v) {
            $this->login = $v;
            $this->modifiedColumns[AdminUserTableMap::COL_LOGIN] = true;
        }

        return $this;
    } // setLogin()

    /**
     * Set the value of [password] column.
     *
     * @param string $v new value
     * @return $this|\App\Models\AdminUser The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[AdminUserTableMap::COL_PASSWORD] = true;
        }

        return $this;
    } // setPassword()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\App\Models\AdminUser The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[AdminUserTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [status] column.
     *
     * @param string $v new value
     * @return $this|\App\Models\AdminUser The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[AdminUserTableMap::COL_STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Set the value of [remember_token] column.
     *
     * @param string $v new value
     * @return $this|\App\Models\AdminUser The current object (for fluent API support)
     */
    public function setRememberToken($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->remember_token !== $v) {
            $this->remember_token = $v;
            $this->modifiedColumns[AdminUserTableMap::COL_REMEMBER_TOKEN] = true;
        }

        return $this;
    } // setRememberToken()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\AdminUser The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AdminUserTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\App\Models\AdminUser The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[AdminUserTableMap::COL_UPDATED_AT] = true;
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
            if ($this->status !== 'NEW') {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AdminUserTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AdminUserTableMap::translateFieldName('LanguageId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->language_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AdminUserTableMap::translateFieldName('ProfessorId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->professor_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AdminUserTableMap::translateFieldName('StudentId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->student_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AdminUserTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : AdminUserTableMap::translateFieldName('Login', TableMap::TYPE_PHPNAME, $indexType)];
            $this->login = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : AdminUserTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : AdminUserTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : AdminUserTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : AdminUserTableMap::translateFieldName('RememberToken', TableMap::TYPE_PHPNAME, $indexType)];
            $this->remember_token = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : AdminUserTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : AdminUserTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 12; // 12 = AdminUserTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\App\\Models\\AdminUser'), 0, $e);
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
        if ($this->aTranslationLanguage !== null && $this->language_id !== $this->aTranslationLanguage->getId()) {
            $this->aTranslationLanguage = null;
        }
        if ($this->aProfessor !== null && $this->professor_id !== $this->aProfessor->getId()) {
            $this->aProfessor = null;
        }
        if ($this->aStudent !== null && $this->student_id !== $this->aStudent->getId()) {
            $this->aStudent = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(AdminUserTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAdminUserQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aProfessor = null;
            $this->aStudent = null;
            $this->aTranslationLanguage = null;
            $this->collAdminUserCredentials = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see AdminUser::setDeleted()
     * @see AdminUser::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AdminUserTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAdminUserQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AdminUserTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(AdminUserTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(AdminUserTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(AdminUserTableMap::COL_UPDATED_AT)) {
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
                AdminUserTableMap::addInstanceToPool($this);
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

            if ($this->aProfessor !== null) {
                if ($this->aProfessor->isModified() || $this->aProfessor->isNew()) {
                    $affectedRows += $this->aProfessor->save($con);
                }
                $this->setProfessor($this->aProfessor);
            }

            if ($this->aStudent !== null) {
                if ($this->aStudent->isModified() || $this->aStudent->isNew()) {
                    $affectedRows += $this->aStudent->save($con);
                }
                $this->setStudent($this->aStudent);
            }

            if ($this->aTranslationLanguage !== null) {
                if ($this->aTranslationLanguage->isModified() || $this->aTranslationLanguage->isNew()) {
                    $affectedRows += $this->aTranslationLanguage->save($con);
                }
                $this->setTranslationLanguage($this->aTranslationLanguage);
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

            if ($this->adminUserCredentialsScheduledForDeletion !== null) {
                if (!$this->adminUserCredentialsScheduledForDeletion->isEmpty()) {
                    \App\Models\AdminUserCredentialQuery::create()
                        ->filterByPrimaryKeys($this->adminUserCredentialsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->adminUserCredentialsScheduledForDeletion = null;
                }
            }

            if ($this->collAdminUserCredentials !== null) {
                foreach ($this->collAdminUserCredentials as $referrerFK) {
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

        $this->modifiedColumns[AdminUserTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AdminUserTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AdminUserTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_LANGUAGE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'language_id';
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_PROFESSOR_ID)) {
            $modifiedColumns[':p' . $index++]  = 'professor_id';
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_STUDENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'student_id';
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_LOGIN)) {
            $modifiedColumns[':p' . $index++]  = 'login';
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'password';
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'status';
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_REMEMBER_TOKEN)) {
            $modifiedColumns[':p' . $index++]  = 'remember_token';
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO admin_user (%s) VALUES (%s)',
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
                    case 'language_id':
                        $stmt->bindValue($identifier, $this->language_id, PDO::PARAM_INT);
                        break;
                    case 'professor_id':
                        $stmt->bindValue($identifier, $this->professor_id, PDO::PARAM_INT);
                        break;
                    case 'student_id':
                        $stmt->bindValue($identifier, $this->student_id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'login':
                        $stmt->bindValue($identifier, $this->login, PDO::PARAM_STR);
                        break;
                    case 'password':
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'status':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_STR);
                        break;
                    case 'remember_token':
                        $stmt->bindValue($identifier, $this->remember_token, PDO::PARAM_STR);
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
        $pos = AdminUserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getLanguageId();
                break;
            case 2:
                return $this->getProfessorId();
                break;
            case 3:
                return $this->getStudentId();
                break;
            case 4:
                return $this->getName();
                break;
            case 5:
                return $this->getLogin();
                break;
            case 6:
                return $this->getPassword();
                break;
            case 7:
                return $this->getEmail();
                break;
            case 8:
                return $this->getStatus();
                break;
            case 9:
                return $this->getRememberToken();
                break;
            case 10:
                return $this->getCreatedAt();
                break;
            case 11:
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

        if (isset($alreadyDumpedObjects['AdminUser'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AdminUser'][$this->hashCode()] = true;
        $keys = AdminUserTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getLanguageId(),
            $keys[2] => $this->getProfessorId(),
            $keys[3] => $this->getStudentId(),
            $keys[4] => $this->getName(),
            $keys[5] => $this->getLogin(),
            $keys[6] => $this->getPassword(),
            $keys[7] => $this->getEmail(),
            $keys[8] => $this->getStatus(),
            $keys[9] => $this->getRememberToken(),
            $keys[10] => $this->getCreatedAt(),
            $keys[11] => $this->getUpdatedAt(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[10]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[10]];
            $result[$keys[10]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[11]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[11]];
            $result[$keys[11]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aProfessor) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'professor';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'professor';
                        break;
                    default:
                        $key = 'Professor';
                }

                $result[$key] = $this->aProfessor->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
            if (null !== $this->aTranslationLanguage) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'translationLanguage';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'translation_language';
                        break;
                    default:
                        $key = 'TranslationLanguage';
                }

                $result[$key] = $this->aTranslationLanguage->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAdminUserCredentials) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'adminUserCredentials';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'admin_user_credentials';
                        break;
                    default:
                        $key = 'AdminUserCredentials';
                }

                $result[$key] = $this->collAdminUserCredentials->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\App\Models\AdminUser
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AdminUserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\App\Models\AdminUser
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setLanguageId($value);
                break;
            case 2:
                $this->setProfessorId($value);
                break;
            case 3:
                $this->setStudentId($value);
                break;
            case 4:
                $this->setName($value);
                break;
            case 5:
                $this->setLogin($value);
                break;
            case 6:
                $this->setPassword($value);
                break;
            case 7:
                $this->setEmail($value);
                break;
            case 8:
                $this->setStatus($value);
                break;
            case 9:
                $this->setRememberToken($value);
                break;
            case 10:
                $this->setCreatedAt($value);
                break;
            case 11:
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
        $keys = AdminUserTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setLanguageId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setProfessorId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setStudentId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setName($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setLogin($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setPassword($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setEmail($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setStatus($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setRememberToken($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setCreatedAt($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setUpdatedAt($arr[$keys[11]]);
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
     * @return $this|\App\Models\AdminUser The current object, for fluid interface
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
        $criteria = new Criteria(AdminUserTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AdminUserTableMap::COL_ID)) {
            $criteria->add(AdminUserTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_LANGUAGE_ID)) {
            $criteria->add(AdminUserTableMap::COL_LANGUAGE_ID, $this->language_id);
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_PROFESSOR_ID)) {
            $criteria->add(AdminUserTableMap::COL_PROFESSOR_ID, $this->professor_id);
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_STUDENT_ID)) {
            $criteria->add(AdminUserTableMap::COL_STUDENT_ID, $this->student_id);
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_NAME)) {
            $criteria->add(AdminUserTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_LOGIN)) {
            $criteria->add(AdminUserTableMap::COL_LOGIN, $this->login);
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_PASSWORD)) {
            $criteria->add(AdminUserTableMap::COL_PASSWORD, $this->password);
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_EMAIL)) {
            $criteria->add(AdminUserTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_STATUS)) {
            $criteria->add(AdminUserTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_REMEMBER_TOKEN)) {
            $criteria->add(AdminUserTableMap::COL_REMEMBER_TOKEN, $this->remember_token);
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_CREATED_AT)) {
            $criteria->add(AdminUserTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(AdminUserTableMap::COL_UPDATED_AT)) {
            $criteria->add(AdminUserTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildAdminUserQuery::create();
        $criteria->add(AdminUserTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \App\Models\AdminUser (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setLanguageId($this->getLanguageId());
        $copyObj->setProfessorId($this->getProfessorId());
        $copyObj->setStudentId($this->getStudentId());
        $copyObj->setName($this->getName());
        $copyObj->setLogin($this->getLogin());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setRememberToken($this->getRememberToken());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAdminUserCredentials() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdminUserCredential($relObj->copy($deepCopy));
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
     * @return \App\Models\AdminUser Clone of current object.
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
     * Declares an association between this object and a ChildProfessor object.
     *
     * @param  ChildProfessor $v
     * @return $this|\App\Models\AdminUser The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProfessor(ChildProfessor $v = null)
    {
        if ($v === null) {
            $this->setProfessorId(NULL);
        } else {
            $this->setProfessorId($v->getId());
        }

        $this->aProfessor = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildProfessor object, it will not be re-added.
        if ($v !== null) {
            $v->addAdminUser($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildProfessor object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildProfessor The associated ChildProfessor object.
     * @throws PropelException
     */
    public function getProfessor(ConnectionInterface $con = null)
    {
        if ($this->aProfessor === null && ($this->professor_id !== null)) {
            $this->aProfessor = ChildProfessorQuery::create()->findPk($this->professor_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProfessor->addAdminUsers($this);
             */
        }

        return $this->aProfessor;
    }

    /**
     * Declares an association between this object and a ChildStudent object.
     *
     * @param  ChildStudent $v
     * @return $this|\App\Models\AdminUser The current object (for fluent API support)
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
            $v->addAdminUser($this);
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
                $this->aStudent->addAdminUsers($this);
             */
        }

        return $this->aStudent;
    }

    /**
     * Declares an association between this object and a ChildTranslationLanguage object.
     *
     * @param  ChildTranslationLanguage $v
     * @return $this|\App\Models\AdminUser The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTranslationLanguage(ChildTranslationLanguage $v = null)
    {
        if ($v === null) {
            $this->setLanguageId(NULL);
        } else {
            $this->setLanguageId($v->getId());
        }

        $this->aTranslationLanguage = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTranslationLanguage object, it will not be re-added.
        if ($v !== null) {
            $v->addAdminUser($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTranslationLanguage object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTranslationLanguage The associated ChildTranslationLanguage object.
     * @throws PropelException
     */
    public function getTranslationLanguage(ConnectionInterface $con = null)
    {
        if ($this->aTranslationLanguage === null && ($this->language_id !== null)) {
            $this->aTranslationLanguage = ChildTranslationLanguageQuery::create()->findPk($this->language_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTranslationLanguage->addAdminUsers($this);
             */
        }

        return $this->aTranslationLanguage;
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
        if ('AdminUserCredential' == $relationName) {
            return $this->initAdminUserCredentials();
        }
    }

    /**
     * Clears out the collAdminUserCredentials collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAdminUserCredentials()
     */
    public function clearAdminUserCredentials()
    {
        $this->collAdminUserCredentials = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAdminUserCredentials collection loaded partially.
     */
    public function resetPartialAdminUserCredentials($v = true)
    {
        $this->collAdminUserCredentialsPartial = $v;
    }

    /**
     * Initializes the collAdminUserCredentials collection.
     *
     * By default this just sets the collAdminUserCredentials collection to an empty array (like clearcollAdminUserCredentials());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdminUserCredentials($overrideExisting = true)
    {
        if (null !== $this->collAdminUserCredentials && !$overrideExisting) {
            return;
        }
        $this->collAdminUserCredentials = new ObjectCollection();
        $this->collAdminUserCredentials->setModel('\App\Models\AdminUserCredential');
    }

    /**
     * Gets an array of ChildAdminUserCredential objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAdminUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAdminUserCredential[] List of ChildAdminUserCredential objects
     * @throws PropelException
     */
    public function getAdminUserCredentials(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAdminUserCredentialsPartial && !$this->isNew();
        if (null === $this->collAdminUserCredentials || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdminUserCredentials) {
                // return empty collection
                $this->initAdminUserCredentials();
            } else {
                $collAdminUserCredentials = ChildAdminUserCredentialQuery::create(null, $criteria)
                    ->filterByAdminUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAdminUserCredentialsPartial && count($collAdminUserCredentials)) {
                        $this->initAdminUserCredentials(false);

                        foreach ($collAdminUserCredentials as $obj) {
                            if (false == $this->collAdminUserCredentials->contains($obj)) {
                                $this->collAdminUserCredentials->append($obj);
                            }
                        }

                        $this->collAdminUserCredentialsPartial = true;
                    }

                    return $collAdminUserCredentials;
                }

                if ($partial && $this->collAdminUserCredentials) {
                    foreach ($this->collAdminUserCredentials as $obj) {
                        if ($obj->isNew()) {
                            $collAdminUserCredentials[] = $obj;
                        }
                    }
                }

                $this->collAdminUserCredentials = $collAdminUserCredentials;
                $this->collAdminUserCredentialsPartial = false;
            }
        }

        return $this->collAdminUserCredentials;
    }

    /**
     * Sets a collection of ChildAdminUserCredential objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $adminUserCredentials A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildAdminUser The current object (for fluent API support)
     */
    public function setAdminUserCredentials(Collection $adminUserCredentials, ConnectionInterface $con = null)
    {
        /** @var ChildAdminUserCredential[] $adminUserCredentialsToDelete */
        $adminUserCredentialsToDelete = $this->getAdminUserCredentials(new Criteria(), $con)->diff($adminUserCredentials);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->adminUserCredentialsScheduledForDeletion = clone $adminUserCredentialsToDelete;

        foreach ($adminUserCredentialsToDelete as $adminUserCredentialRemoved) {
            $adminUserCredentialRemoved->setAdminUser(null);
        }

        $this->collAdminUserCredentials = null;
        foreach ($adminUserCredentials as $adminUserCredential) {
            $this->addAdminUserCredential($adminUserCredential);
        }

        $this->collAdminUserCredentials = $adminUserCredentials;
        $this->collAdminUserCredentialsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AdminUserCredential objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related AdminUserCredential objects.
     * @throws PropelException
     */
    public function countAdminUserCredentials(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAdminUserCredentialsPartial && !$this->isNew();
        if (null === $this->collAdminUserCredentials || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdminUserCredentials) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdminUserCredentials());
            }

            $query = ChildAdminUserCredentialQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAdminUser($this)
                ->count($con);
        }

        return count($this->collAdminUserCredentials);
    }

    /**
     * Method called to associate a ChildAdminUserCredential object to this object
     * through the ChildAdminUserCredential foreign key attribute.
     *
     * @param  ChildAdminUserCredential $l ChildAdminUserCredential
     * @return $this|\App\Models\AdminUser The current object (for fluent API support)
     */
    public function addAdminUserCredential(ChildAdminUserCredential $l)
    {
        if ($this->collAdminUserCredentials === null) {
            $this->initAdminUserCredentials();
            $this->collAdminUserCredentialsPartial = true;
        }

        if (!$this->collAdminUserCredentials->contains($l)) {
            $this->doAddAdminUserCredential($l);
        }

        return $this;
    }

    /**
     * @param ChildAdminUserCredential $adminUserCredential The ChildAdminUserCredential object to add.
     */
    protected function doAddAdminUserCredential(ChildAdminUserCredential $adminUserCredential)
    {
        $this->collAdminUserCredentials[]= $adminUserCredential;
        $adminUserCredential->setAdminUser($this);
    }

    /**
     * @param  ChildAdminUserCredential $adminUserCredential The ChildAdminUserCredential object to remove.
     * @return $this|ChildAdminUser The current object (for fluent API support)
     */
    public function removeAdminUserCredential(ChildAdminUserCredential $adminUserCredential)
    {
        if ($this->getAdminUserCredentials()->contains($adminUserCredential)) {
            $pos = $this->collAdminUserCredentials->search($adminUserCredential);
            $this->collAdminUserCredentials->remove($pos);
            if (null === $this->adminUserCredentialsScheduledForDeletion) {
                $this->adminUserCredentialsScheduledForDeletion = clone $this->collAdminUserCredentials;
                $this->adminUserCredentialsScheduledForDeletion->clear();
            }
            $this->adminUserCredentialsScheduledForDeletion[]= clone $adminUserCredential;
            $adminUserCredential->setAdminUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this AdminUser is new, it will return
     * an empty collection; or if this AdminUser has previously
     * been saved, it will retrieve related AdminUserCredentials from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AdminUser.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAdminUserCredential[] List of ChildAdminUserCredential objects
     */
    public function getAdminUserCredentialsJoinAdminCredential(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAdminUserCredentialQuery::create(null, $criteria);
        $query->joinWith('AdminCredential', $joinBehavior);

        return $this->getAdminUserCredentials($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aProfessor) {
            $this->aProfessor->removeAdminUser($this);
        }
        if (null !== $this->aStudent) {
            $this->aStudent->removeAdminUser($this);
        }
        if (null !== $this->aTranslationLanguage) {
            $this->aTranslationLanguage->removeAdminUser($this);
        }
        $this->id = null;
        $this->language_id = null;
        $this->professor_id = null;
        $this->student_id = null;
        $this->name = null;
        $this->login = null;
        $this->password = null;
        $this->email = null;
        $this->status = null;
        $this->remember_token = null;
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
            if ($this->collAdminUserCredentials) {
                foreach ($this->collAdminUserCredentials as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAdminUserCredentials = null;
        $this->aProfessor = null;
        $this->aStudent = null;
        $this->aTranslationLanguage = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AdminUserTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildAdminUser The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[AdminUserTableMap::COL_UPDATED_AT] = true;

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
