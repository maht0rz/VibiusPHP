<?php

//this is used to measue script execution time
$GLOBALS['start'] = microtime(true);


//require essential loading class
require '../Core/FrameworkLoader.php';

//Let the magic happen
$Framework -> run();

