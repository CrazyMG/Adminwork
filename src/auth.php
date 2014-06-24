<?php

if(!isset($_SESSION['user_role'])){
	$app->redirect("/login");
}