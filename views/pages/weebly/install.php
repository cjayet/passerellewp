<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');

// get  shopify app data
$xeeblyApp = new WeeblyEasycontent();
?>

<div class="container">
    <div class="row">

        <div class="col-md-12">
            <h2>Informations</h2>

            <?php if (isset($_POST['send_install']) && $_POST['send_install'] == 1) : ?>
                <?php $responseInstall = OptimizmeUtils::executeInstall('weebly'); ?>
                <div class="alert alert-warning" role="alert"><?php echo $responseInstall ?></div>
            <?php endif; ?>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque feugiat maximus metus in varius. Suspendisse a lobortis elit. Cras sed pellentesque erat. Aenean nec erat vehicula, pretium ipsum at, sagittis neque. In ut ultrices tellus. Fusce a leo eu turpis ultrices congue. Maecenas in accumsan lacus, ac ultricies lorem. Duis sagittis malesuada hendrerit. </p>
        </div>


        <div class="col-md-12">
            <form action="" method="POST" class="form-horizontal">
                <div class="form-group">
                    <label for="login">Login (identifiant Weebly)</label>
                    <input type="text" class="form-control" id="login" name="login" placeholder="Login" value="c.jayet@optimiz.me" required/>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="clems38WE!" required/>
                </div>

                <div class="form-group">
                    <label for="url_backoffice">URL Backoffice</label>
                    <input type="text" class="form-control" id="url_backoffice" name="url_backoffice"
                           placeholder="URL connexion au back-office ( habituellemement https://www.weebly.com/index.php#login )"
                           value="https://www.weebly.com/index.php#login" required />
                </div>

                <div class="form-group">
                    <button type="submit" id="send" class="btn btn-primary">Envoyer</button>
                </div>

                <input type="hidden" name="send_install" value="1"/>
            </form>
        </div>
    </div>
</div>

</body>
</html>
