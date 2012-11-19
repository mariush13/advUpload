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
 * $config = array(
 *     'uploadDir' => 'your_upload_dir',
 *     'uploadAction => 'your_upload_action'
 *     ...
 * );
 * and then:
 * $advUpload->setConfig($config);
 * 
 * In place where you want to put advUpload write: 
 * $advUpload->showUploader($files);
 * where $files contain cout of uploaders
 * 
 */

class advUpload {
 
    public $config = array(
        'formID' => 'advUploadForm',
        'uploadDir' => './upload',
        'uploadAction' => 'advUploadFiles',
        'successText' => 'Wysłano poprawnie',
        'errorText' => 'Błąd wysyłania',
        'showUploadText' => false,
        'showUploadProgressBar' => false
    );

    public function __construct(){
        if (isset($_GET['action']) && $_GET['action'] == $this->config['uploadAction']){  
            $this->upload();
            exit;
        }
    }   

    public function showUploader($files = 1) {      
        $return = '<form id="'.$this->config['formID'].'" method="POST" action ="'.$_SERVER["PHP_SELF"].'?action='.$this->config['uploadAction'].'" enctype="multipart/form-data">'."\n";;
        for($i=0; $i<$files; $i++){
            $return .= '<input type="file" name="advUploadFile_'.$i.'">'."\n";
        }
        $return .= '<input id="advUploadButton" type="submit" value="Wyślij">'."\n";      
        $return .= ($this->config['showUploadProgressBar'])?'<div id="advUploadProgressBar"><div id="advUploadProgressPosition"></div></div>':'';
        $return .= ($this->config['showUploadText'])?'<div id="advUploadText"></div>'."\n":'';
        $return .= '</form>'."\n";
        return $return;
    }
    
    public function setConfig($config){
        foreach ($config as $key => $value){
            $this->config[$key] = $value;
        }
    }
    
    public function showScripts(){
        
        $return = '$(document).ready(function(){
            	$(\'#'.$this->config['formID'].'\').on(\'submit\', function(e) {
                e.preventDefault();
                $(this).ajaxSubmit({
                    beforeSend: function() {
                        '.(($this->config['showUploadText'])?'$(\'#advUploadText\').html(\'0%\');':'').'
                        '.(($this->config['showUploadProgressBar'])?'$(\'#advUploadProgressPosition\').css(\'width\',\'0%\');
                        $(\'#advUploadProgressPosition\').removeClass();':'').'                        
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                        '.(($this->config['showUploadText'])?'$(\'#advUploadText\').html(percentComplete+\'%\');':'').'
                        '.(($this->config['showUploadProgressBar'])?'$(\'#advUploadProgressPosition\').css(\'width\',percentComplete+\'%\');':'').'        
                    },
                    complete: function(xhr) {
                        $(\':file\').val(\'\');
                        if (xhr.responseText == \'true\'){
                            '.(($this->config['showUploadText'])?'$(\'#advUploadText\').html(\''.$this->config['successText'].'\');':'').'
                            '.(($this->config['showUploadProgressBar'])?'$(\'#advUploadProgressPosition\').addClass(\'done\');':'').'
                        }else{
                        	'.(($this->config['showUploadText'])?'$(\'#advUploadText\').html(\''.$this->config['errorText'].'\');':'').'
                        	'.(($this->config['showUploadProgressBar'])?'$(\'#advUploadProgressPosition\').addClass(\'error\');':'').'                          
                        } 
                    }
                });
            });    
    	});';
        return $return;
    }
            
    private function upload(){
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