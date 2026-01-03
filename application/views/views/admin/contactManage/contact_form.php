<form method="post" action="<?= base_url('admin/contact/save') ?>" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= isset($contact->id) ? $contact->id : '' ?>">

    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="<?= isset($contact->title) ? $contact->title : '' ?>" required>
    </div>

    <div class="form-group">
        <label>Page Image  <small>(Max size: 2 MB)</small></label>
        <input type="file" name="image" class="form-control">
        <?php if(!empty($contact->image)): ?>
            <img src="<?= base_url('uploads/contact/'.$contact->image) ?>" width="100">
        <?php endif; ?>
    </div>
 

    <div class="form-group">
    <label>Meta Title</label>
    <textarea name="meta_title" id="meta_title" class="form-control" required>
        <?= isset($contact->meta_title) ? $contact->meta_title : '' ?>
    </textarea>
</div>

<div class="form-group">
    <label>Meta Description</label>
    <textarea name="meta_discription" id="meta_discription" class="form-control" required>
        <?= isset($contact->meta_discription) ? $contact->meta_discription : '' ?>
    </textarea>
</div>
    <hr>
    <h4>Contact Sections</h4>

    <div id="contact-sections">
    <?php 
    if(!empty($contact->sections)):
        foreach($contact->sections as $section): ?>
            <div class="contact-section mb-3 border p-3">
                <label>State Name</label>
                <input type="text" name="state_name[]" class="form-control" value="<?= $section['state_name'] ?>" required>

                <label>Contact No.</label>
                <input type="text" name="contact_no[]" class="form-control" value="<?= $section['contact_no'] ?>" required>

                <label>Address</label>
                <textarea name="address[]" class="form-control" required><?= $section['address'] ?></textarea>

                <label>Section Image  <small>(Max size: 2 MB)</small></label>
                <input type="file" name="section_image[]" class="form-control">
                
                <input type="hidden" name="section_image_hidden[]" value="<?= $section['image'] ?? '' ?>">

                <?php if(!empty($section['image'])): ?>
                    <img src="<?= base_url('uploads/contact_sections/'.$section['image']) ?>" width="80">
                <?php endif; ?>

                <button type="button" class="btn btn-danger remove-section mt-2">Remove</button>
            </div>
    <?php endforeach;
    else: ?>
        <div class="contact-section mb-3 border p-3">
            <label>State Name</label>
            <input type="text" name="state_name[]" class="form-control" required>

            <label>Contact No.</label>
            <input type="text" name="contact_no[]" class="form-control" required>

            <label>Address</label>
            <textarea name="address[]" class="form-control" required></textarea>

            <label>Section Image</label>
            <input type="file" name="section_image[]" class="form-control">
            <input type="hidden" name="section_image_hidden[]" value="">

            <button type="button" class="btn btn-danger remove-section mt-2">Remove</button>
        </div>
    <?php endif; ?>
</div>


    <button type="button" id="add-section" class="btn btn-primary mt-2">Add More</button>
    <hr>
    <button type="submit" class="btn btn-success">Save Contact Page</button>
</form>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#add-section').click(function() {
        var sectionHTML = `
        <div class="contact-section mb-3 border p-3">
            <label>State Name</label>
            <input type="text" name="state_name[]" class="form-control" required>

            <label>Contact No.</label>
            <input type="text" name="contact_no[]" class="form-control" required>

            <label>Address</label>
            <textarea name="address[]" class="form-control" required></textarea>

            <label>Section Image</label>
            <input type="file" name="section_image[]" class="form-control">

            <button type="button" class="btn btn-danger remove-section mt-2">Remove</button>
        </div>`;
        $('#contact-sections').append(sectionHTML);
    });

    $(document).on('click', '.remove-section', function() {
        $(this).closest('.contact-section').remove();
    });
});
</script>
