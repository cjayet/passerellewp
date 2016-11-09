<h2 id="bloc_content">PUSH content</h2>
<form action="" method="POST">

    <div class="form-group">
        <label for="new_title">Nouveau contenu</label>
        <textarea class="form-control" id="new_content" placeholder="Contenu" value=""></textarea>
    </div>

    <input type="hidden" name="action" value="set_title" />
    <button type="button" id="push_content" class="btn btn-default">Envoyer</button>
</form>

<div class="form-group">
    <div id="result_update_content" class=""></div>
</div>
<hr />