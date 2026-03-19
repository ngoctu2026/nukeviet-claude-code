<?php

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE')) {
    exit('Stop!!!');
}

$module_version = [
    'name' => 'Gia phả',
    'modfuncs' => 'main,view,person',
    'change_alias' => 'view',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '4.5.07',
    'date' => 'Thu, 19 Mar 2026 00:00:00 GMT',
    'author' => 'AI Assistant',
    'note' => 'Module quản lý gia phả cho NukeViet 4.5.07',
    'uploads_dir' => [$module_upload, $module_upload . '/avatars']
];
