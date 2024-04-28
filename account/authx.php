<?php

session_start();
session_destroy();
session_start();

$_SESSION["feedback"] = "You have been successfully logged out of your account.";

header("Location: ./auth0");
exit();
