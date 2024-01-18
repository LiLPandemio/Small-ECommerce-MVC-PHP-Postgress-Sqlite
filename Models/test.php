<?php
require "./UserModel.php";

$uModel = new UserModel;

$users = $uModel->showUsers();