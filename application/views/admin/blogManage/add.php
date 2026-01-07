<form action="<?= base_url('admin/blog/add') ?>" method="post" enctype="multipart/form-data">

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Category <span class="text-danger">*</span></label>
            <select name="category" class="form-select" >
                <option value="">Select Category</option>
                <option value="luxury" <?= set_select('category','luxury'); ?>>Luxury</option>
                <option value="india" <?= set_select('category','india'); ?>>India</option>
                <option value="international" <?= set_select('category','international'); ?>>International</option>
                <option value="weekend" <?= set_select('category','weekend'); ?>>Weekend</option>
                <option value="news" <?= set_select('category','news'); ?>>News</option>
            </select>
            <?= form_error('category'); ?>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Blog Name <span class="text-danger">*</span></label>
            <input type="text" name="blog_name" class="form-control" value="<?= set_value('blog_name'); ?>" >
            <?= form_error('blog_name'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Blog Type</label>
            <input type="text" name="blog_type" class="form-control" value="<?= set_value('blog_type'); ?>">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="blog_date" class="form-control" value="<?= set_value('blog_date'); ?>">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Blog Heading</label>
        <input type="text" name="blog_heading" class="form-control" value="<?= set_value('blog_heading'); ?>">
    </div>

  <div class="mb-3">
    <label class="form-label">Blog Detail <span class="text-danger">*</span></label>
    <textarea name="blog_detail" id="blog_detail" class="form-control"><?= set_value('blog_detail'); ?></textarea>
    <?= form_error('blog_detail'); ?>
</div>

<div class="mb-3">
    <label class="form-label">Blog Small Overview <span class="text-danger">*</span></label>
    <textarea name="blog_overview" id="blog_overview" class="form-control"><?= set_value('blog_overview'); ?></textarea>
    <?= form_error('blog_overview'); ?>
</div>

    <div class="mb-3">
        <label class="form-label">Keyword</label>
        <input type="text" name="keyword" class="form-control" value="<?= set_value('keyword'); ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Meta Description</label>
        <textarea name="meta_description" class="form-control"><?= set_value('meta_description'); ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Meta Keywords Title</label>
        <input type="text" name="meta_keywords_title" class="form-control" value="<?= set_value('meta_keywords_title'); ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Banner Image (1920x800 px, jpg/png/jpeg/webp)</label>
        <input type="file" name="banner_image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
    </div>

    <div class="mb-3">
        <label class="form-label">Blog Home Image (365x305 px, jpg/png/jpeg/webp)</label>
        <input type="file" name="home_image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
    </div>
    <div class = "row">
        <div class=" col-md-6 form-check mb-3">
            <input type="checkbox" name="status" class="form-check-input" id="status" value="1" <?= set_checkbox('status','1'); ?>>
            <label class="form-check-label" for="status">Active</label>
        </div>
        <div class=" col-md-6 form-check mb-3">
            <input type="checkbox" name="popular" class="form-check-input" id="popular" value="1" <?= set_checkbox('popular','1'); ?>>
            <label class="form-check-label" for="popular">Popular</label>
        </div>
    </div>
    <div class="mb-3">
    <button type="submit" class="btn btn-success">Add Blog</button>
    <a href="<?= base_url('admin/blog'); ?>" class="btn btn-secondary">Cancel</a>
</div>
</form>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#blog_detail'))
        .catch(error => { console.error(error); });

    ClassicEditor
        .create(document.querySelector('#blog_overview'))
        .catch(error => { console.error(error); });
</script>
