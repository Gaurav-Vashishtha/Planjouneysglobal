
    <h3 class="mb-3">Add Banner</h3>

    <form action="<?= base_url('admin/banner/save_add'); ?>" method="post" enctype="multipart/form-data">

        <input type="hidden" name="section" value="<?= isset($section) ? $section : 'home'; ?>">

        <div class="mb-3">
            <label>Banner Name</label>
            <input type="text" name="banner_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Link</label>
            <input type="text" name="link" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Banner Image</label>
            <input type="file" name="banners_image" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Banner Video</label>
            <input type="file" name="banner_video" class="form-control">
        </div>

        <div class="mb-3">
            <label>Meta Title</label>
            <input type="text" name="meta_title" class="form-control">
        </div>

        <div class="mb-3">
            <label>Meta Keywords</label>
            <input type="text" name="meta_keywords" class="form-control">
        </div>

        <div class="mb-3">
            <label>Meta Description</label>
            <textarea name="meta_discription" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <input type="checkbox" name="status" checked>
        </div>

        <button class="btn btn-primary">Add Banner</button>
    </form>

