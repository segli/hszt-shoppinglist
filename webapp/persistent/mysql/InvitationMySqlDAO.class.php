<?php
/**
 * Class that operate on table 'invitation'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2010-04-26 22:49
 */
class InvitationMySqlDAO implements InvitationDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return InvitationMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM invitation WHERE inventation_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM invitation';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM invitation ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param invitation primary key
 	 */
	public function delete($inventation_id){
		$sql = 'DELETE FROM invitation WHERE inventation_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($inventation_id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param InvitationMySql invitation
 	 */
	public function insert($invitation){
		$sql = 'INSERT INTO invitation (user_id, email, household_id, pending, date_created) VALUES (?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($invitation->userId);
		$sqlQuery->set($invitation->email);
		$sqlQuery->set($invitation->householdId);
		$sqlQuery->setNumber($invitation->pending);
		$sqlQuery->set($invitation->dateCreated);

		$id = $this->executeInsert($sqlQuery);	
		$invitation->inventationId = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param InvitationMySql invitation
 	 */
	public function update($invitation){
		$sql = 'UPDATE invitation SET user_id = ?, email = ?, household_id = ?, pending = ?, date_created = ? WHERE inventation_id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($invitation->userId);
		$sqlQuery->set($invitation->email);
		$sqlQuery->set($invitation->householdId);
		$sqlQuery->setNumber($invitation->pending);
		$sqlQuery->set($invitation->dateCreated);

		$sqlQuery->set($invitation->inventationId);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM invitation';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByUserId($value){
		$sql = 'SELECT * FROM invitation WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByEmail($value){
		$sql = 'SELECT * FROM invitation WHERE email = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByHouseholdId($value){
		$sql = 'SELECT * FROM invitation WHERE household_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPending($value){
		$sql = 'SELECT * FROM invitation WHERE pending = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByDateCreated($value){
		$sql = 'SELECT * FROM invitation WHERE date_created = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByUserId($value){
		$sql = 'DELETE FROM invitation WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByEmail($value){
		$sql = 'DELETE FROM invitation WHERE email = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByHouseholdId($value){
		$sql = 'DELETE FROM invitation WHERE household_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPending($value){
		$sql = 'DELETE FROM invitation WHERE pending = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByDateCreated($value){
		$sql = 'DELETE FROM invitation WHERE date_created = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return InvitationMySql 
	 */
	protected function readRow($row){
		$invitation = new Invitation();
		
		$invitation->inventationId = $row['inventation_id'];
		$invitation->userId = $row['user_id'];
		$invitation->email = $row['email'];
		$invitation->householdId = $row['household_id'];
		$invitation->pending = $row['pending'];
		$invitation->dateCreated = $row['date_created'];

		return $invitation;
	}
	
	protected function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRow($tab[$i]);
		}
		return $ret;
	}
	
	/**
	 * Get row
	 *
	 * @return InvitationMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		return QueryExecutor::execute($sqlQuery);
	}
	
		
	/**
	 * Execute sql query
	 */
	protected function executeUpdate($sqlQuery){
		return QueryExecutor::executeUpdate($sqlQuery);
	}

	/**
	 * Query for one row and one column
	 */
	protected function querySingleResult($sqlQuery){
		return QueryExecutor::queryForString($sqlQuery);
	}

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>