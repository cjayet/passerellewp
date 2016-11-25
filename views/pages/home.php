<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">

        <div class="col-md-9">
            <h2>Install</h2>
            <a href="<?php OptimizmeUtils::LinkToPage('install_config'); ?>">Install plugin</a>

            <h2>Push content</h2>
            <a href="<?php OptimizmeUtils::LinkToPage('push_content'); ?>">Push content</a>

            <h2>Easycontent editor</h2>
            <a href="<?php OptimizmeUtils::LinkToPage('easycontent_editor'); ?>">Easycontent editor</a>

            <h2>Redirections</h2>
            <a href="<?php OptimizmeUtils::LinkToPage('redirections'); ?>">Redirections</a>

            <h2>Create post / page</h2>
            <a href="<?php OptimizmeUtils::LinkToPage('create_post'); ?>">Create post / page</a>
        </div>
    </div>
</div>

</body>
</html>
