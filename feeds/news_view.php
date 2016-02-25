<?php
/**
 * Created by PhpStorm.
 * Authors: Jeremiah, Mario, Paul
 * Date: 2/11/16 - 02/25/16
 */

# '../' works for a sub-folder.  use './' for the root
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials

# check variable of item passed in - if invalid data, forcibly redirect back to demo_list.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
    $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
    myRedirect(VIRTUAL_PATH . "feeds/news_list.php");
}

//sql statement to select individual item
$sql = "select Title, Description, URL from Feed f inner join Categories c on f.CategoryID = c.CategoryID where f.CategoryID = " . $myID;
//---end config area --------------------------------------------------

$foundRecord = FALSE; # Will change to true, if record found!

# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

if(mysqli_num_rows($result) > 0)
{#records exist - process
    $foundRecord = TRUE;
    while ($row = mysqli_fetch_assoc($result))
    {
        $Title = dbOut($row['Title']);
        $Description = dbOut($row['Description']);
        $URL = $row['URL'];
        if($foundRecord)
        {#records exist - show feeds!
            ?>
            <a href="news_page.php?URL=<?=$URL?>"><h3 align="center"> <?=$Title;?></h3></a>
            <div align="center"><a href="<?=VIRTUAL_PATH;?>feeds/news_list.php">Back</a></div>
            <table align="center">

                <tr>
                    <td colspan="2">
                        <blockquote><?=$Description;?></blockquote>
                    </td>
                </tr>


            </table>
            <?
        }else{//no such muffin!
            echo '<div align="center">What! No Feed? There must be a mistake!!</div>';
            echo '<div align="center"><a href="' . VIRTUAL_PATH . 'feeds/news_list.php">Another Feed?</a></div>';
        }
    }

}

@mysqli_free_result($result); # We're done with the data!



get_header(); #defaults to theme header or header_inc.php
?>

<?php


get_footer(); #defaults to theme footer or footer_inc.php
?>
