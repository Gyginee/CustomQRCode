<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.6.0/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <link href="public/style.css" rel="stylesheet" >

    <title>QR BULK</title>
</head>

<body>
<div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="container my-3">
                    <form id="configForm">
                        <div class="container">
                            <div class="row row-cols-2">

                                <div class="col">

                                    <label for="content">Content:</label><br>
                                    <input type="content" id="content" name="content" class="form-control" value="sample text"><br>

                                    <label for="margin">Margin (0-10):</label><br>
                                    <input class="form-control" type="number" id="margin" name="margin" min="0" max="10" step="1" value="0"><br>

                                    <label for="size">Size (0-10000):</label><br>
                                    <input class="form-control" type="number" id="size" name="size" min="0" max="10000" step="1" value="150"><br>

                                    <label for="format">Select a format:</label><br>
                                    <select id="format" name="format" class="form-select">
                                        <option value="png" selected>png</option>
                                        <option value="svg">svg</option>
                                        <option value="base64">base64</option>
                                    </select><br>

                                    <label for="mainColor">Main Color:</label><br>
                                    <input class="form-control form-control-color" type="color" id="mainColor" name="mainColor" value="#000000"><br>

                                    <label for="foreColor">Foreground Color:</label><br>
                                    <input class="form-control form-control-color" type="color" id="foreColor" name="foreColor" value="#ffffff"><br>
                                </div>

                                <div class="col">
                                    <label for="errorCorrection">Error correction:</label><br>
                                    <select id="errorCorrection" name="errorCorrection" class="form-select">
                                        <option value="L">L</option>
                                        <option value="M" selected>M</option>
                                        <option value="Q">Q</option>
                                        <option value="H">H</option>
                                    </select><br>

                                    <label for="logo">Logo URL:</label><br>
                                    <input type="url" id="logo" name="logo" class="form-control"><br>

                                    <label for="ratio">Logo Ratio (0-1.0):</label><br>
                                    <input type="number" id="ratio" name="ratio" min="0" max="1" step="0.1" value="0.3" class="form-control"><br>

                                    <label for="logoWidth">Logo Width (0-1000):</label><br>
                                    <input type="number" id="logoWidth" name="logoWidth" min="0" max="1000" step="1" value="50" class="form-control"><br>

                                    <label for="logoHeight">Logo Height (0-1000):</label><br>
                                    <input type="number" id="logoHeight" name="logoHeight" min="0" max="1000" step="1" value="50" class="form-control"><br>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form id="export" action="" method="post" enctype="multipart/form-data">
                        <div id="fileHelpId" class="form-text">Export QR</div>
                        <button type="submit" class="btn btn-primary btn-lg" name="submit">EXPORT ZIP</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-auto">
                <img id="qrimage" src="" alt="QRCode Sample">
            </div>
        </div>
    </div>

            <!-- SCRIPT JAVASCRIPT + PHP ==================================================================================== -->

            <script src="public/script.js"></script>
        </div>
    </div>
</body>

</html>