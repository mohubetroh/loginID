<?php
	session_start();
	/*see if we can echo stuff*/
	//if( (!isset( $_SESSION['logged_in'] )) || (!isset( $_SESSION['username' )) )
	$logged_in = $_SESSION['logged_in'];
	$username = $_SESSION['username'];
//	$timestamp = $_SESSION['timestamp'];
	$session_id = $_SESSION['session_id'];

	//-------------------------
	//PHP 5.0 -- RESET ME LATER
	//require_once("include/pf.class.php");
	//grab the timestamp from the database
	//$zulu = new PFmysql( MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB );
	//$zulu->pf_connect();
	//$zulu->pf_db_select();
	//$zulu->pf_query("SELECT timestamp FROM mdh_com WHERE user ='$username' LIMIT 1");
	require_once("db_con.php");
	connect_to_db();
	$q = mysql_query("SELECT timestamp FROM mdh_com WHERE user='$username' LIMIT 1");

	//while( $foo = $zulu->pf_fetchRow() )
	while( $foo = mysql_fetch_row($q) )
	{
		$timestamp = $foo[0];
	}

	if( !isset( $logged_in ) && !isset( $username ) && !isset( $session_id ) )
	{
		/*they are not logged in so show the log in boxes!*/
		//echo "BAD BAD WOLF! <br />";

		echo "
		<form method=\"post\" action=\"login_process.php\">
		<table class=\"login\">
			<tr>
				<td >user&nbsp;<input class=\"text\" type=\"text\" name=\"login\" size=\"12\" /></td>
				<td >pass&nbsp;<input class=\"text\" type=\"password\" name=\"pass\" size=\"12\" /></td>
				<td >&nbsp;<input class=\"button\" type=\"submit\" name=\"submit\" value=\"login\" />&nbsp;</td>
			</tr>
		</table>
		</form>";
	}else if( isset( $logged_in ) && isset( $username ) && isset( $session_id ) )
	{
		/*make sure they aren't blank*/
		if( ($logged_in != "" || $logged_in != NULL) && ($username !="" || $username != NULL) )
		{
			//echo "Your username is: " . $username . " and you are logged " . $logged_in . "<br />";
			//echo "<H1>Logout here!</H1>";
			//echo "session id says: " . $session_id;

			//GIVE THEM A LOGOUT BUTTON
			echo "<form method=\"post\" action=\"logout_process.php\">
				<table class=\"login\">
				    <tr>
				    <td >Last log in: <i>$timestamp</i>&nbsp;</td>
				        <td >
				        	<input type=\"submit\" class=\"button\" name=\"logout\" value=\"logout\" />&nbsp;
				        </td>
				    </tr>
				</table>
			</form>";
		}
	}
?>
