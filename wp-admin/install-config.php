<?php
  function config_htaccess($suburl){
    $data = file_get_contents('data-htaccess.txt');
    if(strlen($suburl)<1){
      $data = str_replace("/mnm/index.php","/index.php",$data);
      $data = str_replace("/mnm/","/",$data);
      
    }
    else{
      $data = str_replace("/mnm/index.php","/".$suburl."/index.php",$data);
      $data = str_replace("/mnm/","/".$suburl."/",$data);
    }
    
    $myfile = fopen("../.htaccess", "w") or die("Unable to open file!");
    fwrite($myfile, $data);
    fclose($myfile);
  }

  function config_database($servername, $username, $password, $db){
      $DB_NAME = "define( 'DB_NAME', "."'".$db."' );";
      $DB_USER = "define( 'DB_USER', '".$username."' );";
      $DB_PASSWORD = "define( 'DB_PASSWORD', '".$password."' );";
      $DB_HOST = "define( 'DB_HOST', '".$servername."' );";
      $data = file_get_contents('data-config.txt');
      $data = str_replace("define( 'DB_NAME', 'zshop' );",$DB_NAME,$data);
      $data = str_replace("define( 'DB_USER', 'root' );",$DB_USER,$data);
      $data = str_replace("define( 'DB_PASSWORD', '' );",$DB_PASSWORD,$data);
      $data = str_replace("define( 'DB_HOST', 'localhost' );",$DB_HOST,$data);
    $myfile = fopen("../wp-config.php", "w") or die("Unable to open file!");
    fwrite($myfile, $data);
    fclose($myfile);
  }


  $conn = false;
 if(!isset($_GET['step'])){ 
        include ('install-step1.php');
    }
  else if($_GET['step'] == 1){
    include ('install-step2.php');
    
  }
  else if($_GET['step'] == 2){
    $servername = $_POST['dbhost'];
    $username = $_POST['uname'];
    $password = $_POST['pwd'];
    $db = $_POST['dbname'];

    // Create connection
    
    $conn = @mysqli_connect($servername, $username, $password,$db);
    if (!$conn) {
      include ('install-step2_error.php');
    return;
  }
  else
  {
    $root = $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $root = str_replace("/wp-admin/install-config.php?step=2","",$root);
    $urlhost = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
    
    $suburl = str_replace($urlhost,"",$root);
    config_htaccess($suburl);
    config_database($servername, $username, $password, $db);
    $sqlSource = file_get_contents('../DB/shop.sql');
    $sqlSource  = str_replace("siteurlvalueresult",$root,$sqlSource);
    mysqli_multi_query($conn,$sqlSource);
    mysqli_close($conn);
    include ('install-success.php');
    
    

  }

  }


  
?>