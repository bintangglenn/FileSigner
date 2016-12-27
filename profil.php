<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload | Tutorial 7</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="libs/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container" style="margin-top: 3vh;">
        <div class="col-md-5">
            <form class="form-horizontal" action="app.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <h2>
                        Nama : Jono
                    </h2>
                    <h2>
                        Pekerjaan : Kuli Bangunan
                    </h2>
                </div>


                <div class="form-group">
                    <label class="control-label col-sm-2" for="document">P12:</label>
                    <div class="col-sm-10">
                      <input type="file" name="p12" id="file12" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Upload" name="submit" class="btn btn-default">
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <a href="index.php" value="uploadFile"> Upload </a>
                    </div>
                </div>
            </form>
        </div>

        <?php
            if(isset($_SESSION['valid'])) {
                echo $_SESSION['valid'];
                unset($_SESSION['valid']);
            }
            if(!isset($_SESSION['dataUpload'])) {
                $_SESSION['dataUpload'] = array();
            }
            if(!isset($_SESSION['idx'])) {
                 $_SESSION['idx'] = 0;
            }           
        ?>
    </div>

    <script src="libs/jquery/dist/jquery.min.js"></script>
    <script src="libs/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>