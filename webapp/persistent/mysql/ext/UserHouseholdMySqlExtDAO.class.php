<?php
/**
 * Class that operate on table 'user_household' Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2010-04-22 16:45
 */
class UserHouseholdMySqlExtDAO extends UserHouseholdMySqlDAO{
    public function queryCompleteByUserId($value){
		$sql = 'SELECT u.*, h.name FROM user_household u, household h WHERE u.user_id = ? AND u.household_id = h.household_id';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getListComplete($sqlQuery);
	}

    /**
	 * Read row for queryCompleteByUserId
	 *
	 * @return UserHouseholdMySql
	 */
	protected function readRowComplete($row){
		$userHouseholdComplete = new UserHouseholdComplete();

		$userHouseholdComplete->userHouseholdId = $row['user_household_id'];
		$userHouseholdComplete->userId = $row['user_id'];
		$userHouseholdComplete->householdId = $row['household_id'];
		$userHouseholdComplete->isOwner = $row['is_owner'];
        $userHouseholdComplete->name = $row['name'];
		return $userHouseholdComplete;
	}

	protected function getListComplete($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRowComplete($tab[$i]);
		}
		return $ret;
	}
	
}
?>