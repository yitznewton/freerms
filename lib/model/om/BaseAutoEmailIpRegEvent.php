<?php

/**
 * Base class that represents a row from the 'auto_email_ip_reg_events' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.1 on:
 *
 * Wed Jun  2 17:32:58 2010
 *
 * @package    lib.model.om
 */
abstract class BaseAutoEmailIpRegEvent extends BaseObject  {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        AutoEmailIpRegEventPeer
	 */
	protected static $peer;

	/**
	 * The value for the ip_range_id field.
	 * @var        int
	 */
	protected $ip_range_id;

	/**
	 * The value for the old_start_ip field.
	 * @var        string
	 */
	protected $old_start_ip;

	/**
	 * The value for the old_end_ip field.
	 * @var        string
	 */
	protected $old_end_ip;

	/**
	 * The value for the new_start_ip field.
	 * @var        string
	 */
	protected $new_start_ip;

	/**
	 * The value for the new_end_ip field.
	 * @var        string
	 */
	protected $new_end_ip;

	/**
	 * The value for the contact_id field.
	 * @var        int
	 */
	protected $contact_id;

	/**
	 * @var        IpRange
	 */
	protected $aIpRange;

	/**
	 * @var        Contact
	 */
	protected $aContact;

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
	
	const PEER = 'AutoEmailIpRegEventPeer';

	/**
	 * Get the [ip_range_id] column value.
	 * 
	 * @return     int
	 */
	public function getIpRangeId()
	{
		return $this->ip_range_id;
	}

	/**
	 * Get the [old_start_ip] column value.
	 * 
	 * @return     string
	 */
	public function getOldStartIp()
	{
		return $this->old_start_ip;
	}

	/**
	 * Get the [old_end_ip] column value.
	 * 
	 * @return     string
	 */
	public function getOldEndIp()
	{
		return $this->old_end_ip;
	}

	/**
	 * Get the [new_start_ip] column value.
	 * 
	 * @return     string
	 */
	public function getNewStartIp()
	{
		return $this->new_start_ip;
	}

	/**
	 * Get the [new_end_ip] column value.
	 * 
	 * @return     string
	 */
	public function getNewEndIp()
	{
		return $this->new_end_ip;
	}

	/**
	 * Get the [contact_id] column value.
	 * 
	 * @return     int
	 */
	public function getContactId()
	{
		return $this->contact_id;
	}

