<?php 
$action = isset($poster) 
            ? base_url("admin/poster/update/".$poster->id) 
            : base_url("admin/poster/save");
?>

<h4><?= isset($poster) ? "Edit poster" : "Add New poster" ?></h4>
<hr>

<form action="<?= $action ?>" method="post" enctype="multipart/form-data">
 
   <div class="mb-3">
            <label>Link</label>
            <input type="text" name="link" class="form-control" 
                 value="<?= $poster->link ?? '' ?>">
        </div>

    <div class="row">
        <div class="mb-3">
            <label>Poster Image<small>(Max size: 2 MB)</small></label>
            <input type="file" name="poster" class="form-control">
            <?php if (!empty($poster->poster)): ?>
                <img src="<?= base_url($poster->poster) ?>" width="150" class="mt-2">
            <?php endif; ?>
        </div>



    <div class="row">

        <div class="col-md-3 mb-3 form-check">
            <input type="checkbox" name="status" id="status" value="1" 
                <?= isset($poster) && $poster->status ? "checked" : "" ?>>
            <label class="form-check-label" for="status">Active</label>
        </div>


    </div>

    <button class="btn btn-success"><?= isset($poster) ? "Update" : "Save" ?></button>

</form>
