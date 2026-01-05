<?php 
$action = isset($banner) 
            ? base_url("admin/adverties_banner/update/".$banner->id) 
            : base_url("admin/adverties_banner/save");
?>

<h4><?= isset($banner) ? "Edit Banner" : "Add New Banner" ?></h4>
<hr>

<form action="<?= $action ?>" method="post" enctype="multipart/form-data">
 
   <div class="mb-3">
            <label>Link</label>
            <input type="text" name="link" class="form-control" 
                 value="<?= $banner->link ?? '' ?>">
        </div>

    <div class="row">
        <div class="mb-3">
            <label>Banner Image 1<small>(Max size: 2 MB)</small></label>
            <input type="file" name="banner1" class="form-control">
            <?php if (!empty($banner->banner1)): ?>
                <img src="<?= base_url($banner->banner1) ?>" width="150" class="mt-2">
            <?php endif; ?>
        </div>



    <div class="row">

        <div class="col-md-3 mb-3 form-check">
            <input type="checkbox" name="status" id="status" value="1" 
                <?= isset($banner) && $banner->status ? "checked" : "" ?>>
            <label class="form-check-label" for="status">Active</label>
        </div>


    </div>

    <button class="btn btn-success"><?= isset($banner) ? "Update" : "Save" ?></button>

</form>
