<form action="<?= base_url('admin/testimonial/save_edit/'.$testimonial->id); ?>" 
      method="post" enctype="multipart/form-data">

    <div class="row">

        
        <div class="col-md-6 mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" 
                   value="<?= $testimonial->name; ?>">
        </div>

     
        <div class="col-md-6 mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" 
                   value="<?= $testimonial->title; ?>">
        </div>

       
        <div class="col-md-6 mb-3">
            <label class="form-label">Specialization</label>
            <input type="text" name="specialization" class="form-control" 
                   value="<?= $testimonial->specialization; ?>">
        </div>

       
        <div class="col-12 mb-3">
            <label class="form-label">Content</label>
            <textarea name="content" class="form-control" rows="4"><?= $testimonial->content; ?></textarea>
        </div>

     
        <div class="col-md-6 mb-3">
            <label class="form-label">Image (Main) <small>(Max size: 2 MB)</small></label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <?php if ($testimonial->image): ?>
                <img src="<?= base_url('uploads/testimonial/'.$testimonial->image); ?>"
                     class="img-thumbnail mt-2" width="120" height="80">
            <?php endif; ?>
        </div>

       
        <div class="col-md-6 mb-3">
            <label class="form-label">Icon Image <small>(Max size: 2 MB)</small></label>
            <input type="file" name="iconimage" class="form-control" accept="image/*">
            <?php if ($testimonial->iconimage): ?>
                <img src="<?= base_url('uploads/testimonial/'.$testimonial->iconimage); ?>"
                     class="img-thumbnail mt-2" width="80" height="80">
            <?php endif; ?>
        </div>

       
        <div class="col-md-6 mb-3">
            <label class="form-label">Meta Title</label>
            <input type="text" name="metatitle" class="form-control" 
                   value="<?= $testimonial->meta_title; ?>">
        </div>

        
        <div class="col-md-6 mb-3">
            <label class="form-label">Meta Keyword</label>
            <textarea name="metakeyword" class="form-control" rows="2"><?= $testimonial->meta_keyword; ?></textarea>
        </div>

     
        <div class="col-12 mb-3">
            <label class="form-label">Meta Description</label>
            <textarea name="metadescription" class="form-control" rows="4"><?= $testimonial->meta_description; ?></textarea>
        </div>


        <div class="col-md-6 mb-3">
            <label class="form-label">Active Status</label><br>
            <input type="checkbox" name="status" value="1" <?= $testimonial->status == 1 ? 'checked' : ''; ?>> Active
        </div>

    


    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="<?= base_url('admin/testimonial'); ?>" class="btn btn-secondary">Back</a>

</form>

<!-- CKEditor Script -->
<script src="https://cdn.ckeditor.com/4.25.1/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace('content');
</script>
