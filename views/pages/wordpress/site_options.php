<?php
// header: scripts + navigation bar
OptimizmeUtils::LoadBloc('header');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php OptimizmeUtils::LoadBloc('wordpress/head_push'); ?>
            <form>
                <button type="button" data-id="action" id="load_site_options" class="btn btn-primary">Load site options</button>
                <div id="easycontent-url" value="" />
            </form>
            <hr /><br />
        </div>
    </div>


    <div class="row" >
        <div class="col-md-12">
            <?php
            // BLOG TITLE
            OptimizmeUtils::LoadBloc('form-push/site/title');

            // BLOG SUBTITLE
            OptimizmeUtils::LoadBloc('form-push/site/subtitle');

            // BLOG SEARCH ENGINES
            OptimizmeUtils::LoadBloc('form-push/site/search_engine_status');
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 h200">&nbsp;</div>
    </div>
</div>

<script type="text/javascript">
    (function($){
        $(document).ready(function(){

            // load options
            $('#load_site_options').trigger('click');

            // on chane
            $(document).on('change', '#url_cible', function(){
                $('#load_site_options').trigger('click');
            })
        })
    })(jQuery)
</script>

</body>
</html>