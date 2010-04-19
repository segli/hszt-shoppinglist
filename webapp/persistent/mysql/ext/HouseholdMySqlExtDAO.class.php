<?php
/**
 * Class that operate on table 'household'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2010-04-13 22:30
 */
class HouseholdMySqlExtDAO extends HouseholdMySqlDAO{
     public function queryAllByUserId($value){
		$sql = 'SELECT h.* FROM user_household u, household h WHERE  u.user_id = ? AND u.household_id = h.household_id';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}
}
?>