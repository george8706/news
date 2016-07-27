<?php require_once('../includes/initialize.php');?>

<?php $current_page = '';?>

<?php include ('layouts/header.php');?>

<?php
if(empty($_GET['id'])) redirect_to('manage_news.php');
$feed = new News();
$news_one = $feed->getRows(['where'=>array('id'=>$_GET['id']),'return_type'=>'single']);
if(!$news_one) redirect_to('manage_news.php');
if(!isset($_POST['submitButton'])) {
    $caption = $news_one->caption;
    $text = $news_one->text;
    $date = date('d-m-Y',$news_one->date);
    }else{

        $caption = htmlentities($_POST['caption']);
        $text = htmlentities($_POST['text']);
        $date = date('d-m-Y',htmlentities($_POST['date']));

        $required_fields = array('caption', 'text', 'date');
        validate_presences($required_fields);

        $fields_with_max_lengths = array('caption' => 100);
        validate_max_lengths($fields_with_max_lengths);

        $fields_with_min_lengths = array('caption' => 3, 'text' => 3);
        validate_min_lengths($fields_with_min_lengths);

        validate_date($date);

        if (empty($errors)) {

            //$feed = new News();
            $feed->id = $news_one->id;
            $feed->caption = $_POST['caption'];
            $feed->text = $_POST['text'];
            $feed->date = strtotime($_POST['date']);

            if ($feed->save()) {

                $flash->success("Record has been updated");
                redirect_to("manage_news.php");
            } else {

                $flash->error("Fail adding new record");
            }
    }
}
?>
    <div class="row">
        <div class="col-md-6 col-xm-6 col-lg-6 col-lg-offset-3">
            <?php $flash->display()?>
            <div class="page-header">
                <h3>Edit News</h3>
            </div>
            <form id="newsForm" action="edit.php?id=<?php echo $news_one->id?>" method="post">
                <div class="form-group has-feedback <?php if(isset($errors['caption'])) echo "has-error";?>">
                    <label for="caption">Caption</label>
                    <input type="text" name="caption" class="form-control" id="caption" value="<?php echo $caption?>">
                    <?php form_error('caption');?>
                </div>
                <div class="form-group <?php if(isset($errors['text'])) echo "has-error";?>">
                    <label for="text">Text News</label>
                    <textarea name="text" class="form-control" id="text" rows="5"><?php echo $text?></textarea>
                    <?php form_error('text');?>
                </div>

                <div class="form-group <?php if(isset($errors['date'])) echo "has-error";?>">
                    <label class="control-label for="datepicker">Date</label>
                    <div class="clearfix"></div>
                    <div id="dpic" class="col-xm-5">
                        <div class="input-group">
                            <input type="text" name="date" id="datepicker" class="form-control" placeholder="dd-mm-yyyy" value="<?php echo $date?>">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span><span>
                        </div>
                    </div>
                    <?php form_error('date');?>
                </div>
                <div class="form-group">
                    <button type="submit" name="submitButton" class="btn btn-success">Submit</button>
                </div>

            </form>
        </div>
    </div>

<?php include('layouts/footer.php');?>