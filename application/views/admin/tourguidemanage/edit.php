<form action="<?= base_url('admin/tourguide/save_edit/'.$tourguide->id); ?>" 
      method="post" enctype="multipart/form-data">

    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?= $tourguide->name; ?>" required>
        </div>


        <div class="col-md-6 mb-3">
            <label class="form-label">Specialization</label>
            <input type="text" name="specialization" class="form-control" value="<?= $tourguide->specialization; ?>" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Image <small>(Max size: 2 MB)</small></label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <?php if ($tourguide->image): ?>
                <img src="<?= base_url('uploads/tourguide/'.$tourguide->image); ?>" class="img-thumbnail mt-2" width="120" height="80">
            <?php endif; ?>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Meta Title</label>
            <input type="text" name="metatitle" class="form-control" 
                   value="<?= $tourguide->meta_title; ?>">
        </div>

        
        <div class="col-md-6 mb-3">
            <label class="form-label">Meta Keyword</label>
            <textarea name="metakeyword" class="form-control" rows="2"><?= $tourguide->meta_keyword; ?></textarea>
        </div>

     
        <div class="col-12 mb-3">
            <label class="form-label">Meta Description</label>
            <textarea name="metadescription" class="form-control" rows="4"><?= $tourguide->meta_description; ?></textarea>
        </div>


        <div class="col-md-6 mb-3">
            <label class="form-label">Active Status</label><br>
            <input type="checkbox" name="status" value="1" <?= $tourguide->status == 1 ? 'checked' : ''; ?>> Active
        </div>


    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= base_url('admin/tourguide'); ?>" class="btn btn-secondary">Back</a>

</form>
