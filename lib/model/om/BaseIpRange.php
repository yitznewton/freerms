<?php

/**
 * Base class that represents a row from the 'ip_ranges' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Tue May 11 17:37:53 2010
 *
 * @package    lib.model.om
 */
abstract class BaseIpRange extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        IpRangePeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the lib_id field.
	 * @var        int
	 */
	protected $lib_id;

	/**
	 * The value for the start_ip field.
	 * @var        string
	 */
	protected $start_ip;

	/**
	 * The value for the end_ip field.
	 * @var        string
	 */
	protected $end_ip;

	/**
	 * The value for the active_indicator field.
	 * Note: this column has a database default value of: true
	 * @var        boolean
	 */
	protected $active_indicator;

	/**
	 * The value for the proxy_indicator field.
	 * Note: this column has a database default value of: false
	 * @var        boolean
	 */
	protected $proxy_indicator;

	/**
	 * The value for the note field.
	 * @var        string
	 */
	protected $note;

	/**
	 * The value for the updated_at field.
	 * @var        string
	 */
	protected $updated_at;

	/**
	 * @var        Library
	 */
	protected $aLibrary;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	// symfony behavior
	
	const PEER = 'IpRangePeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->active_indicator = true;
		$this->proxy_indicator = false;
	}

	/**
	 * Initializes internal state of BaseIpRange object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get the [lib_id] column value.
	 * 
	 * @return     int
	 */
	public function getLibId()
	{
		return $this->lib_id;
	}

	/**
	 * Get the [start_ip] column value.
	 * 
	 * @return     string
	 */
	public function getStartIp()
	{
		return $this->start_ip;
	}

	/**
	 * Get the [end_ip] column value.
	 * 
	 * @return     string
	 */
	public function getEndIp()
	{
		return $this->end_ip;
	}

	/**
	 * Get the [active_indicator] column value.
	 * 
	 * @return     boolean
	 */
	public function getActiveIndicator()
	{
		return $this->active_indicator;
	}

	/**
	 * Get the [proxy_indicator] column value.
	 * 
	 * @return     boolean
	 */
	public function getProxyIndicator()
	{
		return $this->proxy_indicator;
	}

	/**
	 * Get the [note] column value.
	 * 
	 * @return     string
	 */
	public function getNote()
	{
		return $this->note;
	}

	/**
	 * Get the [optionally formatted] temporal [updated_at] column value.
	 * 
	 *
	 * @param      string $format The date/time format string (either date()-style or strftime()-style).
	 *							If format is NULL, then the raw DateTime object will be returned.
	 * @return     mixed Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
	 * @throws     PropelException - if unable to parse/validate the date/time value.
	 */
	public function getUpdatedAt($format = 'Y-m-d H:i:s')
	{
		if ($this->updated_at === null) {
			return null;
		}


		if ($this->updated_at === '0000-00-00 00:00:00') {
			// while technically this is not a default value of NULL,
			// this seems to be closest in meaning.
			return null;
		} else {
			try {
				$dt = new DateTime($this->updated_at);
			} catch (Exception $x) {
				throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
			}
		}

		if ($format === null) {
			// Because propel.useDateTimeClass is TRUE, we return a DateTime object.
			return $dt;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $dt->format('U'));
		} else {
			return $dt->format($format);
		}
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     IpRange The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = IpRangePeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [lib_id] column.
	 * 
	 * @param      int $v new value
	 * @return     IpRange The current object (for fluent API support)
	 */
	public function setLibId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->lib_id !== $v) {
			$this->lib_id = $v;
			$this->modifiedColumns[] = IpRangePeer::LIB_ID;
		}

		if ($this->aLibrary !== null && $this->aLibrary->getId() !== $v) {
			$this->aLibrary = null;
		}

		return $this;
	} // setLibId()

	/**
	 * Set the value of [start_ip] column.
	 * 
	 * @param      string $v new value
	 * @return     IpRange The current object (for fluent API support)
	 */
	public function setStartIp($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->start_ip !== $v) {
			$this->start_ip = $v;
			$this->modifiedColumns[] = IpRangePeer::START_IP;
		}

		return $this;
	} // setStartIp()

	/**
	 * Set the value of [end_ip] column.
	 * 
	 * @param      string $v new value
	 * @return     IpRange The current object (for fluent API support)
	 */
	public function setEndIp($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->end_ip !== $v) {
			$this->end_ip = $v;
			$this->modifiedColumns[] = IpRangePeer::END_IP;
		}

		return $this;
	} // setEndIp()

	/**
	 * Set the value of [active_indicator] column.
	 * 
	 * @param      boolean $v new value
	 * @return     IpRange The current object (for fluent API support)
	 */
	public function setActiveIndicator($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->active_indicator !== $v || $this->isNew()) {
			$this->active_indicator = $v;
			$this->modifiedColumns[] = IpRangePeer::ACTIVE_INDICATOR;
		}

		return $this;
	} // setActiveIndicator()

	/**
	 * Set the value of [proxy_indicator] column.
	 * 
	 * @param      boolean $v new value
	 * @return     IpRange The current object (for fluent API support)
	 */
	public function setProxyIndicator($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->proxy_indicator !== $v || $this->isNew()) {
			$this->proxy_indicator = $v;
			$this->modifiedColumns[] = IpRangePeer::PROXY_INDICATOR;
		}

		return $this;
	} // setProxyIndicator()

	/**
	 * Set the value of [note] column.
	 * 
	 * @param      string $v new value
	 * @return     IpRange The current object (for fluent API support)
	 */
	public function setNote($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->note !== $v) {
			$this->note = $v;
			$this->modifiedColumns[] = IpRangePeer::NOTE;
		}

		return $this;
	} // setNote()

	/**
	 * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
	 * 
	 * @param      mixed $v string, integer (timestamp), or DateTime value.  Empty string will
	 *						be treated as NULL for temporal objects.
	 * @return     IpRange The current object (for fluent API support)
	 */
	public function setUpdatedAt($v)
	{
		// we treat '' as NULL for temporal objects because DateTime('') == DateTime('now')
		// -- which is unexpected, to say the least.
		if ($v === null || $v === '') {
			$dt = null;
		} elseif ($v instanceof DateTime) {
			$dt = $v;
		} else {
			// some string/numeric value passed; we normalize that so that we can
			// validate it.
			try {
				if (is_numeric($v)) { // if it's a unix timestamp
					$dt = new DateTime('@'.$v, new DateTimeZone('UTC'));
					// We have to explicitly specify and then change the time zone because of a
					// DateTime bug: http://bugs.php.net/bug.php?id=43003
					$dt->setTimeZone(new DateTimeZone(date_default_timezone_get()));
				} else {
					$dt = new DateTime($v);
				}
			} catch (Exception $x) {
				throw new PropelException('Error parsing date/time value: ' . var_export($v, true), $x);
			}
		}

		if ( $this->updated_at !== null || $dt !== null ) {
			// (nested ifs are a little easier to read in this case)

			$currNorm = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
			$newNorm = ($dt !== null) ? $dt->format('Y-m-d H:i:s') : null;

			if ( ($currNorm !== $newNorm) // normalized values don't match 
					)
			{
				$this->updated_at = ($dt ? $dt->format('Y-m-d H:i:s') : null);
				$this->modifiedColumns[] = IpRangePeer::UPDATED_AT;
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
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			if ($this->active_indicator !== true) {
				return false;
			}

			if ($this->proxy_indicator !== false) {
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
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->lib_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
			$this->start_ip = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->end_ip = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->active_indicator = ($row[$startcol + 4] !== null) ? (boolean) $row[$startcol + 4] : null;
			$this->proxy_indicator = ($row[$startcol + 5] !== null) ? (boolean) $row[$startcol + 5] : null;
			$this->note = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
			$this->updated_at = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 8; // 8 = IpRangePeer::NUM_COLUMNS - IpRangePeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating IpRange object", $e);
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
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

		if ($this->aLibrary !== null && $this->lib_id !== $this->aLibrary->getId()) {
			$this->aLibrary = null;
		}
	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(IpRangePeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = IpRangePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aLibrary = null;
		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(IpRangePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseIpRange:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				IpRangePeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseIpRange:delete:post') as $callable)
				{
				  call_user_func($callable, $this, $con);
				}

				$this->setDeleted(true);
				$con->commit();
			} else {
				$con->commit();
			}
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(IpRangePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseIpRange:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    $con->commit();
			
			    return $affectedRows;
			  }
			}

			// symfony_timestampable behavior
			if ($this->isModified() && !$this->isColumnModified(IpRangePeer::UPDATED_AT))
			{
			  $this->setUpdatedAt(time());
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
				// symfony_timestampable behavior
				
			} else {
				$ret = $ret && $this->preUpdate($con);
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseIpRange:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				IpRangePeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			// We call the save method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aLibrary !== null) {
				if ($this->aLibrary->isModified() || $this->aLibrary->isNew()) {
					$affectedRows += $this->aLibrary->save($con);
				}
				$this->setLibrary($this->aLibrary);
			}

			if ($this->isNew() ) {
				$this->modifiedColumns[] = IpRangePeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = IpRangePeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += IpRangePeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			// We call the validate method on the following object(s) if they
			// were passed to this object by their coresponding set
			// method.  This object relates to these object(s) by a
			// foreign key reference.

			if ($this->aLibrary !== null) {
				if (!$this->aLibrary->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aLibrary->getValidationFailures());
				}
			}


			if (($retval = IpRangePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = IpRangePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getLibId();
				break;
			case 2:
				return $this->getStartIp();
				break;
			case 3:
				return $this->getEndIp();
				break;
			case 4:
				return $this->getActiveIndicator();
				break;
			case 5:
				return $this->getProxyIndicator();
				break;
			case 6:
				return $this->getNote();
				break;
			case 7:
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
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = IpRangePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getLibId(),
			$keys[2] => $this->getStartIp(),
			$keys[3] => $this->getEndIp(),
			$keys[4] => $this->getActiveIndicator(),
			$keys[5] => $this->getProxyIndicator(),
			$keys[6] => $this->getNote(),
			$keys[7] => $this->getUpdatedAt(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = IpRangePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setLibId($value);
				break;
			case 2:
				$this->setStartIp($value);
				break;
			case 3:
				$this->setEndIp($value);
				break;
			case 4:
				$this->setActiveIndicator($value);
				break;
			case 5:
				$this->setProxyIndicator($value);
				break;
			case 6:
				$this->setNote($value);
				break;
			case 7:
				$this->setUpdatedAt($value);
				break;
		} // switch()
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
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = IpRangePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setLibId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setStartIp($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setEndIp($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setActiveIndicator($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setProxyIndicator($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setNote($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setUpdatedAt($arr[$keys[7]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(IpRangePeer::DATABASE_NAME);

		if ($this->isColumnModified(IpRangePeer::ID)) $criteria->add(IpRangePeer::ID, $this->id);
		if ($this->isColumnModified(IpRangePeer::LIB_ID)) $criteria->add(IpRangePeer::LIB_ID, $this->lib_id);
		if ($this->isColumnModified(IpRangePeer::START_IP)) $criteria->add(IpRangePeer::START_IP, $this->start_ip);
		if ($this->isColumnModified(IpRangePeer::END_IP)) $criteria->add(IpRangePeer::END_IP, $this->end_ip);
		if ($this->isColumnModified(IpRangePeer::ACTIVE_INDICATOR)) $criteria->add(IpRangePeer::ACTIVE_INDICATOR, $this->active_indicator);
		if ($this->isColumnModified(IpRangePeer::PROXY_INDICATOR)) $criteria->add(IpRangePeer::PROXY_INDICATOR, $this->proxy_indicator);
		if ($this->isColumnModified(IpRangePeer::NOTE)) $criteria->add(IpRangePeer::NOTE, $this->note);
		if ($this->isColumnModified(IpRangePeer::UPDATED_AT)) $criteria->add(IpRangePeer::UPDATED_AT, $this->updated_at);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(IpRangePeer::DATABASE_NAME);

		$criteria->add(IpRangePeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of IpRange (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setLibId($this->lib_id);

		$copyObj->setStartIp($this->start_ip);

		$copyObj->setEndIp($this->end_ip);

		$copyObj->setActiveIndicator($this->active_indicator);

		$copyObj->setProxyIndicator($this->proxy_indicator);

		$copyObj->setNote($this->note);

		$copyObj->setUpdatedAt($this->updated_at);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a auto-increment column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     IpRange Clone of current object.
	 * @throws     PropelException
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
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     IpRangePeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new IpRangePeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a Library object.
	 *
	 * @param      Library $v
	 * @return     IpRange The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setLibrary(Library $v = null)
	{
		if ($v === null) {
			$this->setLibId(NULL);
		} else {
			$this->setLibId($v->getId());
		}

		$this->aLibrary = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Library object, it will not be re-added.
		if ($v !== null) {
			$v->addIpRange($this);
		}

		return $this;
	}


	/**
	 * Get the associated Library object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Library The associated Library object.
	 * @throws     PropelException
	 */
	public function getLibrary(PropelPDO $con = null)
	{
		if ($this->aLibrary === null && ($this->lib_id !== null)) {
			$this->aLibrary = LibraryPeer::retrieveByPk($this->lib_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aLibrary->addIpRanges($this);
			 */
		}
		return $this->aLibrary;
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} // if ($deep)

			$this->aLibrary = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseIpRange:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseIpRange::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseIpRange
