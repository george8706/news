<?php require_once('../includes/initialize.php');?>

<?php $current_page = 'home';?>
<?php include('layouts/header.php');/*include_layout_template('header.php')*/;?>
<?php

$page = !empty($_GET['page'])?(int)$_GET['page']:1;
$per_page = 3;
$news = new News();
$total_count = $news->getRows(['select', 'return_type'=>'count']);

$pagination = new Pagination($page, $per_page, $total_count);

$news_per_page = $news->getRows(['order_by'=>'date DESC','limit'=>$per_page, 'offset'=>$pagination->offset(), 'return_type'=>'all']);

?>
<div class="row">
    <div class="col-xs-8 col-md-8 col-lg-8 col-xs-offset-2 col-md-offset-2 col-lg-offset-2">
        <?php $flash->display()?>
        <?php if(!empty($news_per_page)) {
            $count = 0;
            foreach ($news_per_page as $new) {
                $count++; ?>

                <h2><?php echo $new->caption; ?></h2>
                <p><span class="text-muted"><?php echo date("d-m-Y", $new->date); ?></span></p>
                <div class="shorttext">
                    <p><?php echo cut_text($new->text, 500); ?></p>
                </div>
                <div class="col-xs-offset-10 col-md-offset-10 col-lg-offset-10">
                <a class="btn btn-default btn-sm" href="<?php echo 'view.php?id='.$new->id ?>">
                     Read more &raquo;</a>
                </div>
            <?php }
        }else echo 'No record(s) found.....';
        ?>
    <div class="clearfix"></div>
        <div class="text-center">
            <ul class="pagination">
                <?php
                if($pagination->total_pages() > 1) {
                    if(!$pagination->has_previous_page()) {
                        echo '<li class="disabled">';
                        echo '<a href="" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>';
                        echo '</li>';
                    }else {
                        echo '<li>';
                        echo '<a href="index.php?page='.$pagination->previous_page().'" aria-label="Previous">';
                        echo '<span aria-hidden=\"true\">&laquo;</span></a></li>';
                    }

                    for($i=1; $i <= $pagination->total_pages(); $i++) {
                        if($i == $page) {
                            echo "<li class='active'><a href=\"#\">{$i}<span class=\"sr-only\">(current)</span></a></li>";
                        } else {
                            echo "<li><a href=\"index.php?page={$i}\">{$i}</a></li>";
                        }
                    }

                    if(!$pagination->has_next_page()) {
                        echo '<li class="disabled">';
                        echo '<a href="" aria-label="Previous"><span aria-hidden="true">&raquo;</span></a>';
                        echo '</li>';
                    }else {
                        echo '<li>';
                        echo '<a href="index.php?page='.$pagination->next_page().'" aria-label="Next">';
                        echo '<span aria-hidden=\"true\">&raquo;</span></a></li>';
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    </div>
<?php include ('layouts/footer.php');?>