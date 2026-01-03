<h3><?= $title ?></h3>
<?php echo validation_errors(); ?>
<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Video Name</label>
        <input type="text" name="video_name" class="form-control" value="<?= isset($video) ? $video->video_name : set_value('video_name') ?>" >
    </div>

    <div class="mb-3">
        <label>Video <small>(Max size: 5 MB)</small></label>
        <input type="file" name="video" class="form-control">
        <?php if(isset($video) && $video->video): ?>
            <small>Current: <?= $video->video ?></small>
        <?php endif; ?>
    </div>


     <div class="mb-3">
        <label>Link</label>
        <input type="text" name="link" class="form-control" value="<?= isset($video) ? $video->link : set_value('link') ?>" >
    </div>

    <div class="mb-3">
        <label>Meta Title</label>
        <input type="text" name="meta_title" class="form-control" value="<?= isset($video) ? $video->meta_title : set_value('meta_title') ?>">
    </div>

    <div class="mb-3">
        <label>Meta Keywords</label>
        <input type="text" name="meta_keywords" class="form-control" value="<?= isset($video) ? $video->meta_keywords : set_value('meta_keywords') ?>">
    </div>

    <div class="mb-3">
        <label>Meta Description</label>
        <textarea name="meta_description" class="form-control"><?= isset($video) ? $video->meta_description : set_value('meta_description') ?></textarea>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control" >
            <option value="">Select status</option>
            <option value="1" <?= isset($video) && $video->status == 1 ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= isset($video) && $video->status == 0 ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Save</button>
</form>
