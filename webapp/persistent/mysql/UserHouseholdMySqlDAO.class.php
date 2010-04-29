<?php
/**
 * Class that operate on table 'user_household'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2010-04-29 01:01
 */
class UserHouseholdMySqlDAO implements UserHouseholdDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return UserHouseholdMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM user_household WHERE user_household_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM user_household';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM user_household ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param userHousehold primary key
 	 */
	public function delete($user_household_id){
		$sql = 'DELETE FROM user_household WHERE user_household_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($user_household_id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserHouseholdMySql userHousehold
 	 */
	public function insert($userHousehold){
		$sql = 'INSERT INTO user_household (user_id, household_id, is_owner) VALUES (?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($userHousehold->userId);
		$sqlQuery->set($userHousehold->householdId);
		$sqlQuery->setNumber($userHousehold->isOwner);

		$id = $this->executeInsert($sqlQuery);	
		$userHousehold->userHouseholdId = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserHouseholdMySql userHousehold
 	 */
	public function update($userHousehold){
		$sql = 'UPDATE user_household SET user_id = ?, household_id = ?, is_owner = ? WHERE user_household_id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($userHousehold->userId);
		$sqlQuery->set($userHousehold->householdId);
		$sqlQuery->setNumber($userHousehold->isOwner);

		$sqlQuery->set($userHousehold->userHouseholdId);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM user_household';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByUserId($value){
		$sql = 'SELECT * FROM user_household WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByHouseholdId($value){
		$sql = 'SELECT * FROM user_household WHERE household_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIsOwner($value){
		$sql = 'SELECT * FROM user_household WHERE is_owner = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByUserId($value){
		$sql = 'DELETE FROM user_household WHERE user_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByHouseholdId($value){
		$sql = 'DELETE FROM user_household WHERE household_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIsOwner($value){
		$sql = 'DELETE FROM user_household WHERE is_owner = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return UserHouseholdMySql 
	 */
	protected function readRow($row){
		$userHousehold = new UserHousehold();
		
		$userHousehold->userHouseholdId = $row['user_household_id'];
		$userHousehold->userId = $row['user_id'];
		$userHousehold->householdId = $row['household_id'];
		$userHousehold->isOwner = $row['is_owner'];

		return $userHousehold;
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
	 * @return UserHouseholdMySql 
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