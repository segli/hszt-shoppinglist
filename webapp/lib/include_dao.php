<?php
	//include all DAO files
	require_once('persistent/sql/Connection.class.php');
	require_once('persistent/sql/ConnectionFactory.class.php');
	require_once('persistent/sql/ConnectionProperty.class.php');
	require_once('persistent/sql/QueryExecutor.class.php');
	require_once('persistent/sql/Transaction.class.php');
	require_once('persistent/sql/SqlQuery.class.php');
	require_once('persistent/core/ArrayList.class.php');
	require_once('persistent/dao/DAOFactory.class.php');
 	
	require_once('persistent/dao/BillDAO.class.php');
	require_once('persistent/dto/Bill.class.php');
	require_once('persistent/mysql/BillMySqlDAO.class.php');
	require_once('persistent/mysql/ext/BillMySqlExtDAO.class.php');
	require_once('persistent/dao/BudgetDAO.class.php');
	require_once('persistent/dto/Budget.class.php');
	require_once('persistent/mysql/BudgetMySqlDAO.class.php');
	require_once('persistent/mysql/ext/BudgetMySqlExtDAO.class.php');
	require_once('persistent/dao/HouseholdDAO.class.php');
	require_once('persistent/dto/Household.class.php');
	require_once('persistent/mysql/HouseholdMySqlDAO.class.php');
	require_once('persistent/mysql/ext/HouseholdMySqlExtDAO.class.php');
	require_once('persistent/dao/InvitationDAO.class.php');
	require_once('persistent/dto/Invitation.class.php');
	require_once('persistent/mysql/InvitationMySqlDAO.class.php');
	require_once('persistent/mysql/ext/InvitationMySqlExtDAO.class.php');
	require_once('persistent/dao/ItemDAO.class.php');
	require_once('persistent/dto/Item.class.php');
	require_once('persistent/mysql/ItemMySqlDAO.class.php');
	require_once('persistent/mysql/ext/ItemMySqlExtDAO.class.php');
	require_once('persistent/dao/ShoppinglistDAO.class.php');
	require_once('persistent/dto/Shoppinglist.class.php');
	require_once('persistent/mysql/ShoppinglistMySqlDAO.class.php');
	require_once('persistent/mysql/ext/ShoppinglistMySqlExtDAO.class.php');
	require_once('persistent/dao/UserDAO.class.php');
	require_once('persistent/dto/User.class.php');
	require_once('persistent/mysql/UserMySqlDAO.class.php');
	require_once('persistent/mysql/ext/UserMySqlExtDAO.class.php');
    require_once('persistent/dao/UserHouseholdDAO.class.php');
	require_once('persistent/dto/UserHousehold.class.php');
	require_once('persistent/mysql/UserHouseholdMySqlDAO.class.php');
	require_once('persistent/mysql/ext/UserHouseholdMySqlExtDAO.class.php');

    // Custom. See descriptipon in file.
    require_once('persistent/dto/UserHouseholdComplete.class.php');
    require_once('persistent/dto/InvitationComplete.class.php');