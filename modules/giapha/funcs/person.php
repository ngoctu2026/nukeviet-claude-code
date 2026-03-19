<?php

if (!defined('NV_IS_MOD_GIAPHA')) {
    exit('Stop!!!');
}

global $db_slave;

$personId = $nv_Request->get_int('id', 'get', 0);
if ($personId < 1) {
    nv_info_die($lang_module['error_person_not_found'], NV_HTTPSTATUS_BADREQUEST, $lang_module['error_person_not_found']);
}

$person = $db_slave->query('SELECT * FROM ' . NV_PREFIXLANG . '_giapha_member WHERE id=' . $personId)->fetch();
if (empty($person)) {
    nv_info_die($lang_module['error_person_not_found'], NV_HTTPSTATUS_BADREQUEST, $lang_module['error_person_not_found']);
}

$relatives = $db_slave->query('SELECT full_name, relation_type FROM ' . NV_PREFIXLANG . '_giapha_member WHERE tree_id=' . (int) $person['tree_id'] . ' AND (parent_id=' . $personId . ' OR spouse_of=' . $personId . ') ORDER BY id ASC')->fetchAll();

$page_title = $person['full_name'];
$key_words = $person['full_name'];

$contents = nv_giapha_theme_person($person, $relatives);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
