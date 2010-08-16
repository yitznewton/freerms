<?php

/**
 * Base class that represents a row from the 'auth_methods' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * 06/16/10 14:35:38
 *
 * @package    lib.model.om
 */
abstract class BaseAuthMethod extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        AuthMethodPeer
	 */
	protected static $peer;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * The value for the label field.
	 * @var        string
	 */
	protected $label;

	/**
	 * The value for the is_valid_onsite field.
	 * Note: this column has a database default value of: true
	 * @var        boolean
	 */
	protected $is_valid_onsite;

	/**
	 * The value for the is_valid_offsite field.
	 * Note: this column has a database default value of: true
	 * @var        boolean
	 */
	protected $is_valid_offsite;

	/**
	 * @var        array AccessInfo[] Collection to store aggregation of AccessInfo objects.
	 */
	protected $collAccessInfosRelatedByOnsiteAuthMethodId;

	/**
	 * @var        Criteria The criteria used to select the current contents of collAccessInfosRelatedByOnsiteAuthMethodId.
	 */
	private $lastAccessInfoRelatedByOnsiteAuthMethodIdCriteria = null;

	/**
	 * @var        array AccessInfo[] Collection to store aggregation of AccessInfo objects.
	 */
	protected $collAccessInfosRelatedByOffsiteAuthMethodId;

	/**
	 * @var        Criteria The criteria used to select the current contents of collAccessInfosRelatedByOffsiteAuthMethodId.
	 */
	private $lastAccessInfoRelatedByOffsiteAuthMethodIdCriteria = null;

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
	
	const PEER = 'AuthMethodPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->is_valid_onsite = true;
		$this->is_valid_offsite = true;
	}

	/**
	 * Initializes internal state of BaseAuthMethod object.
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
	 * Get the [label] column value.
	 * 
	 * @return     string
	 */
	public function getLabel()
	{
		return $this->label;
	}

	/**
	 * Get the [is_valid_onsite] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsValidOnsite()
	{
		return $this->is_valid_onsite;
	}

	/**
	 * Get the [is_valid_offsite] column value.
	 * 
	 * @return     boolean
	 */
	public function getIsValidOffsite()
	{
		return $this->is_valid_offsite;
	}

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     AuthMethod The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = AuthMethodPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Set the value of [label] column.
	 * 
	 * @param      string $v new value
	 * @return     AuthMethod The current object (for fluent API support)
	 */
	public function setLabel($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->label !== $v) {
			$this->label = $v;
			$this->modifiedColumns[] = AuthMethodPeer::LABEL;
		}

		return $this;
	} // setLabel()

	/**
	 * Set the value of [is_valid_onsite] column.
	 * 
	 * @param      boolean $v new value
	 * @return     AuthMethod The current object (for fluent API support)
	 */
	public function setIsValidOnsite($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_valid_onsite !== $v || $this->isNew()) {
			$this->is_valid_onsite = $v;
			$this->modifiedColumns[] = AuthMethodPeer::IS_VALID_ONSITE;
		}

		return $this;
	} // setIsValidOnsite()

	/**
	 * Set the value of [is_valid_offsite] column.
	 * 
	 * @param      boolean $v new value
	 * @return     AuthMethod The current object (for fluent API support)
	 */
	public function setIsValidOffsite($v)
	{
		if ($v !== null) {
			$v = (boolean) $v;
		}

		if ($this->is_valid_offsite !== $v || $this->isNew()) {
			$this->is_valid_offsite = $v;
			$this->modifiedColumns[] = AuthMethodPeer::IS_VALID_OFFSITE;
		}

		return $this;
	} // setIsValidOffsite()

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
			if ($this->is_valid_onsite !== true) {
				return false;
			}

			if ($this->is_valid_offsite !== true) {
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
			$this->label = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->is_valid_onsite = ($row[$startcol + 2] !== null) ? (boolean) $row[$startcol + 2] : null;
			$this->is_valid_offsite = ($row[$startcol + 3] !== null) ? (boolean) $row[$startcol + 3] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 4; // 4 = AuthMethodPeer::NUM_COLUMNS - AuthMethodPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating AuthMethod object", $e);
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
			$con = Propel::getConnection(AuthMethodPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = AuthMethodPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->collAccessInfosRelatedByOnsiteAuthMethodId = null;
			$this->lastAccessInfoRelatedByOnsiteAuthMethodIdCriteria = null;

			$this->collAccessInfosRelatedByOffsiteAuthMethodId = null;
			$this->lastAccessInfoRelatedByOffsiteAuthMethodIdCriteria = null;

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
			$con = Propel::getConnection(AuthMethodPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseAuthMethod:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				AuthMethodPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseAuthMethod:delete:post') as $callable)
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
			$con = Propel::getConnection(AuthMethodPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseAuthMethod:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    $con->commit();
			
			    return $affectedRows;
			  }
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
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
				foreach (sfMixer::getCallables('BaseAuthMethod:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				AuthMethodPeer::addInstanceToPool($this);
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

			if ($this->isNew() ) {
				$this->modifiedColumns[] = AuthMethodPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = AuthMethodPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += AuthMethodPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			if ($this->collAccessInfosRelatedByOnsiteAuthMethodId !== null) {
				foreach ($this->collAccessInfosRelatedByOnsiteAuthMethodId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collAccessInfosRelatedByOffsiteAuthMethodId !== null) {
				foreach ($this->collAccessInfosRelatedByOffsiteAuthMethodId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
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


			if (($retval = AuthMethodPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collAccessInfosRelatedByOnsiteAuthMethodId !== null) {
					foreach ($this->collAccessInfosRelatedByOnsiteAuthMethodId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collAccessInfosRelatedByOffsiteAuthMethodId !== null) {
					foreach ($this->collAccessInfosRelatedByOffsiteAuthMethodId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
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
		$pos = AuthMethodPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getLabel();
				break;
			case 2:
				return $this->getIsValidOnsite();
				break;
			case 3:
				return $this->getIsValidOffsite();
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
		$keys = AuthMethodPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getLabel(),
			$keys[2] => $this->getIsValidOnsite(),
			$keys[3] => $this->getIsValidOffsite(),
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
		$pos = AuthMethodPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setLabel($value);
				break;
			case 2:
				$this->setIsValidOnsite($value);
				break;
			case 3:
				$this->setIsValidOffsite($value);
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
		$keys = AuthMethodPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setLabel($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIsValidOnsite($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setIsValidOffsite($arr[$keys[3]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(AuthMethodPeer::DATABASE_NAME);

		if ($this->isColumnModified(AuthMethodPeer::ID)) $criteria->add(AuthMethodPeer::ID, $this->id);
		if ($this->isColumnModified(AuthMethodPeer::LABEL)) $criteria->add(AuthMethodPeer::LABEL, $this->label);
		if ($this->isColumnModified(AuthMethodPeer::IS_VALID_ONSITE)) $criteria->add(AuthMethodPeer::IS_VALID_ONSITE, $this->is_valid_onsite);
		if ($this->isColumnModified(AuthMethodPeer::IS_VALID_OFFSITE)) $criteria->add(AuthMethodPeer::IS_VALID_OFFSITE, $this->is_valid_offsite);

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
		$criteria = new Criteria(AuthMethodPeer::DATABASE_NAME);

		$criteria->add(AuthMethodPeer::ID, $this->id);

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
	 * @param      object $copyObj An object of AuthMethod (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setLabel($this->label);

		$copyObj->setIsValidOnsite($this->is_valid_onsite);

		$copyObj->setIsValidOffsite($this->is_valid_offsite);


		if ($deepCopy) {
			// important: temporarily setNew(false) because this affects the behavior of
			// the getter/setter methods for fkey referrer objects.
			$copyObj->setNew(false);

			foreach ($this->getAccessInfosRelatedByOnsiteAuthMethodId() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addAccessInfoRelatedByOnsiteAuthMethodId($relObj->copy($deepCopy));
				}
			}

			foreach ($this->getAccessInfosRelatedByOffsiteAuthMethodId() as $relObj) {
				if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
					$copyObj->addAccessInfoRelatedByOffsiteAuthMethodId($relObj->copy($deepCopy));
				}
			}

		} // if ($deepCopy)


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
	 * @return     AuthMethod Clone of current object.
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
	 * @return     AuthMethodPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new AuthMethodPeer();
		}
		return self::$peer;
	}

	/**
	 * Clears out the collAccessInfosRelatedByOnsiteAuthMethodId collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addAccessInfosRelatedByOnsiteAuthMethodId()
	 */
	public function clearAccessInfosRelatedByOnsiteAuthMethodId()
	{
		$this->collAccessInfosRelatedByOnsiteAuthMethodId = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collAccessInfosRelatedByOnsiteAuthMethodId collection (array).
	 *
	 * By default this just sets the collAccessInfosRelatedByOnsiteAuthMethodId collection to an empty array (like clearcollAccessInfosRelatedByOnsiteAuthMethodId());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initAccessInfosRelatedByOnsiteAuthMethodId()
	{
		$this->collAccessInfosRelatedByOnsiteAuthMethodId = array();
	}

	/**
	 * Gets an array of AccessInfo objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this AuthMethod has previously been saved, it will retrieve
	 * related AccessInfosRelatedByOnsiteAuthMethodId from storage. If this AuthMethod is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array AccessInfo[]
	 * @throws     PropelException
	 */
	public function getAccessInfosRelatedByOnsiteAuthMethodId($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(AuthMethodPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAccessInfosRelatedByOnsiteAuthMethodId === null) {
			if ($this->isNew()) {
			   $this->collAccessInfosRelatedByOnsiteAuthMethodId = array();
			} else {

				$criteria->add(AccessInfoPeer::ONSITE_AUTH_METHOD_ID, $this->id);

				AccessInfoPeer::addSelectColumns($criteria);
				$this->collAccessInfosRelatedByOnsiteAuthMethodId = AccessInfoPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AccessInfoPeer::ONSITE_AUTH_METHOD_ID, $this->id);

				AccessInfoPeer::addSelectColumns($criteria);
				if (!isset($this->lastAccessInfoRelatedByOnsiteAuthMethodIdCriteria) || !$this->lastAccessInfoRelatedByOnsiteAuthMethodIdCriteria->equals($criteria)) {
					$this->collAccessInfosRelatedByOnsiteAuthMethodId = AccessInfoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAccessInfoRelatedByOnsiteAuthMethodIdCriteria = $criteria;
		return $this->collAccessInfosRelatedByOnsiteAuthMethodId;
	}

	/**
	 * Returns the number of related AccessInfo objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related AccessInfo objects.
	 * @throws     PropelException
	 */
	public function countAccessInfosRelatedByOnsiteAuthMethodId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(AuthMethodPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collAccessInfosRelatedByOnsiteAuthMethodId === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(AccessInfoPeer::ONSITE_AUTH_METHOD_ID, $this->id);

				$count = AccessInfoPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(AccessInfoPeer::ONSITE_AUTH_METHOD_ID, $this->id);

				if (!isset($this->lastAccessInfoRelatedByOnsiteAuthMethodIdCriteria) || !$this->lastAccessInfoRelatedByOnsiteAuthMethodIdCriteria->equals($criteria)) {
					$count = AccessInfoPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collAccessInfosRelatedByOnsiteAuthMethodId);
				}
			} else {
				$count = count($this->collAccessInfosRelatedByOnsiteAuthMethodId);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a AccessInfo object to this object
	 * through the AccessInfo foreign key attribute.
	 *
	 * @param      AccessInfo $l AccessInfo
	 * @return     void
	 * @throws     PropelException
	 */
	public function addAccessInfoRelatedByOnsiteAuthMethodId(AccessInfo $l)
	{
		if ($this->collAccessInfosRelatedByOnsiteAuthMethodId === null) {
			$this->initAccessInfosRelatedByOnsiteAuthMethodId();
		}
		if (!in_array($l, $this->collAccessInfosRelatedByOnsiteAuthMethodId, true)) { // only add it if the **same** object is not already associated
			array_push($this->collAccessInfosRelatedByOnsiteAuthMethodId, $l);
			$l->setAuthMethodRelatedByOnsiteAuthMethodId($this);
		}
	}

	/**
	 * Clears out the collAccessInfosRelatedByOffsiteAuthMethodId collection (array).
	 *
	 * This does not modify the database; however, it will remove any associated objects, causing
	 * them to be refetched by subsequent calls to accessor method.
	 *
	 * @return     void
	 * @see        addAccessInfosRelatedByOffsiteAuthMethodId()
	 */
	public function clearAccessInfosRelatedByOffsiteAuthMethodId()
	{
		$this->collAccessInfosRelatedByOffsiteAuthMethodId = null; // important to set this to NULL since that means it is uninitialized
	}

	/**
	 * Initializes the collAccessInfosRelatedByOffsiteAuthMethodId collection (array).
	 *
	 * By default this just sets the collAccessInfosRelatedByOffsiteAuthMethodId collection to an empty array (like clearcollAccessInfosRelatedByOffsiteAuthMethodId());
	 * however, you may wish to override this method in your stub class to provide setting appropriate
	 * to your application -- for example, setting the initial array to the values stored in database.
	 *
	 * @return     void
	 */
	public function initAccessInfosRelatedByOffsiteAuthMethodId()
	{
		$this->collAccessInfosRelatedByOffsiteAuthMethodId = array();
	}

	/**
	 * Gets an array of AccessInfo objects which contain a foreign key that references this object.
	 *
	 * If this collection has already been initialized with an identical Criteria, it returns the collection.
	 * Otherwise if this AuthMethod has previously been saved, it will retrieve
	 * related AccessInfosRelatedByOffsiteAuthMethodId from storage. If this AuthMethod is new, it will return
	 * an empty collection or the current collection, the criteria is ignored on a new object.
	 *
	 * @param      PropelPDO $con
	 * @param      Criteria $criteria
	 * @return     array AccessInfo[]
	 * @throws     PropelException
	 */
	public function getAccessInfosRelatedByOffsiteAuthMethodId($criteria = null, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(AuthMethodPeer::DATABASE_NAME);
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collAccessInfosRelatedByOffsiteAuthMethodId === null) {
			if ($this->isNew()) {
			   $this->collAccessInfosRelatedByOffsiteAuthMethodId = array();
			} else {

				$criteria->add(AccessInfoPeer::OFFSITE_AUTH_METHOD_ID, $this->id);

				AccessInfoPeer::addSelectColumns($criteria);
				$this->collAccessInfosRelatedByOffsiteAuthMethodId = AccessInfoPeer::doSelect($criteria, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return the collection.


				$criteria->add(AccessInfoPeer::OFFSITE_AUTH_METHOD_ID, $this->id);

				AccessInfoPeer::addSelectColumns($criteria);
				if (!isset($this->lastAccessInfoRelatedByOffsiteAuthMethodIdCriteria) || !$this->lastAccessInfoRelatedByOffsiteAuthMethodIdCriteria->equals($criteria)) {
					$this->collAccessInfosRelatedByOffsiteAuthMethodId = AccessInfoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastAccessInfoRelatedByOffsiteAuthMethodIdCriteria = $criteria;
		return $this->collAccessInfosRelatedByOffsiteAuthMethodId;
	}

	/**
	 * Returns the number of related AccessInfo objects.
	 *
	 * @param      Criteria $criteria
	 * @param      boolean $distinct
	 * @param      PropelPDO $con
	 * @return     int Count of related AccessInfo objects.
	 * @throws     PropelException
	 */
	public function countAccessInfosRelatedByOffsiteAuthMethodId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
	{
		if ($criteria === null) {
			$criteria = new Criteria(AuthMethodPeer::DATABASE_NAME);
		} else {
			$criteria = clone $criteria;
		}

		if ($distinct) {
			$criteria->setDistinct();
		}

		$count = null;

		if ($this->collAccessInfosRelatedByOffsiteAuthMethodId === null) {
			if ($this->isNew()) {
				$count = 0;
			} else {

				$criteria->add(AccessInfoPeer::OFFSITE_AUTH_METHOD_ID, $this->id);

				$count = AccessInfoPeer::doCount($criteria, false, $con);
			}
		} else {
			// criteria has no effect for a new object
			if (!$this->isNew()) {
				// the following code is to determine if a new query is
				// called for.  If the criteria is the same as the last
				// one, just return count of the collection.


				$criteria->add(AccessInfoPeer::OFFSITE_AUTH_METHOD_ID, $this->id);

				if (!isset($this->lastAccessInfoRelatedByOffsiteAuthMethodIdCriteria) || !$this->lastAccessInfoRelatedByOffsiteAuthMethodIdCriteria->equals($criteria)) {
					$count = AccessInfoPeer::doCount($criteria, false, $con);
				} else {
					$count = count($this->collAccessInfosRelatedByOffsiteAuthMethodId);
				}
			} else {
				$count = count($this->collAccessInfosRelatedByOffsiteAuthMethodId);
			}
		}
		return $count;
	}

	/**
	 * Method called to associate a AccessInfo object to this object
	 * through the AccessInfo foreign key attribute.
	 *
	 * @param      AccessInfo $l AccessInfo
	 * @return     void
	 * @throws     PropelException
	 */
	public function addAccessInfoRelatedByOffsiteAuthMethodId(AccessInfo $l)
	{
		if ($this->collAccessInfosRelatedByOffsiteAuthMethodId === null) {
			$this->initAccessInfosRelatedByOffsiteAuthMethodId();
		}
		if (!in_array($l, $this->collAccessInfosRelatedByOffsiteAuthMethodId, true)) { // only add it if the **same** object is not already associated
			array_push($this->collAccessInfosRelatedByOffsiteAuthMethodId, $l);
			$l->setAuthMethodRelatedByOffsiteAuthMethodId($this);
		}
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
			if ($this->collAccessInfosRelatedByOnsiteAuthMethodId) {
				foreach ((array) $this->collAccessInfosRelatedByOnsiteAuthMethodId as $o) {
					$o->clearAllReferences($deep);
				}
			}
			if ($this->collAccessInfosRelatedByOffsiteAuthMethodId) {
				foreach ((array) $this->collAccessInfosRelatedByOffsiteAuthMethodId as $o) {
					$o->clearAllReferences($deep);
				}
			}
		} // if ($deep)

		$this->collAccessInfosRelatedByOnsiteAuthMethodId = null;
		$this->collAccessInfosRelatedByOffsiteAuthMethodId = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseAuthMethod:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseAuthMethod::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseAuthMethod
