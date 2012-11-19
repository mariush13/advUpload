$(document).ready(function(){
        $('#advUploadForm').on('submit', function(e) {
            e.preventDefault();
            $(this).ajaxSubmit({
                beforeSend: function() {
                    $('#advUploadPercent').html('0%');
                    $('#advUploadProgressPosition').css('width','0%');
                    $('#advUploadProgressPosition').removeClass();
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    $('#advUploadPercent').html(percentComplete+'%');
                    $('#advUploadProgressPosition').css('width',percentComplete+'%');
                },
                complete: function(xhr) {
                    $('#advUploadPercent').html(xhr.responseText);
                    if (xhr.responseText == 'true'){
                        $('#advUploadPercent').html('Wysłano poprawnie');
                        $('#advUploadProgressPosition').addClass('done');
                    }else{
                        $('#advUploadPercent').html('Błąd wysyłania');
                        $('#advUploadProgressPosition').addClass('error');
                    } 
                }
            });
        });
    
});
