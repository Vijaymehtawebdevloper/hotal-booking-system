<?php
    include("inc/essencials.php");
    session_start();
    session_destroy();
    redirect("index.php");
?>