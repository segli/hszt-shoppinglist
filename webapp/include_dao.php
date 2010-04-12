<?php
	//include all DAO files
	require_once('persistent/sql/Connection.persistent.php');
	require_once('persistent/sql/ConnectionFactory.persistent.php');
	require_once('persistent/sql/ConnectionProperty.persistent.php');
	require_once('persistent/sql/QueryExecutor.persistent.php');
	require_once('persistent/sql/Transaction.persistent.php');
	require_once('persistent/sql/SqlQuery.persistent.php');
	require_once('persistent/core/ArrayList.persistent.php');
	require_once('persistent/dao/DAOFactory.persistent.php');
 	
	require_once('persistent/dao/BillDAO.persistent.php');
	require_once('persistent/dto/Bill.persistent.php');
	require_once('persistent/mysql/BillMySqlDAO.persistent.php');
	require_once('persistent/mysql/ext/BillMySqlExtDAO.persistent.php');
	require_once('persistent/dao/BudgetDAO.persistent.php');
	require_once('persistent/dto/Budget.persistent.php');
	require_once('persistent/mysql/BudgetMySqlDAO.persistent.php');
	require_once('persistent/mysql/ext/BudgetMySqlExtDAO.persistent.php');
	require_once('persistent/dao/HouseholdDAO.persistent.php');
	require_once('persistent/dto/Household.persistent.php');
	require_once('persistent/mysql/HouseholdMySqlDAO.persistent.php');
	require_once('persistent/mysql/ext/HouseholdMySqlExtDAO.persistent.php');
	require_once('persistent/dao/ItemDAO.persistent.php');
	require_once('persistent/dto/Item.persistent.php');
	require_once('persistent/mysql/ItemMySqlDAO.persistent.php');
	require_once('persistent/mysql/ext/ItemMySqlExtDAO.persistent.php');
	require_once('persistent/dao/ListDAO.persistent.php');
	require_once('persistent/dto/List.persistent.php');
	require_once('persistent/mysql/ListMySqlDAO.persistent.php');
	require_once('persistent/mysql/ext/ListMySqlExtDAO.persistent.php');
	require_once('persistent/dao/UserDAO.persistent.php');
	require_once('persistent/dto/User.persistent.php');
	require_once('persistent/mysql/UserMySqlDAO.persistent.php');
	require_once('persistent/mysql/ext/UserMySqlExtDAO.persistent.php');
	require_once('persistent/dao/UserHouseholdDAO.persistent.php');
	require_once('persistent/dto/UserHousehold.persistent.php');
	require_once('persistent/mysql/UserHouseholdMySqlDAO.persistent.php');
	require_once('persistent/mysql/ext/UserHouseholdMySqlExtDAO.persistent.php');

?>