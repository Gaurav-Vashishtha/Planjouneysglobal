<?php 
$action = isset($banner) 
            ? base_url("admin/adverties_banner/update/".$banner->id) 
            : base_url("admin/adverties_banner/save");
?>

<h4><?= isset($banner) ? "Edit Banner" : "Add New Banner" ?></h4>
<hr>

<form action="<?= $action ?>" method="post" enctype="multipart/form-data">

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Banner Image 1</label>
            <input type="file" name="banner1" class="form-control">
            <?php if (!empty($banner->banner1)): ?>
                <img src="<?= base_url($banner->banner1) ?>" width="150" class="mt-2">
            <?php endif; ?>
        </div>

        <div class="col-md-6 mb-3">
            <label>Banner Image 2</label>
            <input type="file" name="banner2" class="form-control">
            <?php if (!empty($banner->banner2)): ?>
                <img src="<?= base_url($banner->banner2) ?>" width="150" class="mt-2">
            <?php endif; ?>
        </div>
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
