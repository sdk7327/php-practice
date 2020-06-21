<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php
$users = User::find_all();
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
                    </h1>

                    <a href="add_user.php" class="btn btn-primary">Add User</a>

                    <div class="col-md-12">
                       <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>User Icon</th>
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php foreach($users as $user) : ?>
                                <tr>
                                    <td><?php echo $user->id; ?></td>
                                    <td><img class="img-thumbnail admin-photo-thumbnail img-responsive" src="<?php echo $user->image_path_placeholder(); ?>" alt="">
                                    <div class="actions_link">
                                        <a href="delete_user.php?id=<?php echo $user->id; ?>">Delete</a>
                                        <a href="edit-user.php?id=<?php echo $user->id; ?>">Edit</a>
                                        <a href="#">View</a>
                                    </div>
                                    </td>
                                    <td><?php echo $user->username; ?></td>
                                    <td><?php echo $user->firstname; ?></td>
                                    <td><?php echo $user->lastname; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table> <!-- End of table -->
                    </div>
                </div>
            </div>
    <!-- /.row -->

</div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>
