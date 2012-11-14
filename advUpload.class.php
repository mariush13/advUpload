<?php

class advUpload {
    
    protected $name;
    protected $sessionName;
    protected $sessionKey;
    public $uploadDir = './upload';
    
    public function __construct(){
        
    }   

    public function showUploader($name, $files = 1) {
        $this->name = $name;
        $this->sessionName = ini_get('session.upload_progress.name');
        $this->sessionKey = ini_get('session.upload_progress.prefix');
        
        $return = '<form id="advUploadForm" method="POST" action ="'.$_SERVER["PHP_SELF"].'?action=upload" enctype="multipart/form-data" target="advUploadIframe">';
        $return .= '<input type="hidden" name="'.$this->sessionName.'_advUploadFiles" value="'.$this->name.'">';
        for($i=0; $i<$files; $i++){
            $return .= '<input type="file" name="advUploadFile_'.$i.'">';
        }
        $return .= '<input id="advUploadButton" type="submit" value="Wyślij">';
        $return .= '<div id="advUploadOutput"></div>';
        $return .= '<iframe id="advUploadIframe" name="advUploadIframe" src="about:blank"></iframe>';
        $return .= '</form>';
        return $return;
    }
        
    public function getProgress(){
        var_dump($_SESSION);
        echo time(now);
    }
    
    public function upload(){
        $done = array();
        if (!empty($_FILES)){
            foreach ($_FILES as $file){
                $name = preg_replace("/[^A-Z0-9._-]/i", "_", $file["name"]);
                $done[] = move_uploaded_file($file["tmp_name"],$this->uploadDir.'/'. $name);      
            }
        }
        var_dump($done);
    }
    
}

?>