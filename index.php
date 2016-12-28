<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>File Signer</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="libs/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container" style="margin-top: 3vh;">
        <div class="col-md-5">
            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="document">File:</label>
                    <div class="col-sm-10">
                      <input type="file" name="document" id="document" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="button" value="Upload" name="submit" data-toggle="modal" data-target="#myModal" class="btn btn-default">
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="myModal" role="dialog">
            <div id="form-sidang" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Masukkan Password</h4>
                    </div>
                    <div class="modal-body">
                        <form action="app.php" method="post">
                            <div class="form-group form-inline">
                                <label for="mahasiswa">Password P12</label>
                                <input type="text" class="form-control" id="passwordP12" name="passwordP12" placeholder="Password">
                            </div>    
                            <input type="hidden" id="insert-command" name="command" value="insertPenguji" >
                            <button type="submit" id="tambahPenguji" class="btn btn-default">Submit</button>                          
                        </form>
                    </div>
                </div>
            </div>
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
        <div class="result">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama File</th>
                        <th>Ukuran File</th>
                        <th>Waktu Upload</th>
                        <th>Hapus</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($_SESSION['dataUpload'])) {
                            for($i = 0; $i < count($_SESSION['dataUpload']); $i++) {
                                echo $_SESSION['dataUpload'][$i];
                            }  
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="libs/jquery/dist/jquery.min.js"></script>
    <script src="libs/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>