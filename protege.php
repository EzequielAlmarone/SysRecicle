<?php
if(session_status() !== PHP_SESSION_ACTIVE){
  session_start();
}
if(!isset($_SESSION['idusuario'])){
  header('location:login.php');
  exit;
}
