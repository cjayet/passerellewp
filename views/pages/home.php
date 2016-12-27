<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">

        <div class="col-md-3">
            <h2>Wordpress</h2>
            <ul>
                <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/easycontent_editor'); ?>">Easycontent editor</a></li>
                <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/install_config'); ?>">Install plugin</a></li>
                <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/redirections'); ?>">Redirections</a></li>
                <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/create_post'); ?>">Create post / page</a></li>
                <li><a href="<?php OptimizmeUtils::LinkToPage('wordpress/site_options'); ?>">Site options</a></li>
            </ul>
        </div>

        <div class="col-md-3">
            <h2>Prestashop</h2>
            <ul>
                <li><a href="<?php OptimizmeUtils::LinkToPage('prestashop/easycontent_editor'); ?>">Easycontent editor</a></li>
            </ul>
        </div>

        <div class="col-md-3">
            <h2>Shopify</h2>
            <ul>
                <li><a href="<?php OptimizmeUtils::LinkToPage('shopify/edit_product'); ?>">Edit product</a></li>
                <li><a href="<?php OptimizmeUtils::LinkToPage('shopify/redirections'); ?>">Redirections</a></li>
                <li><a href="<?php OptimizmeUtils::LinkToPage('shopify/install_config'); ?>">Installation</a></li>
            </ul>
        </div>

        <div class="col-md-3">
            <h2>Magento</h2>
            <ul>
                <li><a href="<?php OptimizmeUtils::LinkToPage('magento/edit_product'); ?>">Edit product</a></li>
                <li><a href="<?php OptimizmeUtils::LinkToPage('magento/redirections'); ?>">Redirections</a></li>
            </ul>
        </div>
    </div>
</div>

</body>
</html>
