
    <h3 class="mb-3">Edit Banner</h3>

    <form action="<?= base_url('admin/banner/save_edit/'.$banner->id); ?>" method="post" enctype="multipart/form-data">

        <input type="hidden" name="section" value="<?= isset($section) ? $section : 'home'; ?>">

        <div class="mb-3">
            <label>Banner Name</label>
            <input type="text" name="banner_name" value="<?= $banner->banner_name ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Link</label>
            <input type="text" name="link" value="<?= $banner->link ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Banner Image</label>
            <input type="file" name="banners_image" class="form-control">
            <?php if ($banner->banners_image): ?>
                <img src="<?= base_url('uploads/banners/'.$banner->banners_image); ?>" width="120" class="mt-2">
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label>Banner Video</label>
            <input type="file" name="banner_video" class="form-control">
            <?php if ($banner->banner_video): ?>
                <video width="200" controls class="mt-2">
                    <source src="<?= base_url('uploads/banner_video/'.$banner->banner_video); ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label>Meta Title</label>
            <input type="text" name="meta_title" value="<?= $banner->meta_title ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label>Meta Keywords</label>
            <input type="text" name="meta_keywords" value="<?= $banner->meta_keywords ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label>Meta Description</label>
            <textarea name="meta_discription" class="form-control"><?= $banner->meta_discription ?></textarea>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <input type="checkbox" name="status" <?= $banner->status ? 'checked' : '' ?>>
        </div>

        <button class="btn btn-success">Update Banner</button>
    </form>