	/**
	 * Set the value of [ip_range_id] column.
	 * 
	 * @param      int $v new value
	 * @return     AutoEmailIpRegEvent The current object (for fluent API support)
	 */
	public function setIpRangeId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->ip_range_id !== $v) {
			$this->ip_range_id = $v;
			$this->modifiedColumns[] = AutoEmailIpRegEventPeer::IP_RANGE_ID;
		}

		if ($this->aIpRange !== null && $this->aIpRange->getId() !== $v) {
			$this->aIpRange = null;
		}

		return $this;
	} // setIpRangeId()

	/**
	 * Set the value of [old_start_ip] column.
	 * 
	 * @param      string $v new value
	 * @return     AutoEmailIpRegEvent The current object (for fluent API support)
	 */
	public function setOldStartIp($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->old_start_ip !== $v) {
			$this->old_start_ip = $v;
			$this->modifiedColumns[] = AutoEmailIpRegEventPeer::OLD_START_IP;
		}

		return $this;
	} // setOldStartIp()

	/**
	 * Set the value of [old_end_ip] column.
	 * 
	 * @param      string $v new value
	 * @return     AutoEmailIpRegEvent The current object (for fluent API support)
	 */
	public function setOldEndIp($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->old_end_ip !== $v) {
			$this->old_end_ip = $v;
			$this->modifiedColumns[] = AutoEmailIpRegEventPeer::OLD_END_IP;
		}

		return $this;
	} // setOldEndIp()

	/**
	 * Set the value of [new_start_ip] column.
	 * 
	 * @param      string $v new value
	 * @return     AutoEmailIpRegEvent The current object (for fluent API support)
	 */
	public function setNewStartIp($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->new_start_ip !== $v) {
			$this->new_start_ip = $v;
			$this->modifiedColumns[] = AutoEmailIpRegEventPeer::NEW_START_IP;
		}

		return $this;
	} // setNewStartIp()

	/**
	 * Set the value of [new_end_ip] column.
	 * 
	 * @param      string $v new value
	 * @return     AutoEmailIpRegEvent The current object (for fluent API support)
	 */
	public function setNewEndIp($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->new_end_ip !== $v) {
			$this->new_end_ip = $v;
			$this->modifiedColumns[] = AutoEmailIpRegEventPeer::NEW_END_IP;
		}

		return $this;
	} // setNewEndIp()

	/**
	 * Set the value of [contact_id] column.
	 * 
	 * @param      int $v new value
	 * @return     AutoEmailIpRegEvent The current object (for fluent API support)
	 */
	public function setContactId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->contact_id !== $v) {
			$this->contact_id = $v;
			$this->modifiedColumns[] = AutoEmailIpRegEventPeer::CONTACT_ID;
		}

		if ($this->aContact !== null && $this->aContact->getId() !== $v) {
			$this->aContact = null;
		}

		return $this;
	} // setContactId()

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

			$this->ip_range_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->old_start_ip = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->old_end_ip = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
			$this->new_start_ip = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
			$this->new_end_ip = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
			$this->contact_id = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 6; // 6 = AutoEmailIpRegEventPeer::NUM_COLUMNS - AutoEmailIpRegEventPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating AutoEmailIpRegEvent object", $e);
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

		if ($this->aIpRange !== null && $this->ip_range_id !== $this->aIpRange->getId()) {
			$this->aIpRange = null;
		}
		if ($this->aContact !== null && $this->contact_id !== $this->aContact->getId()) {
			$this->aContact = null;
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
			$con = Propel::getConnection(AutoEmailIpRegEventPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = AutoEmailIpRegEventPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

			$this->aIpRange = null;
			$this->aContact = null;
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
			$con = Propel::getConnection(AutoEmailIpRegEventPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseAutoEmailIpRegEvent:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				AutoEmailIpRegEventPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseAutoEmailIpRegEvent:delete:post') as $callable)
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
			$con = Propel::getConnection(AutoEmailIpRegEventPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseAutoEmailIpRegEvent:save:pre') as $callable)
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
				foreach (sfMixer::getCallables('BaseAutoEmailIpRegEvent:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				AutoEmailIpRegEventPeer::addInstanceToPool($this);
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

			if ($this->aIpRange !== null) {
				if ($this->aIpRange->isModified() || $this->aIpRange->isNew()) {
					$affectedRows += $this->aIpRange->save($con);
				}
				$this->setIpRange($this->aIpRange);
			}

			if ($this->aContact !== null) {
				if ($this->aContact->isModified() || $this->aContact->isNew()) {
					$affectedRows += $this->aContact->save($con);
				}
				$this->setContact($this->aContact);
			}


			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = AutoEmailIpRegEventPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setNew(false);
				} else {
					$affectedRows += AutoEmailIpRegEventPeer::doUpdate($this, $con);
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

			if ($this->aIpRange !== null) {
				if (!$this->aIpRange->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aIpRange->getValidationFailures());
				}
			}

			if ($this->aContact !== null) {
				if (!$this->aContact->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aContact->getValidationFailures());
				}
			}


			if (($retval = AutoEmailIpRegEventPeer::doValidate($this, $columns)) !== true) {
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
		$pos = AutoEmailIpRegEventPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getIpRangeId();
				break;
			case 1:
				return $this->getOldStartIp();
				break;
			case 2:
				return $this->getOldEndIp();
				break;
			case 3:
				return $this->getNewStartIp();
				break;
			case 4:
				return $this->getNewEndIp();
				break;
			case 5:
				return $this->getContactId();
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
		$keys = AutoEmailIpRegEventPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getIpRangeId(),
			$keys[1] => $this->getOldStartIp(),
			$keys[2] => $this->getOldEndIp(),
			$keys[3] => $this->getNewStartIp(),
			$keys[4] => $this->getNewEndIp(),
			$keys[5] => $this->getContactId(),
		);
		return $result;
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(AutoEmailIpRegEventPeer::DATABASE_NAME);

		if ($this->isColumnModified(AutoEmailIpRegEventPeer::IP_RANGE_ID)) $criteria->add(AutoEmailIpRegEventPeer::IP_RANGE_ID, $this->ip_range_id);
		if ($this->isColumnModified(AutoEmailIpRegEventPeer::OLD_START_IP)) $criteria->add(AutoEmailIpRegEventPeer::OLD_START_IP, $this->old_start_ip);
		if ($this->isColumnModified(AutoEmailIpRegEventPeer::OLD_END_IP)) $criteria->add(AutoEmailIpRegEventPeer::OLD_END_IP, $this->old_end_ip);
		if ($this->isColumnModified(AutoEmailIpRegEventPeer::NEW_START_IP)) $criteria->add(AutoEmailIpRegEventPeer::NEW_START_IP, $this->new_start_ip);
		if ($this->isColumnModified(AutoEmailIpRegEventPeer::NEW_END_IP)) $criteria->add(AutoEmailIpRegEventPeer::NEW_END_IP, $this->new_end_ip);
		if ($this->isColumnModified(AutoEmailIpRegEventPeer::CONTACT_ID)) $criteria->add(AutoEmailIpRegEventPeer::CONTACT_ID, $this->contact_id);

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
		$criteria = new Criteria(AutoEmailIpRegEventPeer::DATABASE_NAME);

		$criteria->add(AutoEmailIpRegEventPeer::IP_RANGE_ID, $this->ip_range_id);
		$criteria->add(AutoEmailIpRegEventPeer::CONTACT_ID, $this->contact_id);

		return $criteria;
	}

	/**
	 * Returns the composite primary key for this object.
	 * The array elements will be in same order as specified in XML.
	 * @return     array
	 */
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getIpRangeId();

		$pks[1] = $this->getContactId();

		return $pks;
	}

	/**
	 * Set the [composite] primary key.
	 *
	 * @param      array $keys The elements of the composite key (order must match the order in XML file).
	 * @return     void
	 */
	public function setPrimaryKey($keys)
	{

		$this->setIpRangeId($keys[0]);

		$this->setContactId($keys[1]);

	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of AutoEmailIpRegEvent (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setIpRangeId($this->ip_range_id);

		$copyObj->setOldStartIp($this->old_start_ip);

		$copyObj->setOldEndIp($this->old_end_ip);

		$copyObj->setNewStartIp($this->new_start_ip);

		$copyObj->setNewEndIp($this->new_end_ip);

		$copyObj->setContactId($this->contact_id);


		$copyObj->setNew(true);

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
	 * @return     AutoEmailIpRegEvent Clone of current object.
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
	 * @return     AutoEmailIpRegEventPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new AutoEmailIpRegEventPeer();
		}
		return self::$peer;
	}

	/**
	 * Declares an association between this object and a IpRange object.
	 *
	 * @param      IpRange $v
	 * @return     AutoEmailIpRegEvent The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setIpRange(IpRange $v = null)
	{
		if ($v === null) {
			$this->setIpRangeId(NULL);
		} else {
			$this->setIpRangeId($v->getId());
		}

		$this->aIpRange = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the IpRange object, it will not be re-added.
		if ($v !== null) {
			$v->addAutoEmailIpRegEvent($this);
		}

		return $this;
	}


	/**
	 * Get the associated IpRange object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     IpRange The associated IpRange object.
	 * @throws     PropelException
	 */
	public function getIpRange(PropelPDO $con = null)
	{
		if ($this->aIpRange === null && ($this->ip_range_id !== null)) {
			$this->aIpRange = IpRangePeer::retrieveByPk($this->ip_range_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aIpRange->addAutoEmailIpRegEvents($this);
			 */
		}
		return $this->aIpRange;
	}

	/**
	 * Declares an association between this object and a Contact object.
	 *
	 * @param      Contact $v
	 * @return     AutoEmailIpRegEvent The current object (for fluent API support)
	 * @throws     PropelException
	 */
	public function setContact(Contact $v = null)
	{
		if ($v === null) {
			$this->setContactId(NULL);
		} else {
			$this->setContactId($v->getId());
		}

		$this->aContact = $v;

		// Add binding for other direction of this n:n relationship.
		// If this object has already been added to the Contact object, it will not be re-added.
		if ($v !== null) {
			$v->addAutoEmailIpRegEvent($this);
		}

		return $this;
	}


	/**
	 * Get the associated Contact object
	 *
	 * @param      PropelPDO Optional Connection object.
	 * @return     Contact The associated Contact object.
	 * @throws     PropelException
	 */
	public function getContact(PropelPDO $con = null)
	{
		if ($this->aContact === null && ($this->contact_id !== null)) {
			$this->aContact = ContactPeer::retrieveByPk($this->contact_id);
			/* The following can be used additionally to
			   guarantee the related object contains a reference
			   to this object.  This level of coupling may, however, be
			   undesirable since it could result in an only partially populated collection
			   in the referenced object.
			   $this->aContact->addAutoEmailIpRegEvents($this);
			 */
		}
		return $this->aContact;
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

			$this->aIpRange = null;
			$this->aContact = null;
	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseAutoEmailIpRegEvent:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseAutoEmailIpRegEvent::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseAutoEmailIpRegEvent
