<!-- The Modal -->


<div class="modal" id="modalDelete">
    <div class="modal-dialog">
        <div class="modal-content shadow" id="modalDeleteContent">

        </div>
    </div>
</div>



<div class="modal" id="modalCropperjs" tabindex="-1" aria-labelledby="exampleModalLabel" data-keyboard="false" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <img width="100%" height="100%" id="img_cropped"
                                 src="https://app.hhhtm.com/resources/assets/img/upload_img.jpg" alt="your image"/>
                        </div>
                        <div class="col-md-4" >
                                <div class="preview ml-4"></div>
                                <button type="button" id="btnRotate" class="btn btn-ifno mt-3 ml-5">Rotate</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btnCropImage" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>