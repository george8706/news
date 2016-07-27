<?php require_once('../includes/initialize.php');?>

<?php $current_page = 'manage_news';?>
<?php $page_title = "Manage News"?>
<?php include('layouts/header.php');?>
<?php

$page = !empty($_GET['page'])?(int)$_GET['page']:1;
$per_page = 10;
$news = new News();
$total_count = $news->getRows(['select', 'return_type'=>'count']);

$pagination = new Pagination($page, $per_page, $total_count);

$allnews = $news->getRows(['order_by'=>'id ASC','limit'=>$per_page, 'offset'=>$pagination->offset(), 'return_type'=>'all']);

?>
<div id="wrapman">
<div class="row">
    <div class="col-xs-10 col-md-10 col-lg-10 col-lg-offset-1 col-md-offset-1 col-xs-offset-1">
        <?php $flash->display()?>
        <div class="page-header">
            <h3>News list</h3>
        </div>
        <div class="panel panel-default users-content">
            <div class="panel-heading">News<a href="add.php" class="glyphicon glyphicon-plus"></a></div>

            <table class="table">
                <tr>
                    <th >ID</th>
                    <th id="ttitle" >Title</th>
                    <th id="tcontent" >Content</th>
                    <th id="tdate">Date</th>
                    <th id="taction"></th>
                </tr>
                <?php
                if(!empty($allnews)){
                    foreach($allnews as $new){;?>
                    <tr>
                        <td><?php echo $new->id; ?></td>
                        <td><?php echo $new->caption; ?></td>
                        <td><p class="clip"><?php echo cut_text($new->text, 200);?></p></td>
                        <td><?php echo date("d-m-Y", $new->date); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $new->id; ?>" class="glyphicon glyphicon-edit "></a>
                            <a href="delete.php?id=<?php echo $new->id; ?>" class="glyphicon glyphicon-trash" onclick="return confirm('Are you sure?');"></a>
                        </td>
                    </tr>
                <?php } }else{ ?>
                <tr><td colspan="4">No record(s) found......</td>
                    <?php } ?>
            </table>
        </div>

        <div class="text-center">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php
                if($pagination->total_pages() > 1) {
                    if(!$pagination->has_previous_page()) {
                        echo '<li class="disabled">';
                        echo '<a href="" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>';
                        echo '</li>';
                    }else {
                        echo '<li>';
                        echo '<a href="manage_news.php?page='.$pagination->previous_page().'" aria-label="Previous">';
                        echo '<span aria-hidden=\"true\">&laquo;</span></a></li>';
                    }

                    for($i=1; $i <= $pagination->total_pages(); $i++) {
                        if($i == $page) {
                            echo "<li class='active'><a href=\"#\">{$i}<span class=\"sr-only\">(current)</span></a></li>";
                        } else {
                            echo "<li><a href=\"manage_news.php?page={$i}\">{$i}</a></li>";
                        }
                    }

                    if(!$pagination->has_next_page()) {
                        echo '<li class="disabled">';
                        echo '<a href="" aria-label="Previous"><span aria-hidden="true">&raquo;</span></a>';
                        echo '</li>';
                    }else {
                        echo '<li>';
                        echo '<a href="manage_news.php?page='.$pagination->next_page().'" aria-label="Next">';
                        echo '<span aria-hidden=\"true\">&raquo;</span></a></li>';
                    }
                }
                ?>
            </ul>
        </nav>

        </div>
    </div>
</div>
</div>

<?php include_layout_template('footer.php');?>