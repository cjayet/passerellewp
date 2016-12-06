<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">

        <div class="col-md-9">
            <h2>Wordpress</h2>
            <a href="<?php OptimizmeUtils::LinkToPage('wordpress/install_config'); ?>">Install plugin</a>

            <h2>Easycontent editor</h2>
            <a href="<?php OptimizmeUtils::LinkToPage('wordpress/easycontent_editor'); ?>">Easycontent editor</a>

            <h2>Redirections</h2>
            <a href="<?php OptimizmeUtils::LinkToPage('wordpress/redirections'); ?>">Redirections</a>

            <h2>Create post / page</h2>
            <a href="<?php OptimizmeUtils::LinkToPage('wordpress/create_post'); ?>">Create post / page</a>

            <h2>Site options</h2>
            <a href="<?php OptimizmeUtils::LinkToPage('wordpress/site_options'); ?>">Site options</a>

        </div>
    </div>
</div>

</body>
</html>
