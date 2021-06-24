<?php require_once "connection_database.php"; ?>
<?php require_once "guidv4.php" ?>

<?php

function base64_to_jpeg($base64_string, $output_file) {
    // open the output file for writing
    $ifp = fopen( $output_file, 'wb' );

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

    // clean up the file resource
    fclose( $ifp );

    return $output_file;
}

$name = "";
$image_url = "";
$image = "https://app.hhhtm.com/resources/assets/img/upload_img.jpg";
$file_loading_error=[];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    /*$image_url = $_POST['image'];*/
    $image = $_POST["imageUpload"];
    $errors = [];
    if (empty($name)) {
        $errors["name"] = "Name is required";
    }
    else{
        $imgSize = $_POST["imageSize"];
        $target_dir = "uploads/";
        $ext = $_POST["fileExt"];
        $target_file = $target_dir.guidv4().".".$ext;
        $uploadOk = 1;
        echo "<h1>ext: $ext </h1>";
        echo "<h1>size: $imgSize </h1>";
// Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                array_push($file_loading_error, "File is not an image.");
                $uploadOk = 0;
            }
        }

// Check file size
        if ($imgSize > 5000000) {
            array_push($file_loading_error, "Sorry, your file is too large.");
            $uploadOk = 0;
        }

// Allow certain file formats
        if($ext != "jpg" && $ext != "png" && $ext != "jpeg"
            && $ext != "gif" ) {
            array_push($file_loading_error, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            $uploadOk = 0;
        }

// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            array_push($file_loading_error, "Sorry, your file was not uploaded.");
// if everything is ok, try to upload file
        } else {
            if (base64_to_jpeg($image, $target_file)) {
                $stmt = $dbh->prepare("INSERT INTO animals (id, name, image) VALUES (NULL, :name, :image);");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':image', $target_file);
                $stmt->execute();
                header("Location: index.php");
                exit;
            } else {
                array_push($file_loading_error, "Sorry, there was an error uploading your file.");
            }
        }




    }
}
?>



<?php include "_head.php"; ?>

    <div class="container">
        <div class="p-3">
            <h2>Add new animal</h2>
            <form name="addAnimalForm" onsubmit="return addAnimal();" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleInputEmail1">Animal: </label>
                    <?php
                        echo "<input type='text' name='name' class='form-control' id='exampleInputEmail1'
                           placeholder='Enter animal name' value={$name}>"
                    ?>
                    <small class='text-danger' id="name_error" hidden>Name is required!</small>
                    <?php
                        if(isset($errors['name']))
                            echo "<small class='text-danger'>{$errors['name']}</small>"
                    ?>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Select image to upload:</label>
                    <br>
                  <!--  --><?php
/*                        echo"<input class='form-control'  accept='image/*' type='file' name='fileToUpload' id='fileToUpload'>"
                    */?>
                    <?php include "modal.php"; ?>
                    <!--<input  type="file" id="fileToUpload" name='fileToUpload' style="display:none">-->
                    <img onclick="openFileOption()" style="width: 250px; height: 250px; border-radius: 50% " id="blah" src="<?php echo $image ?>" alt="your image" />

                    <input type="hidden" id="imageUpload" name="imageUpload" value="<?php echo $image ?>">
                    <input type="hidden" id="imageSize" name="imageSize" value="<?php echo $imgSize?>">
                    <input type="hidden" id="fileExt" name="fileExt" value="<?php echo $ext?>">
                    <br>
                    <?php
                    foreach ($file_loading_error as &$value) {
                        echo "<small class='text-danger'>$value</small>";
                        }
                    ?>

                    <?php
/*                    echo "<input type='text' name='image' class='form-control' id='exampleInputEmail1'
                           placeholder='Enter animal name' value={$image_url}>"
                    */?>

                    <?php
                        if(isset($errors['image']))
                            echo "<small class='text-danger'>{$errors['image']}</small><br>"
                    ?>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
        </div>
    </div>
<?php include "_footer.php"; ?>
    <script src="js/cropper.min.js"></script>
    <script src="js/addAnimal.js"></script>


