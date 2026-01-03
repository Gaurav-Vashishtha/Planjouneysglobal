<h1><?= $title ?></h1>


<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php endif; ?>

<form method="post" action="<?= isset($record) ? base_url('admin/recent_experience/save/'.$record->id) : base_url('admin/recent_experience/save') ?>" enctype="multipart/form-data">

    <div id="image-sections">
        <?php 
        if(isset($record) && !empty($record->images)):
            $images = json_decode($record->images, true);
            foreach($images as $img): ?>
                <div class="image-section mb-3 border p-3 position-relative">
                    <input type="file" name="images[]" class="form-control mb-2">
                    <input type="hidden" name="existing_images[]" value="<?= $img ?>">
                    <img src="<?= base_url('uploads/recent_experience/'.$img) ?>" width="100">
                    <button type="button" class="btn btn-danger remove-image-section mt-2" style="position:absolute;top:5px;right:5px;">X</button>
                </div>
        <?php endforeach; 
        else: ?>
            <div class="image-section mb-3 border p-3 position-relative">
                <input type="file" name="images[]" class="form-control mb-2">
                <button type="button" class="btn btn-danger remove-image-section mt-2" style="position:absolute;top:5px;right:5px;">X</button>
            </div>
        <?php endif; ?>
    </div>

    <button type="button" id="add-more-image" class="btn btn-primary mb-3">Add More Images</button>
    <br>
    <button type="submit" class="btn btn-success">Save</button>
</form>

<script>
$(document).ready(function(){


    $('#add-more-image').click(function(){
        var html = `<div class="image-section mb-3 border p-3 position-relative">
                        <input type="file" name="images[]" class="form-control mb-2">
                        <button type="button" class="btn btn-danger remove-image-section mt-2" style="position:absolute;top:5px;right:5px;">X</button>
                    </div>`;
        $('#image-sections').append(html);
    });


    $(document).on('click', '.remove-image-section', function(){
        $(this).closest('.image-section').remove();
    });
});
</script>
