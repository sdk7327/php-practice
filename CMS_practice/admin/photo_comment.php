<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php
if(empty($_GET['id'])) {
    redirect("photos.php");
}

$comments = Comment::find_the_comments($_GET['id']);
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
                        Comments
                    </h1>

                    <div class="col-md-12">
                       <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php foreach($comments as $comment) : ?>
                                <tr>
                                    <td><?php echo $comment->id; ?></td>
                                    <td><?php echo $comment->author; ?></td>
                                    <td><?php echo $comment->body; ?></td>
                                    <td><a href="delete_comment.php?id=<?php echo $comment->id; ?>">Delete</a></td>
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
