<?php

function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function __autoload($class_name){
    $class_name = strtolower($class_name);
    $path = LIB_PATH.DS."{$class_name}.php";
    if(file_exists($path)){
        require_once($path);
    }else{
        die("The file {$class_name}.php could not be found");
    }
}

function include_layout_template($template="") {
    include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template);
}

function form_error($field)
{
    global $errors;

    if (!empty($errors)) {
        echo  "<span id=\"helpBlock2\" class=\"help-block\">";
        foreach ($errors as $key => $error) {
            if($key == $field) {
                echo "<p>".htmlentities($error)."</p>";
            }
        }
        echo "</span>";
    }
}

function cut_text($text, $count)
{
 return strlen($text) > $count ? substr($text, 0, $count).'...' : $text;
}

?>