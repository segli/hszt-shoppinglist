<?php
/**
 * Class that operate on table 'invitation'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2010-04-22 16:45
 */
class InvitationMySqlExtDAO extends InvitationMySqlDAO{

    // User Id ist in diesem Fall die id des Erstellers!
    public function queryAllByUserId($uid){

		$sql = 'SELECT i.*, h.* FROM invitation i, household h';
		$sql .= ' WHERE i.user_id = ?';
        $sql .= ' AND i.household_id = h.household_id';
        $sql .= ' AND pending = 1';

		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($uid);
		return $this->getList($sqlQuery);
	}

    public function queryAllByEmail($email){

        $sql = 'SELECT i.*, h.name as household, CONCAT(u.firstname,\' \',u.lastname) as gastgeber';
        $sql .= ' FROM invitation i, household h, user u';
        $sql .= ' WHERE i.user_id = u.user_id ';
        $sql .= ' AND i.email = ?';
        $sql .= ' AND i.household_id = h.household_id';
        $sql .= ' AND pending = 1';

		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($email);
		return $this->getList($sqlQuery);
	}
	
}
?>