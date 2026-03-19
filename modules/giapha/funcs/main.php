<?php

if (!defined('NV_IS_MOD_GIAPHA')) {
    exit('Stop!!!');
}

$page_title = $module_info['custom_title'];
$key_words = $module_info['keywords'];

$contents = nv_giapha_theme_main(nv_giapha_get_trees(true));

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
