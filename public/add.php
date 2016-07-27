<?php require_once('../includes/initialize.php'); ?>
<?php $current_page = 'add_news';?>
<?php $page_title = "Add News"?>
<?php include('layouts/header.php');?>
<?

if(isset($_POST['submitButton'])) {

    $caption = htmlentities($_POST['caption']);
    $text = htmlentities($_POST['text']);
    $date = htmlentities($_POST['date']);

    $required_fields = array('caption', 'text', 'date', 'keystring');
    validate_presences($required_fields);

    $fields_with_max_lengths = array('caption' => 100);
    validate_max_lengths($fields_with_max_lengths);

    $fields_with_min_lengths = array('caption' => 3, 'text' => 3);
    validate_min_lengths($fields_with_min_lengths);

    validate_captcha();

    validate_date($date);
    
    if (empty($errors)) {

        $feed = new News();
        $feed->caption = $_POST['caption'];
        $feed->text = $_POST['text'];
        $feed->date = strtotime($_POST['date']);
    
        if ($feed->save()) {

            $flash->success("New record has been added");
            redirect_to("index.php");
        } else {

            $flash->error("Fail adding new record");
        }
    }
}

?>
<div class="row">
    <div class="col-xm-6 col-md-6 col-lg-6 col-xm-offset-3 col-md-offset-3 col-lg-offset-3">
        <div class="page-header">
            <h3>Add News</h3>
        </div>
        <form id="newsForm" action="add.php" method="post">
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
            <div class="clearfix"></div>
            <div class="col-xs-5 col-xs-offset-3">
            <div class="form-group <?php if(isset($errors['keystring'])) echo "has-error";?>">

                    <label for="captcha">Enter text shown below:</label>
                    <p>
                        <img src="kcaptcha/?<?php echo session_name()?>=<?php echo session_id()?>" id="captchaimg" /><br/>
                    </p>

                    <input type="text" name="keystring"  class="form-control" id="captcha">
                    <?php form_error('keystring');?>

            </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
                <button type="submit" name="submitButton" class="btn btn-success">Add</button>
            </div>

        </form>
    </div>
</div>

<?php include('layouts/footer.php');?>