<?php
session_start();
    ini_set('Display_errors', 'On');
    ini_set('Error_reporting','On');
    error_reporting(E_ALL);
require './advUpload/advUpload.class.php';
$advUpload = new advUpload;
   
if (isset($_GET['action'])){
    if ($_GET['action'] == 'upload'){
        $advUpload->upload();
    }
    if ($_GET['action'] == 'getProgress'){
        $advUpload->getProgress();
    }
}else {
    
?>
    <html>
        <head>
            
            <script type="text/javascript" src="jquery/jquery-1.8.2.min.js"></script>
            <script type="text/javascript" src="jquery/jquery.form.js"></script>
            <script type="text/javascript" src="./advUpload/advUpload.js"></script>
        </head>
        <body>
            <?=$advUpload->showUploader('files',1);?>
        </body>
    </html>
<? } ?>