<?php
/* 
Template Name: Logout 
*/  
session_destroy();

header("Location: /");