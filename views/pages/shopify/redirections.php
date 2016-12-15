<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('shopify/head_push'); ?>
            <form>
                <button type="button" data-id="action" id="shopify_load_redirections" class="btn btn-primary">Load redirections</button>
            </form>
            <hr /><br />
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">

            <h3>Redirections : </h3>

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
                    <?php OptimizmeUtils::LoadBloc('js-tmpl/shopify-redirection-ligne', 'html') ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 h200">&nbsp;</div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){

        shopifyLoadAllRedirections();

        $(document).on('change', '#url_cible', function(){
            shopifyLoadAllRedirections();
        })
    })
</script>

</body>
</html>