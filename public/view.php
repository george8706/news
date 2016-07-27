
<?php require_once("../includes/initialize.php"); ?>

<?php include('layouts/header.php'); ?>

<?php
if(empty($_GET['id'])) redirect_to('index.php');
$news = new News();
$one_news = $news->getRows(['where' => ['id'=> $_GET['id']], 'return_type'=>'single']);
if(!$one_news){
    redirect_to('index.php');
}
?>
<div class="row">
    <div class="col-xs-8 col-md-8 col-lg-8 col-lg-offset-2">
        <?php if(!empty($one_news)){?>
            <div class="page-header">
                <h1><?php echo $one_news->caption?></h1>
            </div>
            <p><?php echo date('d-m-Y', $one_news->date); ?></p>
            <p><?php echo $one_news->text; ?></p>
            <a class="btn btn-default btn-sm" href="<?php echo 'index.php'.$new->id ?>">
                Back</a>
        <?php }else{ ?>
            <p>No recors found...</p>
        <?php }?>
    </div>
</div>
<?php include('layouts/footer.php');?>