<?php
/**
 * Created by PhpStorm.
 * Authors: Jeremiah, Mario, Paul
 * Date: 2/11/16 - 02/25/16
 */

if(!isset($_SESSION)){
    session_start();
    $_SESSION['time_expired'] = $now + (60 * 15);
}
$now = time();
if (isset($_SESSION['time_expired']) && $now > $_SESSION['time_expired']){
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['time_expired'] = $now + (60 * 15);
}


$request = $_GET['URL'];


if(!isset($_SESSION['responce'])){
    $_SESSION['responce'] = file_get_contents($request);
}
$response = $_SESSION['responce'];



$xml = simplexml_load_string($response);

foreach($xml->channel->item as $item) {
    $newsArticle = new Article($item);
    echo $newsArticle->getItem();

}

class Article
{
    private $title;
    private $link;
    private $description;

    /**
     * Article constructor.
     * @param $title
     * @param $description
     * @param $link
     */
    public function __construct($item)
    {
        $this->title = $item->title;
        $this->description = $item->description;
        $this->link = $item->link;
    }

    public function getItem()
    {
        return "
            <article>
                <a href='$this->link'><h2>$this->title</h2></a>
                <p>$this->description</p>

            </article>
        ";

    }



}