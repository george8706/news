<?php

    defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);
    defined("SITE_ROOT") ? null : define ("SITE_ROOT", realpath('../'));
    defined("LIB_PATH") ? null : define("LIB_PATH", SITE_ROOT.DS.'includes');

    require_once(LIB_PATH.DS."config.php");
    require_once(LIB_PATH.DS."session.php");
    require_once(LIB_PATH.DS."FlashMessages.php");
    require_once(LIB_PATH.DS."functions.php");
    require_once(LIB_PATH.DS."validation_functions.php");
    require_once(LIB_PATH.DS."news.php");
    require_once(LIB_PATH.DS."pagination.php");

?>