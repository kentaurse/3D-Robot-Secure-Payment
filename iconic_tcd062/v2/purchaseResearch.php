<?php
/*
Template Name: Purchase Research
*/
get_header();
$userid = $_GET['userid'];

if (!isset($_SESSION['apo_log_tkn'])) {
  header("Location: /login/?action=must_login");
}
