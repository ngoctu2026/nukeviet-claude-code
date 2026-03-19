<h1>{TREE.title}</h1>
<div>{TREE.description}</div>
<h3>{LANG.rule_text}</h3>
<div>{TREE.rule_text}</div>

<h3>{LANG.family_tree}</h3>
<ul>
    <!-- BEGIN: tree -->
    <!-- BEGIN: node -->
    <li><a href="index.php?nv=giapha&op=person&id={NODE.id}">{NODE.code} - {NODE.name}</a></li>
    <!-- END: node -->
    <!-- END: tree -->
</ul>

<h3>{LANG.ancestor_day}</h3>
<ul>
    <!-- BEGIN: memorial -->
    <!-- BEGIN: loop -->
    <li>{MEM.person_name}: {MEM.memorial_date} ({MEM.note})</li>
    <!-- END: loop -->
    <!-- END: memorial -->
</ul>
