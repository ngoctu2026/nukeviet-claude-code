<?php

if (!defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

function nv_giapha_theme_main($rows)
{
    global $module_info, $module_name, $lang_module;

    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_name);

    foreach ($rows as $row) {
        $xtpl->assign('ROW', [
            'title' => $row['title'],
            'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=view/' . $row['alias'] . '-' . $row['id'],
            'description' => nv_htmlspecialchars($row['description'])
        ]);
        $xtpl->parse('main.loop');
    }

    $xtpl->assign('LANG', $lang_module);
    $xtpl->parse('main');

    return $xtpl->text('main');
}

function nv_giapha_theme_tree_nodes($xtpl, $nodes)
{
    foreach ($nodes as $node) {
        $xtpl->assign('NODE', [
            'name' => nv_htmlspecialchars($node['full_name']),
            'code' => nv_htmlspecialchars($node['person_code']),
            'id' => $node['id']
        ]);

        if (!empty($node['children'])) {
            nv_giapha_theme_tree_nodes($xtpl, $node['children']);
        }

        $xtpl->parse('view.tree.node');
    }
}

function nv_giapha_theme_view($tree, $roots, $memorials)
{
    global $module_info, $module_name, $lang_module;

    $xtpl = new XTemplate('view.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_name);

    $xtpl->assign('TREE', [
        'title' => nv_htmlspecialchars($tree['title']),
        'description' => nv_htmlspecialchars($tree['description']),
        'rule_text' => nv_htmlspecialchars($tree['rule_text'])
    ]);

    nv_giapha_theme_tree_nodes($xtpl, $roots);

    foreach ($memorials as $row) {
        $xtpl->assign('MEM', [
            'person_name' => nv_htmlspecialchars($row['person_name']),
            'memorial_date' => nv_htmlspecialchars($row['memorial_date']),
            'note' => nv_htmlspecialchars($row['note'])
        ]);
        $xtpl->parse('view.memorial.loop');
    }

    $xtpl->assign('LANG', $lang_module);
    $xtpl->parse('view.tree');
    $xtpl->parse('view.memorial');
    $xtpl->parse('view');

    return $xtpl->text('view');
}

function nv_giapha_theme_person($person, $relatives)
{
    global $module_info, $lang_module;

    $xtpl = new XTemplate('person.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/giapha');

    $xtpl->assign('P', [
        'full_name' => nv_htmlspecialchars($person['full_name']),
        'person_code' => nv_htmlspecialchars($person['person_code']),
        'birth_date' => nv_htmlspecialchars($person['birth_date']),
        'death_date' => nv_htmlspecialchars($person['death_date']),
        'grave_place' => nv_htmlspecialchars($person['grave_place']),
        'biography' => nl2br(nv_htmlspecialchars($person['biography']))
    ]);

    foreach ($relatives as $relative) {
        $xtpl->assign('R', [
            'name' => nv_htmlspecialchars($relative['full_name']),
            'relation' => nv_htmlspecialchars($relative['relation_type'])
        ]);
        $xtpl->parse('person.relative.loop');
    }

    $xtpl->assign('LANG', $lang_module);
    $xtpl->parse('person.relative');
    $xtpl->parse('person');

    return $xtpl->text('person');
}
