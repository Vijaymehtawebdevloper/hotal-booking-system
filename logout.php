<?php
    include("admin/inc/essencials.php");
    session_start();
    session_destroy();
    redirect("index.php");
?>