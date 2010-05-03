<?php
/**
 * Class that operate on table 'invitation'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2010-04-22 16:45
 */
class InvitationMySqlExtDAO extends InvitationMySqlDAO{

    // User Id ist in diesem Fall die id des Erstellers!
    public function queryAllByUserId($uid) {

		$sql = 'SELECT i.*, h.* FROM invitation i, household h';
		$sql .= ' WHERE i.user_id = ?';
        $sql .= ' AND i.household_id = h.household_id';
        $sql .= ' AND pending = 1';

		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($uid);
		return $this->getList($sqlQuery);
	}

    public function queryAllByEmail($email) {

        $sql = 'SELECT i.*, h.name as household_name, CONCAT(u.firstname,\' \',u.lastname) as gastgeber';
        $sql .= ' FROM invitation i, household h, user u';
        $sql .= ' WHERE i.user_id = u.user_id ';
        $sql .= ' AND i.email = ?';
        $sql .= ' AND i.household_id = h.household_id';
        $sql .= ' AND pending = 1';

		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($email);
		return $this->getListComplete($sqlQuery);
	}

    public function queryAllByInvitationIdAndUserIdOrEmail($user_id, $email, $invitation_id) {

        $sql = 'SELECT i.* FROM invitation i';
        $sql .= ' WHERE i.invitation_id = ?';
        $sql .= ' AND (i.email = ? OR i.user_id = ?';
        
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($invitation_id);
        $sqlQuery->set($email);
        $sqlQuery->set($user_id);
        return $this-getList($sqlQuery);
    }

    public function queryAllByEmailAndHouseholdId($email, $household_id) {

        $sql = 'SELECT i.* FROM invitation i';
        $sql .= ' WHERE i.email = ?';
        $sql .= ' AND i.household_id = ?';

        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->set($email);
        $sqlQuery->set($household_id);
        return $this-getList($sqlQuery);
    }

    /**
	 * Read row for queryAllByEmail
	 *
	 * @return InvitationComplete
	 */
	protected function readRowComplete($row) {

		$invitationComplete = new InvitationComplete();
		$invitationComplete->inventationId  = $row['inventation_id'];
        $invitationComplete->householdId    = $row['household_id'];
        $invitationComplete->userId         = $row['user_id'];
        $invitationComplete->gastgeber      = $row['gastgeber'];
        $invitationComplete->householdName  = $row['household_name'];
        $invitationComplete->email          = $row['email'];
        $invitationComplete->pending        = $row['pending'];
        $invitationComplete->dateCreated    = $row['date_created'];

		return $invitationComplete;
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