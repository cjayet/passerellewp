<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');

// get  shopify app data
$shopifyApp = new ShopifyEasycontent();
?>

<div class="container">
    <div class="row">

        <div class="col-md-12">
            <h2>Informations</h2>

            <?php if (isset($_POST['send_install']) && $_POST['send_install'] == 1) : ?>
                <?php $responseInstall = OptimizmeUtils::executeInstall('shopify'); ?>
                <div class="alert alert-warning" role="alert"><?php echo $responseInstall ?></div>
            <?php endif; ?>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque feugiat maximus metus in varius. Suspendisse a lobortis elit. Cras sed pellentesque erat. Aenean nec erat vehicula, pretium ipsum at, sagittis neque. In ut ultrices tellus. Fusce a leo eu turpis ultrices congue. Maecenas in accumsan lacus, ac ultricies lorem. Duis sagittis malesuada hendrerit. </p>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="url_backoffice">URL Backoffice</label>
                <input type="text" class="form-control" id="url_backoffice" name="url_backoffice"
                       placeholder="URL connexion au back-office ( habituellemement http://nomdusite.ext/admin )"
                       value="https://optimiz-me-dev.myshopify.com/admin/" required />
            </div>
        </div>
        <div class="col-md-12">
            <form action="" method="GET" class="form-horizontal" target="_blank" id="form_install_shopify">
                <div class="form-group">
                    <button type="button" id="send" class="btn btn-default">Envoyer</button>
                </div>
                <input type="hidden" name="api_key" value="<?php echo $shopifyApp->appSettings->api_key ?> " />
            </form>
        </div>
    </div>
</div>

</body>
</html>
