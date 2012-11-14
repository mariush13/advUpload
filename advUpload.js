

function getProgress(){
    console.log('progress');
    $.ajax({
        type: "POST",
        contentType: "text/plain",
        url: "advUpload.php?action=getProgress",
        success: function(data){
            $('#advUploadOutput').html(data);
        }
    })
}
$(document).ready(function(){
    
        $('#advUploadForm').on('submit', function(e) {
            var timer = setInterval(getProgress(), 10);
            e.preventDefault(); // <-- important
            $(this).ajaxSubmit({
               
            });
        });

    
   /* $("#advUploadButton").click(function(event) {    
        console.log('click');
       // var dados = $('#advUploadForm').serialize(); 
        var formData = $('#advUploadForm').serializeObject();
        console.log(formData);
        $.ajax({  
            type: "POST", 
            contentType:"multipart/form-data",
            url: "advUpload.php?action=upload",  
            data: formData, 
            beforeSend: function () {
                console.log('setInterval');
            },
            success: function(data)  
            {  
                clearInterval(timer);
                console.log(data);
            }  
        });  
                  
        return false;  
        } 
    );
    */
    
});
