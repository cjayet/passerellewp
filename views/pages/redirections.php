<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<body id="page-redirections">
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('head_push') ?>
            <table class="table table-striped table-hover" id="table-redirections">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>URL à rediriger</th>
                        <th>URL cible</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbody-redirections">
                    <?php OptimizmeUtils::LoadBloc('js-tmpl/redirection-ligne', 'html') ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>
