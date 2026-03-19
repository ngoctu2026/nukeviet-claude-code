<?php

if (!defined('NV_IS_FILE_MODULES')) {
    exit('Stop!!!');
}

$sql_drop_module = [];
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data;
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_member';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . '_memorial';

$sql_create_module = $sql_drop_module;

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . " (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    alias VARCHAR(255) NOT NULL DEFAULT '',
    description TEXT,
    rule_text TEXT,
    created_at INT UNSIGNED NOT NULL DEFAULT 0,
    author_id INT UNSIGNED NOT NULL DEFAULT 0,
    status TINYINT UNSIGNED NOT NULL DEFAULT 1,
    PRIMARY KEY (id),
    KEY alias (alias)
) ENGINE=InnoDB";

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_member (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    tree_id INT UNSIGNED NOT NULL,
    parent_id INT UNSIGNED NOT NULL DEFAULT 0,
    spouse_of INT UNSIGNED NOT NULL DEFAULT 0,
    relation_type VARCHAR(50) NOT NULL DEFAULT 'Con',
    person_code VARCHAR(50) NOT NULL DEFAULT '',
    full_name VARCHAR(250) NOT NULL,
    gender TINYINT NOT NULL DEFAULT 0,
    birth_date VARCHAR(100) NOT NULL DEFAULT '',
    death_date VARCHAR(100) NOT NULL DEFAULT '',
    is_alive TINYINT NOT NULL DEFAULT 1,
    grave_place VARCHAR(255) NOT NULL DEFAULT '',
    biography TEXT,
    image VARCHAR(255) NOT NULL DEFAULT '',
    weight INT UNSIGNED NOT NULL DEFAULT 0,
    addtime INT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY tree_id (tree_id),
    KEY parent_id (parent_id)
) ENGINE=InnoDB";

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_memorial (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    tree_id INT UNSIGNED NOT NULL,
    person_name VARCHAR(255) NOT NULL,
    memorial_date VARCHAR(50) NOT NULL,
    note VARCHAR(255) NOT NULL DEFAULT '',
    PRIMARY KEY (id),
    KEY tree_id (tree_id)
) ENGINE=InnoDB";
