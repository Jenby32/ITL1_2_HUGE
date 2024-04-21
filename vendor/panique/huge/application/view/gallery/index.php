<div class="container">
<?php $this->renderFeedbackMessages(); ?>
    <div class="row">
        <form method="post" enctype="multipart/form-data" action="<?php echo Config::get('URL');?>gallery/saveFile">
            <h3>Upload File</h3>
            <input type="file" name="myfile"> <br>
            <input type="submit" name="save" autocomplete="off">upload</input>
        </form>
    </div>
    </br>
    <div>

        <?php foreach($this->images as $image) { ?>
            <div class="card" style="width: 18rem;">
                <img class="card-img-top" src="<?php echo Config::get("URL"); ?>gallery/showFiles/<?=$image->path_to_picture?>" alt="Card image cap">
            </div>
        <?php } ?>
    </div>
</div>