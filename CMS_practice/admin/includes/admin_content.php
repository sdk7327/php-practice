<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Blank Page
                <small>Subheading</small>
            </h1>

            <?php
                //testing database connection

                $photo = new Photo();

                $photo->id = 4;
                $photo->title = "the babe";
                $photo->description = "faye splooted and looking out the window";
                $photo->filename = "faye_butt.png";
                $photo->type = "image";
                $photo->size = 382;

                $photo->create();

            ?>

            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                </li>
                <li class="active">
                    <i class="fa fa-file"></i> Blank Page
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->

</div>
