<?php include("includes/header.php"); ?>
<?php include("includes/photo-modal.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php

if(empty($_GET['id'])) {
    redirect("photos.php");
}

$user = User::find_by_id($_GET['id']);

if(isset($_POST['update'])) {
    if($user) {
        $user->username = $_POST['username'];
        $user->firstname = $_POST['firstname'];
        $user->lastname = $_POST['lastname'];
        $user->password = $_POST['password'];

        if(empty($_FILES['filename'])) {
            $user->save();
            redirect("users.php");
            $session->message("The user has been updated.");
        } else {
            $user->set_file($_FILES['filename']);
            $user->save_image();
            $user->save();
            $session->message("The user has been updated.");

            //redirect("edit-user.php?id={$user->id}");
            redirect("users.php");
        }
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
                        Users
                        <small>Edit a User</small>
                    </h1>
                    <div class="col-md-6 user_image_box">
                        <a href="#" data-toggle="modal" data-target="#photo-library"><img class="img-responsive" src="<?php echo $user->image_path_placeholder(); ?>"></a>
                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                    <div class="col-md-6">
                       <div class="form-group">
                           <input type="file" name="filename" class="form-control">
                       </div>
                        <div class="form-group">
                          <label for="username">Username</label>
                           <input type="text" name="username" class="form-control" value="<?php echo $user->username; ?>">
                       </div>
                       <div class="form-group">
                          <label for="firstname">First Name</label>
                           <input type="text" name="firstname" class="form-control" value="<?php echo $user->firstname; ?>">
                       </div>
                       <div class="form-group">
                            <label for="lastname">Last Name</label>
                           <input type="text" name="lastname" class="form-control" value="<?php echo $user->lastname; ?>">
                       </div>
                       <div class="form-group">
                            <label for="password">Password</label>
                           <input type="password" name="password" class="form-control" value="<?php echo $user->password; ?>">
                       </div>
                       <div class="form-group">
                            <a id="user-id" class="btn btn-danger" href="delete_user.php?id=<?php echo $user->id; ?>">Delete</a>
                           <input type="submit" name="update" class="btn btn-primary pull-right" value="Update">
                       </div>

                    </div>
                    </form>
                </div>
            </div>
    <!-- /.row -->

</div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>
