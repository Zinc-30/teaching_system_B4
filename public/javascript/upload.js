$(function() {
    var s = $('#file_upload');
    $('#file_upload').uploadify({
        'swf'      : '/teaching_system_B4/public/images/uploadify.swf',
        'uploader' : '/teaching_system_B4/Share/Lib/Action/B4/uploadify.php',
        'method':'post',                       
        'buttonText':'文件上传',
        'queueID': 'uploadDiv',
        'onUploadStart': function(file){
            var element = {};
            var pathRecord = $('#pathRecord');
            element.path = pathRecord.val();
            $('#file_upload').uploadify('settings', 'formData', element);
        },
        'onUploadError' : function(file, errorCode, errorMsg, errorString) {
            alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
        },
        'onUploadSuccess' : function(file, data, response) {
            $('#' + file.id).find('.data').html(' 上传完毕');
            alert('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);
            var uploadNameRecord = document.getElementById('uploadNameRecord');
            var uploadIdRecord = document.getElementById('uploadIdRecord');
            var uploadFlag = document.getElementById('uploadFlag');
            uploadNameRecord.value = file.name;
            uploadIdRecord.value = data;
            uploadFlag.value = 1;
        },
        // new options here
    });
})
