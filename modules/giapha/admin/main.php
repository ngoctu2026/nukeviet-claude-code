<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

global $db, $db_slave, $nv_Request, $lang_module;

$error = '';

if ($nv_Request->isset_request('save_tree', 'post')) {
    $title = $nv_Request->get_title('title', 'post', '');
    $description = $nv_Request->get_textarea('description', '', NV_ALLOWED_HTML_TAGS);
    $ruleText = $nv_Request->get_textarea('rule_text', '', NV_ALLOWED_HTML_TAGS);

    if (!empty($title)) {
        $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_giapha (title, alias, description, rule_text, created_at, author_id, status) VALUES (:title, :alias, :description, :rule_text, :created_at, :author_id, 1)');
        $alias = nv_giapha_make_alias($title);
        $createdAt = NV_CURRENTTIME;
        $authorId = defined('NV_IS_ADMIN') ? (int) $admin_info['userid'] : 0;
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':alias', $alias, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':rule_text', $ruleText, PDO::PARAM_STR);
        $stmt->bindParam(':created_at', $createdAt, PDO::PARAM_INT);
        $stmt->bindParam(':author_id', $authorId, PDO::PARAM_INT);
        $stmt->execute();

        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main');
    } else {
        $error = $lang_module['error_title'];
    }
}

if ($nv_Request->isset_request('save_member', 'post')) {
    $treeId = $nv_Request->get_int('tree_id', 'post', 0);
    $parentId = $nv_Request->get_int('parent_id', 'post', 0);
    $spouseOf = $nv_Request->get_int('spouse_of', 'post', 0);
    $fullName = $nv_Request->get_title('full_name', 'post', '');
    $personCode = $nv_Request->get_title('person_code', 'post', '');
    $relationType = $nv_Request->get_title('relation_type', 'post', 'Con');

    if ($treeId > 0 and !empty($fullName)) {
        $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_giapha_member (tree_id, parent_id, spouse_of, relation_type, full_name, person_code, gender, is_alive, weight, addtime) VALUES (:tree_id, :parent_id, :spouse_of, :relation_type, :full_name, :person_code, 0, 1, 0, :addtime)');
        $addtime = NV_CURRENTTIME;
        $stmt->bindParam(':tree_id', $treeId, PDO::PARAM_INT);
        $stmt->bindParam(':parent_id', $parentId, PDO::PARAM_INT);
        $stmt->bindParam(':spouse_of', $spouseOf, PDO::PARAM_INT);
        $stmt->bindParam(':relation_type', $relationType, PDO::PARAM_STR);
        $stmt->bindParam(':full_name', $fullName, PDO::PARAM_STR);
        $stmt->bindParam(':person_code', $personCode, PDO::PARAM_STR);
        $stmt->bindParam(':addtime', $addtime, PDO::PARAM_INT);
        $stmt->execute();

        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main');
    }
}

if ($nv_Request->isset_request('save_memorial', 'post')) {
    $treeId = $nv_Request->get_int('tree_id', 'post', 0);
    $personName = $nv_Request->get_title('person_name', 'post', '');
    $memorialDate = $nv_Request->get_title('memorial_date', 'post', '');
    $note = $nv_Request->get_title('note', 'post', '');

    if ($treeId > 0 and !empty($personName) and !empty($memorialDate)) {
        $stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_giapha_memorial (tree_id, person_name, memorial_date, note) VALUES (:tree_id, :person_name, :memorial_date, :note)');
        $stmt->bindParam(':tree_id', $treeId, PDO::PARAM_INT);
        $stmt->bindParam(':person_name', $personName, PDO::PARAM_STR);
        $stmt->bindParam(':memorial_date', $memorialDate, PDO::PARAM_STR);
        $stmt->bindParam(':note', $note, PDO::PARAM_STR);
        $stmt->execute();

        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main');
    }
}

$trees = nv_giapha_get_trees(false);

$contents = '<h2>' . $lang_module['manage'] . '</h2>';
if (!empty($error)) {
    $contents .= '<div class="alert alert-danger">' . nv_htmlspecialchars($error) . '</div>';
}

$contents .= '<h3>' . $lang_module['create_tree'] . '</h3>';
$contents .= '<form method="post"><input type="hidden" name="save_tree" value="1" />';
$contents .= '<p><input class="form-control" type="text" name="title" placeholder="' . $lang_module['title'] . '" /></p>';
$contents .= '<p><textarea class="form-control" name="description" placeholder="' . $lang_module['description'] . '"></textarea></p>';
$contents .= '<p><textarea class="form-control" name="rule_text" placeholder="' . $lang_module['rule_text'] . '"></textarea></p>';
$contents .= '<p><button class="btn btn-primary" type="submit">' . $lang_module['save'] . '</button></p></form>';

$contents .= '<h3>' . $lang_module['create_member'] . '</h3>';
$contents .= '<form method="post"><input type="hidden" name="save_member" value="1" />';
$contents .= '<p><select class="form-control" name="tree_id">';
foreach ($trees as $tree) {
    $contents .= '<option value="' . $tree['id'] . '">' . nv_htmlspecialchars($tree['title']) . '</option>';
}
$contents .= '</select></p>';
$contents .= '<p><input class="form-control" type="text" name="full_name" placeholder="' . $lang_module['full_name'] . '" /></p>';
$contents .= '<p><input class="form-control" type="text" name="person_code" placeholder="' . $lang_module['person_code'] . '" /></p>';
$contents .= '<p><input class="form-control" type="number" name="parent_id" placeholder="Parent ID" /></p>';
$contents .= '<p><input class="form-control" type="number" name="spouse_of" placeholder="Spouse of ID" /></p>';
$contents .= '<p><select class="form-control" name="relation_type"><option value="Con">Con</option><option value="Vợ">Vợ</option></select></p>';
$contents .= '<p><button class="btn btn-primary" type="submit">' . $lang_module['save'] . '</button></p></form>';

$contents .= '<h3>' . $lang_module['add_memorial'] . '</h3>';
$contents .= '<form method="post"><input type="hidden" name="save_memorial" value="1" />';
$contents .= '<p><select class="form-control" name="tree_id">';
foreach ($trees as $tree) {
    $contents .= '<option value="' . $tree['id'] . '">' . nv_htmlspecialchars($tree['title']) . '</option>';
}
$contents .= '</select></p>';
$contents .= '<p><input class="form-control" type="text" name="person_name" placeholder="' . $lang_module['person_name'] . '" /></p>';
$contents .= '<p><input class="form-control" type="text" name="memorial_date" placeholder="' . $lang_module['memorial_date'] . '" /></p>';
$contents .= '<p><input class="form-control" type="text" name="note" placeholder="' . $lang_module['note'] . '" /></p>';
$contents .= '<p><button class="btn btn-primary" type="submit">' . $lang_module['save'] . '</button></p></form>';

$contents .= '<h3>' . $lang_module['list_trees'] . '</h3><ul>';
foreach ($trees as $tree) {
    $contents .= '<li>' . nv_htmlspecialchars($tree['title']) . '</li>';
}
$contents .= '</ul>';

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
