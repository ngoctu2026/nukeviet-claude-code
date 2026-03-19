<?php

if (!defined('NV_IS_MOD_GIAPHA')) {
    exit('Stop!!!');
}

global $db_slave;

$alias = isset($array_op[0]) ? trim($array_op[0]) : '';
$id = 0;
if (preg_match('/(.*)-([0-9]+)$/', $alias, $m)) {
    $id = (int) $m[2];
}

$tree = nv_giapha_get_tree($id);
if (empty($tree)) {
    nv_info_die($lang_module['error_tree_not_found'], NV_HTTPSTATUS_BADREQUEST, $lang_module['error_tree_not_found']);
}

$members = nv_giapha_get_members($id);
$roots = nv_giapha_build_tree($members);
$memorials = $db_slave->query('SELECT person_name, memorial_date, note FROM ' . NV_PREFIXLANG . '_giapha_memorial WHERE tree_id=' . $id . ' ORDER BY memorial_date ASC')->fetchAll();

$page_title = $tree['title'];
$key_words = $tree['title'];

$contents = nv_giapha_theme_view($tree, $roots, $memorials);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
