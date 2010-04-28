<?php
/**
 * Class that operate on table 'shoppinglist'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2010-04-13 22:30
 */
class ShoppinglistMySqlExtDAO extends ShoppinglistMySqlDAO{

     public function queryAllByUserIdAndHouseholdId($uid, $hid){

		$sql = 'SELECT s.* FROM user_household u, household h, shoppinglist s';
		$sql .= ' WHERE u.user_id = '.$uid.' AND s.household_id = ?';
        $sql .= ' AND u.household_id = h.household_id';
        $sql .= ' AND h.household_id = s.household_id';

		$sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($hid);
		return $this->getList($sqlQuery);
	}

    public function queryAllByUserId($value){

		$sql = 'SELECT s.* FROM user_household u, household h, shoppinglist s';
		$sql .= ' WHERE u.user_id = ?';
        $sql .= ' AND u.household_id = h.household_id';
        $sql .= ' AND h.household_id = s.household_id';

		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

    public function queryAllByShoppinglistIdAndOwnerId($shoppinglist_id, $user_id){

		$sql = 'SELECT s.* FROM shoppinglist s';
		$sql .= ' WHERE s.shoppinglist_id = ?';
        $sql .= ' AND s.user_id = ?';

		$sqlQuery = new SqlQuery($sql);

		$sqlQuery->set($shoppinglist_id);
        $sqlQuery->set($user_id);
		return $this->getList($sqlQuery);
	}

    public function queryAllByHouseholdIdAndShoppinglistName($household_id, $shoppinglist_name) {

        $sql = 'SELECT s.* FROM shoppinglist s';
        $sql .= ' WHERE s.name = \''. $shoppinglist_name .'\'';
        $sql .= ' AND s.household_id = ?';

		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($household_id);
		return $this->getList($sqlQuery);
    }



	
}
?>