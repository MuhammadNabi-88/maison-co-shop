<?php require __DIR__.'/includes/bootstrap.php';$_SESSION=[];session_regenerate_id(true);notice('You have signed out.');go('index.php');?>
