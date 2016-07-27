<?php
    $errors = array();
    $_SESSION['errors'] = $errors;

    function fieldname_as_text($fieldname){
        $fieldname = str_replace("_", " ", $fieldname);
        $fieldname = ucfirst($fieldname);
        return $fieldname;
    }

    function has_presence($value){
        return isset($value) && $value !== "";
    }

    function validate_presences($required_fields){
        global $errors;

        foreach ($required_fields as $field){
            $value = trim($_POST[$field]);
            if(!has_presence($value)){
                $errors[$field] = fieldname_as_text($field). " can't be blank";
            }
        }

    }

    function has_max_length($value, $max){
        return strlen($value) <= $max;
    }

    function validate_max_lengths($fields_with_max_lengths){
        global $errors;

        foreach ($fields_with_max_lengths as $field => $max){
            $value = trim($_POST[$field]);
            if (!has_max_length($value, $max)) {
                $errors[$field] = fieldname_as_text($field) . " must be not greater then $max characters";
            }
        }
    }

    function has_min_length($value, $min){
        return strlen($value) >= $min;
    }

    function validate_min_lengths($fields_with_max_lengths){
        global $errors;
        
        foreach ($fields_with_max_lengths as $field => $min) {
            $value = trim($_POST[$field]);
            if($value !=="") {
                if (!has_min_length($value, $min)) {
                    $errors[$field] = fieldname_as_text($field) . " must be at least than $min characters";
                }
            } else continue;
        }
    }


    function validate_captcha(){
        global $errors;
        
        /*if (!empty($_REQUEST['captcha'])) {
            if (empty($_SESSION['captcha']) || trim(strtolower($_REQUEST['captcha'])) != $_SESSION['captcha']) {
                return true;
            } else {
                $errors['captcha'] = "Invalid captcha";
            }
        }*/
        if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $_POST['keystring']){
            return true;
        }else{
            $errors['keystring']= "Invalid captcha";
        }
    }

    function validate_date($date) {
        global $errors;
        
        if(preg_match("/^(\d{2})-(\d{2})-(\d{4})$/", $date, $matches)) {
            if(checkdate($matches[1], $matches[2], $matches[3])) {
                return true;
            }
        }else{
            $errors['date'] = "Enter valid date in format dd-mm-yyyy";
        }
    }

?>

