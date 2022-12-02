<?php  //
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie Info</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="include/functions.js"></script>
    <style>
        .btn-primary, .btn-primary:active, .btn-primary:visited {
            background-color: #8658B2 !important;  border: none;
        }
        .btn-primary:hover { background-color: #9578AB !important; }  
        #search:focus { box-shadow: none !important; }  
    </style>
</head>
<body class="p-5">

    <div class="display-3 mb-3">Movie Database</div>

    <div class="shadow p-3 mb-2 bg-body grounded">
        <form method="POST" action="javascript:void(0);" id="main_form">
            <div class="input-group" style="flex-wrap:nowrap !important;">
                <div class="form-outline">
                    <input id="search" name="search" type="search" class="form-control" placeholder="search" maxlength="50" />
                </div>
                <button id="search-button" type="button" class="btn btn-primary">
                    <i class="bi-search"></i>
                </button>
            </div>
        </form>
    </div>
    <div id="contents" class="shadow p-3 bg-body grounded invisible"></div>

</body>
<script>

</script>
</html>