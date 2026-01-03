<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add Testimonial</h5>
    </div>

    <div class="card-body">

        <form action="<?= base_url('admin/testimonial/save_add'); ?>" method="post" enctype="multipart/form-data">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                
                  
               <div class="col-md-6 mb-3">
                    <label class="form-label">Specialization</label>
                    <input type="text" name="specialization" class="form-control" required>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" class="form-control" rows="4"></textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Image (Main) <small>(Max size: 2 MB)</small></label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Icon Image <small>(Max size: 2 MB)</small></label>
                    <input type="file" name="iconimage" class="form-control" accept="image/*">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Meta Title </label>
                    <input type="text" name="metatitle" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Meta Keyword</label>
                    <textarea name="metakeyword" class="form-control" rows="2"></textarea>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea name="metadescription" class="form-control" rows="4"></textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Active Status</label><br>
                    <input type="checkbox" name="status" value="1" checked> Active
                </div>


            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="<?= base_url('admin/testimonial'); ?>" class="btn btn-secondary">Back</a>

        </form>

    </div>
</div>


<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace('content');
</script>

