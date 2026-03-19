<?php

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

/**
 * Lấy danh sách gia phả.
 */
function nv_giapha_get_trees($onlyPublished = true)
{
    global $db_slave;

    $where = $onlyPublished ? ' WHERE status = 1' : '';
    $sql = 'SELECT id, title, alias, description, rule_text, created_at, author_id FROM ' . NV_PREFIXLANG . '_giapha' . $where . ' ORDER BY id DESC';

    return $db_slave->query($sql)->fetchAll();
}

/**
 * Lấy thông tin một gia phả.
 */
function nv_giapha_get_tree($treeId)
{
    global $db_slave;

    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_giapha WHERE id=' . (int) $treeId;

    return $db_slave->query($sql)->fetch();
}

/**
 * Lấy danh sách thành viên theo gia phả.
 */
function nv_giapha_get_members($treeId)
{
    global $db_slave;

    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_giapha_member WHERE tree_id=' . (int) $treeId . ' ORDER BY weight ASC, id ASC';

    return $db_slave->query($sql)->fetchAll();
}

/**
 * Dựng cây đa cấp từ danh sách thành viên.
 */
function nv_giapha_build_tree(array $members)
{
    $nodes = [];
    $roots = [];

    foreach ($members as $member) {
        $member['children'] = [];
        $nodes[$member['id']] = $member;
    }

    foreach ($nodes as $id => $node) {
        if (!empty($node['parent_id']) and isset($nodes[$node['parent_id']])) {
            $nodes[$node['parent_id']]['children'][] = &$nodes[$id];
        } else {
            $roots[] = &$nodes[$id];
        }
    }

    return $roots;
}

/**
 * Tạo alias an toàn cho gia phả.
 */
function nv_giapha_make_alias($title)
{
    return change_alias($title);
}
