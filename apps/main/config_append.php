<?php

$e = (ENVIRONMENT == 'development');
$smarty = new Smarty;
$smarty->cache_dir           = DIR_THEME . 'cache' . DS;
$smarty->compile_dir         = DIR_THEME . 'compile' . DS;
$smarty->config_dir          = DIR_THEME . 'config' . DS;
$smarty->template_dir        = DIR_THEME;
$smarty->caching             = $e ? false : true;
$smarty->compile_check       = $e ? false : true;
$smarty->debugging           = $e ? true : false; 
$smarty->debugging_ctrl      = $e ? 'URL' : 'NONE'; // 'NONE' on production
$smarty->force_compile       = $e ? true : false;