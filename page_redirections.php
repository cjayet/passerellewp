<?php
// header: scripts + navigation bar
include('includes/blocs/header.php');
?>

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
