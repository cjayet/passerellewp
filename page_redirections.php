<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Redirections</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="css/optimizme.css" />


    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="js/optimizme/utils.js"></script>
    <script src="js/optimizme/passerelle.js"></script>
</head>

<body id="page-redirections">
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <?php include('includes/blocs/head_push.php') ?>
            <table class="table table-striped table-hover" id="table-redirections">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>URL à rediriger</th>
                        <th>URL cible</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>
