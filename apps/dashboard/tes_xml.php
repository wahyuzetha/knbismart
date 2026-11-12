<?php
$nama_xml="xml_asc/jadwal.xml";
$filexml = simplexml_load_file($nama_xml);

echo "<pre>";
print_r ($filexml);
echo "</pre>";
?>