<?php
/**
 * Class that operate on table 'budget'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2010-04-22 16:45
 */
class BudgetMySqlExtDAO extends BudgetMySqlDAO{


    public function queryAllByUserIdAndHouseholdIdAndIsOwner($user_id, $household_id) {

        $sql = 'SELECT u.* FROM user u, user_household h';
        $sql .= ' WHERE u.user_id = h.user_id';
        $sql .= ' AND h.user_id = ?';
        $sql .= ' AND h.household_id = ?';
        $sql .= ' AND is_owner = 1';

        $sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($user_id);
        $sqlQuery->set($household_id);
		return $this->getList($sqlQuery);
    }

    public function queryAllByShoppinglistId($shoppinglist_id) {

        $sql = 'SELECT b.* FROM budget b, household h, shoppinglist s';
        $sql .= ' WHERE b.household_id = h.household_id';
        $sql .= ' AND h.household_id = s.household_id';
        $sql .= ' AND s.shoppinglist_id = ?';

        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($shoppinglist_id);
		return $this->getList($sqlQuery);
    }



}
?>