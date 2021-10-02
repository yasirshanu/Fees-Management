<?php
    require_once("connect.php");
    $sitetitle = getvalue('setting_value', 'settings', json_encode(['setting_name' => 'sitetitle']), '');
    $sitename = getvalue('setting_value', 'settings', json_encode(['setting_name' => 'sitename']), '');
    $username = "Yasir Ansari";
?>