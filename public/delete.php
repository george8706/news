<?php require_once('../includes/initialize.php');

if(empty($_GET['id'])) {
    $flash->warning("No news ID was provided.");
    redirect_to('manage_news.php');
}

$news = new News();
$news_one = $news->getRows(['where'=>['id'=>$_GET['id']], 'return_type'=>'single']);
$news->id = $news_one->id;
if($news_one && $news->delete()) {
    $flash->success("The news \"{$news_one->caption}\" was deleted.");
    redirect_to('manage_news.php');
} else {
    $flash->warning("The news could not be deleted.");
    redirect_to('manage_news.php');
}