$(function () {
    var max_file_size = 10485760; // 10 MB
    var post_max_size = 19922944; // 19MB

    document.getElementById('fileinput').addEventListener('change', function () {
        document.getElementById("file-chosen").innerHTML = "<b>Files chosen:</b> <br>";
        for(var file = 0; file < this.files.length; file++){
            document.getElementById("file-chosen").innerHTML += this.files[file].name + '<br>';
        }
    }, false);

    document.forms[0].addEventListener('submit', function( evt ) {
        var files = document.getElementById('fileinput').files;
        var passed = true;
        var total = 0;
        for(var file = 0 ; file < files.length; file++){
            if(files[file] && files[file].size < max_file_size) { // 10 MB (this size is in bytes)
                total = total + files[file].size;
            } else {
                passed = false;
                //Prevent default and display error
                bootbox.alert('One of the files you uploaded exceeds the limit of 10MB. Please compress the file and try again');
                evt.preventDefault();
            }
        }

        if(passed && total<= post_max_size){
            buttonDisable('save-btn-ancestors');
            buttonDisable('delete-anc');
        }else{
            bootbox.alert('The total size of the files you uploaded exceeds the limit of 19MB. Please compress the files and try again');
            evt.preventDefault();
        }
    }, false);
});