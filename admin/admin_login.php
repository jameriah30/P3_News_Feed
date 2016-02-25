<?php
/**
 * admin_login.php is entry point (form) page to administrative area
 *
 * Works with admin_validate.php to process administrator login requests.
 * Forwards user to admin_dashboard.php, upon successful login.
 *
 * 6/4/12 - added session destroy after being passed from logout due to session var 
 * needed for feedback() 
 *
 * @package nmAdmin
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 2.014 2012/06/09
 * @link http://www.newmanix.com/ 
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see admin_validate.php
 * @see admin_dashboard.php
 * @see admin_logout.php
 * @see admin_only_inc.php     
 * @todo none
 */
 
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
$config->titleTag = 'Admin Login'; #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaRobots = 'no index, no follow';#never index admin pages  

//END CONFIG AREA ----------------------------------------------------------
if(startSession() && isset($_SESSION['red']) && $_SESSION['red'] != 'admin_logout.php')
{//store redirect to get directly back to originating page
	$red = $_SESSION['red'];
}else{//don't redirect to logout page!
	$red = '';
}#required for redirect back to previous page
get_header(); #defaults to theme header or header_inc.php
echo '
 <div align="center"><h3>Admin Login</h3></div>
 <table align="center">
 	  <form action="' . $config->adminValidate . '" method="post">
      <tr>
			<td align="right">Email:</td>
			<td>
				<input type="text" size="25" maxlength="100" name="em" id="em" autofocus="autofocus" required="required" />
			</td>
      </tr>
      <tr>
      		<td align="right">Password:</td>
      		<td>
      			<input type="password" size="25" maxlength="25" name="pw" id="pw" required="required" />
      		</td>
      </tr>
       
      <tr>
      	<td align="center" colspan="2">
      		<input type="hidden" name="red" value="' . $red . '" />
      		<input type="submit" value="login" />
      	</td>
      </tr>
 </table>
 </form>
 ';
get_footer(); #defaults to theme footer or footer_inc.php

if(isset($_SESSION['red']) && $_SESSION['red'] == 'admin_logout.php')
{#since admin_logout.php uses the session var to pass feedback, kill the session here!
	$_SESSION = array();
	session_destroy();	
}
?>
