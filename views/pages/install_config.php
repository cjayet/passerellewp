<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">

        <div class="col-md-12">
            <h2>Informations</h2>

            <?php if (isset($_POST['send_install']) && $_POST['send_install'] == 1) : ?>
                <?php $responseInstall = OptimizmeUtils::executeInstall(); ?>
                <div class="alert alert-warning" role="alert"><?php echo $responseInstall ?></div>
            <?php endif; ?>

            <form action="" method="POST" class="form-horizontal">
                <div class="form-group">
                    <label for="login">Login (identifiant Wordpress d'administration)</label>
                    <input type="text" class="form-control" id="login" name="login" placeholder="Login" value="" required/>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" class="form-control" id="password" name="password" placeholder="Password" value="" required/>
                </div>

                <div class="form-group">
                    <label for="url_backoffice">URL Backoffice</label>
                    <input type="text" class="form-control" id="url_backoffice" name="url_backoffice"
                           placeholder="URL connexion au back-office ( habituellemement http://nomdusite.ext/wp-admin )"
                           value="http://localhost/wordpress/wp-admin" required />
                </div>

                <div class="form-group">
                    <button type="submit" id="send" class="btn btn-default">Envoyer</button>
                </div>

                <input type="hidden" name="send_install" value="1"/>
            </form>


        </div>
    </div>
</div>

</body>
</html>
