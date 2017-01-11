<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Signer</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="libs/bootstrap/dist/css/bootstrap.min.css">
    <script src="libs/jquery/dist/jquery.min.js"></script>
    <script src="libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <style>
        table {
            table-layout: fixed;
        }
        th {
            border: 1px solid #ddd !important;
            text-align: center;
        }
        td {
            border: 1px solid #ddd !important;           
        }
    </style>
</head>
<body>
    <div class="container" style="margin-top: 3vh;">
        <div class="col-md-5">
            <form class="form-horizontal" action="app.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="file"><p style="float:left;">File</p>:</label>
                    <div class="col-sm-8">
                      <input type="file" name="file" id="file" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="cert"><p style="float:left;">P12 Certificate</p>:</label>
                    <div class="col-sm-8">
                      <input type="file" name="cert" id="cert" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="pass"><p style="float:left;">Password</p>:</label>
                    <div class="col-sm-8">
                      <input type="password" name="pass" id="pass" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-3">
                        <input type="submit" value="sign" name="submit" class="btn btn-default">
                    </div>
                    <div class="col-sm-offset-2 col-sm-3">
                        <input type="submit" value="verify" name="submit" class="btn btn-default" style="float:right;">
                    </div>
                </div>
            </form>
        </div>

        <?php
            if(isset($_SESSION['valid'])) {
                echo $_SESSION['valid'];
                unset($_SESSION['valid']);
            }
            if(!isset($_SESSION['idx'])) {
                 $_SESSION['idx'] = 0;
            }
            if(!isset($_SESSION['dataUpload'])) {
                $_SESSION['dataUpload'] = array();
                foreach (glob('./signature/*.sha256') as $fileName) {
                    $fileName = substr($fileName,12);
                    $tmp = "key" . $_SESSION['idx'];
                    $_SESSION['dataUpload'][$tmp] = "<tr><td>" . $fileName . "</td><td style='text-align: center;'><form action=\"app.php\" method=\"post\" enctype=\"multipart/form-data\"><input type=\"hidden\" value=\"" . $fileName . "\" name=\"hapus\"/><input type=\"hidden\" value=\"" . $_SESSION['idx'] . "\" name=\"idxHapus\"/><input type=\"Submit\" value=\"Delete\" name=\"submit\"/></form></td>";
                    $_SESSION['idx'] += 1;
                }
            }
        ?>
        <div class="result">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th width="30%">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($_SESSION['dataUpload'])) {
                            foreach($_SESSION['dataUpload'] as $fileInfo) {
                                echo $fileInfo;
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>