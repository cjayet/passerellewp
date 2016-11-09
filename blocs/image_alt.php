<h2 id="bloc_image">PUSH image </h2>
<form action="" method="POST">


    <div class="form-group">
        <label for="new_title">URL image</label>
        <input type="text" class="form-control" id="url_image" placeholder="" value="http://localhost/wordpress/wp-content/uploads/2016/11/corporate-2-westport-house-img-1-300x200.jpg" />
    </div>

    <div class="form-group">
        <label for="new_title">Update image</label>
        <input type="text" class="form-control" id="update_image" placeholder="Image alt" value="" />
    </div>

    <input type="hidden" name="action" value="set_title" />
    <button type="button" id="push_img_alt" class="btn btn-default">Envoyer</button>
</form>

<div class="form-group">
    <div id="result_update_img" class=""></div>
</div>
<br />
<hr />
<br />