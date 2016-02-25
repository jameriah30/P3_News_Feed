<?php
/**
 * Created by PhpStorm.
 * Authors: Jeremiah, Mario, Paul
 * Date: 2/11/16 - 02/25/16
 */

# '../' works for a sub-folder.  use './' for the root
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials

# SQL statement
$sql = "select * from Categories";

#Fills <title> tag. If left empty will default to $PageTitle in config_inc.php
$config->titleTag = 'Sports, Tech, & Politics';

#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
$config->metaDescription = 'Seattle Central\'s ITC260 RSS Feeds are made with pure PHP! ' . $config->metaDescription;
$config->metaKeywords = 'Sports,PHP,Politics,Tech,Regular,Regular Expressions,'. $config->metaKeywords;



get_header(); #defaults to theme header or header_inc.php
?>
<h3 align="center"><?=smartTitle();?></h3>


<?php

# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

if(mysqli_num_rows($result) > 0)
{#records exist - process
    while($row = mysqli_fetch_assoc($result))
    {# process each row
        echo '<div align="center"><a href="' . VIRTUAL_PATH . 'feeds/news_view.php?id=' . (int)$row['CategoryID'] . '">' . dbOut($row['CategoryName']) . '</a>';


    }
}else{#no records
    echo "<div align=center>Error- No Categories Available</div>";
}
@mysqli_free_result($result);

get_footer(); #defaults to theme footer or footer_inc.php
?>
