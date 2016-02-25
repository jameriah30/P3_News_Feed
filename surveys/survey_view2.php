<?php
/**
 * survey_view.php an initial version of our survey app
 *
 * based on demo_shared.php
 *
 * demo_idb.php is both a test page for your IDB shared mysqli connection, and a starting point for
 * building DB applications using IDB connections
 *
 * @package nmCommon
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 2.09 2011/05/09
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see config_inc.php
 * @see header_inc.php
 * @see footer_inc.php
 * @todo none
 */
# '../' works for a sub-folder.  use './' for the root
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials

$config->titleTag = smartTitle(); #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaDescription = smartTitle() . ' - ' . $config->metaDescription;
/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

if(isset($_GET['id']) && (int)$_GET['id'] > 0)
{//good data process
    $id = (int)$_GET['id'];

}else{//bad data, you go away
    //this is redirection in php:
    header('Location:index.php');

}



//END CONFIG AREA ----------------------------------------------------------

get_header(); #defaults to header_inc.php
?>


<?php

$mySurvey = new Survey($id);

//dumpDie($mySurvey);

if($mySurvey->IsValid)
{//good survey show data
    echo '<h3> . $mySurvey->Title . </h3>';
    echo '<p> . $mySurvey->Desription . </p>';


}else{//apologise
    echo '<p><Sorry no such survey</p>';

}

echo '<p align="center"><a href="index.php">BACK</a></a></p>';

get_footer(); #defaults to footer_inc.php


class Survey
{
    public $SurveyID = 0;
    public $Title = '';
    public $Description = '';
    public $IsValid = false;

    /**
     * Survey constructor.
     */
    public function __construct($id)
    {

        //make sure the number is valid
        $this->SurveyID = (int)$id;

        //if no data exit
        if($this->SurveyID==0){return false;}


        # SQL statement - PREFIX is optional way to distinguish your app
        $sql = "select * FROM wn16_surveys WHERE SurveyID=$this->SurveyID";


        #IDB::conn() creates a shareable database connection via a singleton class
        $result = mysqli_query(IDB::conn(), $sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));


        if (mysqli_num_rows($result) > 0) {#there are records - present data
            $this->IsValid = true;//data exists
            while ($row = mysqli_fetch_assoc($result)) {# pull data from associative array

                $this->Title = $row['Title'];
                $this->Description = $row['Description'];



            }
        }

        @mysqli_free_result($result);
    }#end survey constructor

}