
const cropper = new Cropper(document.getElementById("img_cropped"), {
    aspectRatio: 1 / 1,
    preview: '.preview',
    crop(event) {
        console.log(event.detail.x);
        console.log(event.detail.y);
        console.log(event.detail.width);
        console.log(event.detail.height);
        console.log(event.detail.rotate);
        console.log(event.detail.scaleX);
        console.log(event.detail.scaleY);
    },
});
var fileToUpload = document.getElementsByName("fileToUpload")[0]
var $blah = $("#blah");
var $btnCroppeImage = $("#btnCropImage");
var $cropperModal = $("#modalCropperjs");



var uploader;

$blah.on("click", function openFileOption()
{
    if (uploader) {
        uploader.remove();
    }
    uploader = $('<input type="file" name="fileToUpload" accept="image/* style="display:none"/>');
    uploader.click();

    uploader.on('change', function () {
        const [file] = uploader[0].files

        if (file) {
            console.log("ext: ", file.name.split('.').pop());
            console.log("size: ", file.size);
            document.getElementById("imageSize").value = file.size;
            document.getElementById("fileExt").value =  file.name.split('.').pop();
            var reader  = new FileReader();
            reader.onload = function(event)
            {
                var data = event.target.result;

                $cropperModal.modal("show");
                cropper.replace(data);
                setTimeout(function(){

                },200);


            }
            //

            reader.readAsDataURL(uploader[0].files[0]);
            //cropper.replace();//cropper('destroy').cropper('replace', blah);
        }
    });
});



function openFileOption() {
   /* document.getElementById("fileToUpload").click();*/
    if(uploader){
        uploader.remove()
    }
    else
    {

    }
}

$btnCroppeImage.on("click", function () {
    var imgData = cropper.getCroppedCanvas().toDataURL()
    $blah.attr("src", imgData);
    $cropperModal.modal("hide");
    $("#imageUpload").val(imgData);
});


document.getElementById("btnRotate").onclick= function (){
    cropper.rotate(45);
}

