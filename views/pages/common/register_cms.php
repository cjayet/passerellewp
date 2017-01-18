<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">

        <div class="col-md-12">
            <h2>Informations</h2>

            <form action="" method="POST" class="form-horizontal">

                <div class="form-group">
                    <label for="login">Login</label>
                    <input type="text" class="form-control" name="login" data-id="login" placeholder="login" value="c.jayet@optimiz.me" />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" data-id="password" value="password" />
                </div>

                <div class="form-group">
                    <label for="url_backoffice">URL site</label>
                    <!-- <input type="text" class="form-control" id="url_cible" name="url_backoffice" placeholder="URL site" value="http://localhost/prestashop/prestashop1.7/" required /> -->
                    <!-- <input type="text" class="form-control" id="url_cible" name="url_backoffice" placeholder="URL site" value="http://localhost/prestashop/prestashop1.7/" required /> -->
                    <input type="text" class="form-control" id="url_cible" name="url_backoffice" placeholder="URL site" value="http://magento212.dev/passerelle/" required />
                </div>

                <input type="hidden" data-id="jwt_disable" name="jwt_disable" value="1" />

                <div class="form-group">
                    <button type="button" id="register-send" class="btn btn-primary push_cms" data-id="action" data-after="afterRegisterCMS" value="register_cms">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
