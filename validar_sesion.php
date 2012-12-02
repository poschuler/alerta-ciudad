<?php
session_start();

if(!isset($_SESSION['logueado']) or $_SESSION['logueado'] == false)
{
  header("Location: index.php");
}
?>