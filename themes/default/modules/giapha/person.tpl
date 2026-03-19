<h1>{LANG.person_profile}: {P.full_name}</h1>
<ul>
    <li>Mã: {P.person_code}</li>
    <li>Sinh: {P.birth_date}</li>
    <li>Mất: {P.death_date}</li>
    <li>Mộ táng: {P.grave_place}</li>
</ul>
<div>{P.biography}</div>

<h3>{LANG.near_relatives}</h3>
<ul>
    <!-- BEGIN: relative -->
    <!-- BEGIN: loop -->
    <li>{R.name} ({R.relation})</li>
    <!-- END: loop -->
    <!-- END: relative -->
</ul>
