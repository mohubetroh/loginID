<?php
	session_start();	//start the session

	/*login to our MySQL database and retrieve our User's login credentials*/
	//require_once("include/pf.class.php");

	//make sure they gave us something
	if( empty( $_POST ) )
	{
		echo "No data was sent!";
		exit;
	}


	//-------------------------
	//PHP 5.0 -- RESET ME LATER
	//new connection
	//$alpha = new PFmysql( MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB );
	//$alpha->pf_connect();
	//$alpha->pf_db_select();

	require_once("db_con.php");

	/*get the $_POST variables, and sanitize*/
	$username = strip_tags( $_POST['login'] );
	$password = strip_tags( $_POST['pass'] );
		//and hash
	$md5 = md5($password);

	//try a query
	$string = "SELECT * FROM mdh_com WHERE mdh_com.user='$username' AND mdh_com.pass=\"$md5\" LIMIT 1";
	//$alpha->pf_query( $string );

	connect_to_db();
	$q = mysql_query( $string );

//	if( $alpha->pf_numRows()  < 1 )
//	{
//		echo "User not found. Do you wish to <a href=\"register.php\">register</a>?";
//		exit;
//	}
	//spit out XHTML

//	while( $rows  = $alpha->pf_fetchRow() )
	//if( $alpha->pf_numRows() == 1 )
	if( ($rows = mysql_num_rows($q)) == 1 )
	{
		//setup session variables
		$_SESSION['logged_in'] = 1;
		$_SESSION['username'] = $rows[0];
	//	$_SESSION['timestamp'] = $rows[7];
		$_SESSION['session_id'] = md5( $_SERVER['REMOTE_ADDR'] + $rows[1]);
	}


	//update their time
	$time = date("l, d M. Y g:i:s A");
	//$alpha->pf_query( "UPDATE mdh_com SET timestamp='$time' WHERE user='$username' ");
	$update = mysql_query( "UPDATE mdh_com SET timestamp='$time' WHERE user='$username' ");

//	echo "Click <a href=\"index.php\">here</a> to continue.";
	header("Location: index.php");
?>
