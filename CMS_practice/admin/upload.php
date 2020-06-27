<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php
$message = "";
if(isset($_POST['submit'])) {
    $photo = new Photo();
    $photo->title = $_POST['title'];
    $photo->set_file($_FILES['filename']);

    if($photo->save_image()) {
        $message = "Photo uploaded.";
    } else {
        $message = join("<br>", $photo->errors);
    }
}

if(isset($_FILES['file'])) {
    $photo = new Photo();
    $photo->title = $_POST['title'];
    $photo->set_file($_FILES['file']);

    if($photo->save_image()) {
        $message = "Photo uploaded.";
    } else {
        $message = join("<br>", $photo->errors);
    }
}

?>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <?php include("includes/top_nav.php"); ?>
        <?php include("includes/sidebar.php"); ?>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Upload
                        <small>Add to Gallery</small>
                    </h1>
                    <div class="row">
                        <div class="col-md-6">
                           <?php echo $message;?>
                            <form action="upload.php" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="text" name="title" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="file" name="filename">
                                </div>
                                <input type="submit" name="submit">
                            </form>
                        </div>
                    </div> <!-- end of row -->
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="upload.php" class="dropzone">

                            </form>
                        </div>
                    </div>
                </div>
            </div>
    <!-- /.row -->

</div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>
