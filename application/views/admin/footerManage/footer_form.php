
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<form method="post" action="<?= base_url('admin/footer/save') ?>" enctype="multipart/form-data">

    <div class="form-group">
        <label>Logo</label>
        <input type="file" name="logo" class="form-control">
        <?php if(!empty($footer->logo)): ?>
            <img src="<?= base_url('uploads/footer/'.$footer->logo) ?>" width="100">
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control"><?= $footer->description ?? '' ?></textarea>
    </div>

    <hr>
    <h4>Section</h4>
    <div class="form-group">
        <label>Heading</label>
        <input type="text" name="section_heading" class="form-control" value="<?= $footer->section_heading ?? '' ?>">
        <label>Description</label>
        <textarea name="section_description" class="form-control"><?= $footer->section_description ?? '' ?></textarea>
        <label>Image</label>
        <input type="file" name="section_image" class="form-control">
        <?php if(!empty($footer->section_image)): ?>
            <img src="<?= base_url('uploads/footer/'.$footer->section_image) ?>" width="80">
        <?php endif; ?>
    </div>

    <hr>
    <h4>Additional Sections</h4>
    <div id="additional-sections">
        <?php 
        if(!empty($footer->additional_sections)):
            $sections = json_decode($footer->additional_sections, true);
            foreach($sections as $section): ?>
                <div class="add-section mb-3 border p-3">
                    <label>Heading</label>
                    <input type="text" name="add_heading[]" class="form-control" value="<?= $section['heading'] ?>">
                    <label>Contact Info</label>
                    <input type="text" name="add_contact[]" class="form-control" value="<?= $section['contact_info'] ?>">
                    <label>Image</label>
                    <input type="file" name="add_image[]" class="form-control">
                    <input type="hidden" name="add_image_hidden[]" value="<?= $section['image'] ?? '' ?>">
                    <?php if(!empty($section['image'])): ?>
                        <img src="<?= base_url('uploads/footer/'.$section['image']) ?>" width="80">
                    <?php endif; ?>
                    <button type="button" class="btn btn-danger remove-add-section mt-2">Remove</button>
                </div>
        <?php endforeach; endif; ?>
    </div>
    <button type="button" id="add-more" class="btn btn-primary mt-2">Add More</button>

    <hr>
    <button type="submit" class="btn btn-success">Save Footer</button>
</form>

<script>
$(document).ready(function(){
    $('#add-more').click(function(){
        var html = `
        <div class="add-section mb-3 border p-3">
            <label>Heading</label>
            <input type="text" name="add_heading[]" class="form-control">
            <label>Contact Info</label>
            <input type="text" name="add_contact[]" class="form-control">
            <label>Image</label>
            <input type="file" name="add_image[]" class="form-control">
            <input type="hidden" name="add_image_hidden[]" value="">
            <button type="button" class="btn btn-danger remove-add-section mt-2">Remove</button>
        </div>`;
        $('#additional-sections').append(html);
    });

    $(document).on('click', '.remove-add-section', function(){
        $(this).closest('.add-section').remove();
    });
});
</script>
