<div class="container">
    <div class="row">
        <form method="post" enctype="multipart/form-data" action="<?php echo Config::get('URL');?>gallery/saveFile">
            <h3>Upload File</h3>
            <input type="file" name="myfile"> <br>
            <input type="submit" name="save" autocomplete="off">upload</input>
        </form>
    </div>
</div>