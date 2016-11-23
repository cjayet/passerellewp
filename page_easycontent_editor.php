<?php
// header: scripts + navigation bar
include('includes/blocs/header.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php include('includes/blocs/head_push.php') ?>

            <form action="" method="POST">
                <button id="btn-load-grideditor" type="button" data-id="action" value="load_post_content" class="btn btn-primary load_grid_editor" data-target="#easycontent-grid">Load content</button>
            </form>
            <div class="form-group">
                <div class=""></div>
            </div>
            <br /><hr /><br />
        </div>
    </div>

    <div id="container-easycontent" style="display: none">
        <div class="row" >

            <div class="col-md-12">

                <div class="form-group">
                    <form>
                        <label for="easycontent-title">Title</label>
                        <input type="text" name="easycontent-title" id="easycontent-title" data-id="new_title" class="form-control" />
                        <button type="button" data-id="action" value="set_title" class="btn btn-primary push_wp">Envoyer</button>
                    </form>
                    <div class="form-group"><div class=""></div></div>
                </div>

                <div class="form-group">
                    <form>
                        <label for="easycontent-permalink">Permalien</label>
                        <input type="text" name="easycontent-permalink" id="easycontent-permalink" data-id="new_permalink" class="form-control" />
                        <button type="button" data-id="action" value="set_permalink" class="btn btn-primary push_wp">Envoyer</button>
                    </form>
                    <div class="form-group"><div class=""></div></div>
                </div>

                <div class="form-group">
                    <form>
                        <label for="easycontent-canonical-url">URL canonique</label>
                        <input type="text" name="easycontent-canonical-url" id="easycontent-canonical-url" data-id="canonical_url" class="form-control" />
                        <button type="button" data-id="action" value="set_canonical_url" class="btn btn-primary push_wp">Envoyer</button>
                    </form>
                    <div class="form-group"><div class=""></div></div>
                </div>

                <div class="form-group">
                    <form>
                        <label for="easycontent-permalink">Meta description</label>
                        <input type="text" name="easycontent-meta-description" id="easycontent-meta-description" data-id="meta_description" class="form-control" />
                        <button type="button" data-id="action" value="set_meta_description" class="btn btn-primary push_wp">Envoyer</button>
                    </form>
                    <div class="form-group"><div class=""></div></div>
                </div>

                <div class="form-group">
                    <form>
                        <label for="noindex">Meta robots</label>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" data-id="noindex" id="easycontent-noindex" name="noindex" value="1"> noindex
                            </label>
                            <label>
                                <input type="checkbox" data-id="nofollow" id="easycontent-nofollow" name="nofollow" value="1"> nofollow
                            </label>
                        </div>
                        <button type="button" data-id="action" value="set_meta_robots" class="btn btn-primary push_wp">Envoyer</button>
                    </form>
                    <div class="form-group"><div class=""></div></div>
                </div>

                <div class="form-group">
                    <form>
                        <label for="noindex">Contenu publié</label>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" data-id="is_publish" id="easycontent-publish" name="is_publish" value="1"> Publier la page
                            </label>
                        </div>
                        <button type="button" data-id="action" value="set_post_status" class="btn btn-primary push_wp">Envoyer</button>
                    </form>
                    <div class="form-group"><div class=""></div></div>
                </div>

                <br /><hr /><br />
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <h2>Optimisation des images présentes dans le contenu</h2>
                <div id="image-list" class="list-unstyled"></div>
                <br /><hr /><br />
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h2>Optimisation des liens présents dans le contenu</h2>
                <div id="href-list"></div>
                <br /><hr /><br />
            </div>
        </div>





        <div class="row">
            <div class="col-md-12">
                <h2>Editor</h2>
            </div>
            <div class="col-md-2">
                <aside id="page_builder">
                    <div id="list_block_page_builder" class="page-header">BLOCKS</div>

                    <!--
                    Buttons<br />
                    <button type="button" data-id="action" value="add_h1" class="btn btn-default inject_easycontent_h1 ui-sortable">Inject h1</button>
                    <button type="button" data-id="action" value="add_h2" class="btn btn-default inject_easycontent_h2 ui-sortable">Inject h2</button>
                    <button type="button" data-id="action" value="add_content" class="btn btn-default inject_easycontent_content ui-sortable">Inject content</button>
                    -->

                    <br />Draggable<br />
                    <div data-action="h1" class="btn btn-default ui-draggable ui-draggable-handle ui-sortable">DRAG H1</div>
                    <div data-action="h2" class="btn btn-default ui-draggable ui-draggable-handle ui-sortable">DRAG H2</div>
                    <div data-action="h3" class="btn btn-default ui-draggable ui-draggable-handle ui-sortable">DRAG H3</div>
                    <div data-action="image" class="btn btn-default ui-draggable ui-draggable-handle ui-sortable">DRAG Image</div>
                    <div data-action="content" class="btn btn-default ui-draggable ui-draggable-handle ui-sortable">DRAG Content</div>
                </aside>
            </div>

            <div class="col-md-10">
                <form action="" method="POST">
                    <div class="page-header">CONTENT</div><br />

                    <div class="btn btn-default preview_content">Preview in Wordpress</div>

                    <div id="content-grid" class="form-group">
                        <div id="easycontent-grid"></div>
                    </div>

                    <button type="button" data-id="action" value="set_content" class="btn btn-primary push_wp">Envoyer</button>
                </form>

                <div class="form-group">
                    <div class=""></div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12 h200">&nbsp;</div>
        </div>
    </div>
</div> <!-- /.container -->

<script type="text/javascript">
    (function($){
        $(document).ready(function(){
            // load au chargement de la page
            $('.load_grid_editor').trigger('click');
        })
    })(jQuery)
</script>


</body>
</html>