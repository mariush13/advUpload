<?php

/*
 * advUpload by Mariush
 * version 0.9.0
 * 
 * Required jQuery and jQuery.Form!
 * 
 * Usage:
 * 
 * Include or require this file
 * 
 * Make a PHP variable with instance of advUpload class
 * eg.
 * $advUpload = new advUpload;
 * 
 * If you want to change uploder config write:
 * $advUpload->config = array(
 *     'uploadDir' => 'your_upload_dir',
 *     'uploadAction => 'your_upload_action'
 * );
 * 
 * In place where you want to put advUpload write: 
 * $advUpload->showUploader($files);
 * where $files contain cout of uploaders
 * 
 */

class advUpload {
    
    public $config = array(
        'uploadDir' => './upload',
        'uploadAction' => 'advUploadFiles'
    );
    
    public function __construct(){
        if (isset($_GET['action']) && $_GET['action'] == $this->config['uploadAction']){  
            $this->upload();
            exit;
        }
    }   

    public function showUploader($files = 1) {      
        $return = '<form id="advUploadForm" method="POST" action ="'.$_SERVER["PHP_SELF"].'?action='.$this->config['uploadAction'].'" enctype="multipart/form-data">'."\n";;
        for($i=0; $i<$files; $i++){
            $return .= '<input type="file" name="advUploadFile_'.$i.'">'."\n";
        }
        $return .= '<input id="advUploadButton" type="submit" value="Wyślij">'."\n";
        $return .= '<div id="advUploadPercent"></div>'."\n";
        $return .= '<div id="advUploadProgressBar"><div id="advUploadProgressPosition"></div></div>';
        $return .= '</form>'."\n";
        return $return;
    }
            
    public function upload(){
        $result = true;
        $done = array();
        if (!empty($_FILES)){
            foreach ($_FILES as $file){
                $name = preg_replace("/[^A-Z0-9._-]/i", "_", $file["name"]);
                $done[] = move_uploaded_file($file["tmp_name"],$this->config['uploadDir'].'/'. $name);      
            }
        }
        foreach ($done as $res) {
            if (!$res) {
                $result = false;
            }
        }
        echo ($res)? 'true' : 'false';
    }
    
}

?>