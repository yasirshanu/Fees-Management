<?php
    update("confidential", "passreset=0, passresetkey=NULL", json_encode(['user_id' => $_SESSION['user_id']]), '');
?>