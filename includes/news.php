<?php

require_once(LIB_PATH.DS."crud.php");

class News extends Crud{

    protected $table = "news_feed";
    protected $db_fields = array('id', 'caption', 'text', 'date');
    public $id;
    public $caption;
    public $text;
    public $date;
    
}
?>