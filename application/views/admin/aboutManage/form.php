<form action="<?= base_url('admin/about_us/save') ?>" method="post" enctype="multipart/form-data">

    <h3>About Page</h3>

    <!-- Page Title -->
    <label>Page Title</label>
    <input type="text" name="title" class="form-control mb-2"
           value="<?= isset($about->title) ? $about->title : '' ?>" required>



   <!-- Meta Title -->

            <label>Meta Title</label>
            <input type="text" name="meta_title"  class="form-control mb-2 "
           value="<?= isset($about->meta_title) ? $about->meta_title : '' ?>">

       <!-- Meta Description -->
             <label>Meta Description</label>
             <textarea name="meta_discription" id="meta_discription" class="form-control mb-2"><?= $about->meta_discription ?? '' ?></textarea> 


    <hr>
    <!-- Best Agency (Single Section) -->
    <h4>Best Agency (Main Section)</h4>

   <label>Best Agency Image</label>
<input type="file" name="best_agency_image_main" class="form-control mb-2">

<?php if (!empty($about->best_agency_image_main)): ?>
    <img src="<?= base_url('./uploads/home/best_agency_main' . $about->best_agency_image_main) ?>" width="120">
<?php endif; ?>



    <label>Best Agency Link</label>
    <input type="text" name="best_agency_link" class="form-control mb-2"
           value="<?= $about->best_agency_link ?? '' ?>">

    <label>Best Agency Description</label>
    <textarea name="best_agency" id="best_agency" class="form-control mb-2"><?= $about->best_agency ?? '' ?></textarea>

    <hr>

    <!-- Best Service Tab -->
    <h4>Best Service Tab</h4>

    <label>Tab Title</label>
    <input type="text" name="about_best_service_title" class="form-control mb-2"
           value="<?= $about->about_best_service_title ?? '' ?>">

    <label>Tab Link</label>
    <input type="text" name="about_best_service_link" class="form-control mb-2"
           value="<?= $about->about_best_service_link ?? '' ?>">

    <button type="button" id="add-desire" class="btn btn-primary mb-3">Add More Best Service</button>

    <div id="desire-place-wrapper">
        <?php
        $about_best_service = isset($about->about_best_service_places)
                              ? json_decode($about->about_best_service_places, true)
                              : [[]];
        foreach ($about_best_service as $s):
        ?>
        <div class="desire-place-item mb-3 border p-3">
            <label>Heading</label>
            <input type="text" name="about_best_service_heading[]" class="form-control mb-1"
                   value="<?= $s['heading'] ?? '' ?>">

            <label>Description</label>
            <textarea name="about_best_service_description[]" class="form-control mb-2"><?= $s['description'] ?? '' ?></textarea>

            <label>Image Upload</label>
            <input type="file" name="about_best_service_image[]" class="form-control mb-2">

            <?php if (!empty($s['image'])): ?>
                <img src="<?= base_url($s['image']) ?>" width="100">
            <?php endif; ?>

            <input type="hidden" name="about_best_service_image_hidden[]" value="<?= $s['image'] ?? '' ?>">

            <button type="button" class="btn btn-danger remove-desire">Remove</button>
        </div>
        <?php endforeach; ?>
    </div>


    <!-- Travel With Us -->
    <h4>Why Travel With Us</h4>

    <label>Travel With Us Description</label>
    <textarea name="travel_with_us_des" id="travel_with_us_des" class="form-control mb-2"><?= $about->travel_with_us_des ?? '' ?></textarea>
    <br>

    <button type="button" id="add-top" class="btn btn-primary mb-3">Add More Travel With Us</button>

    <div id="top-destination-wrapper">
        <?php
        $travel_with_us = isset($about->travel_with_us)
                          ? json_decode($about->travel_with_us, true)
                          : [[]];
        foreach ($travel_with_us as $t):
        ?>
        <div class="top-destination-item mb-3 border p-3">
            <label>Image Upload</label>
            <input type="file" name="travel_with_us_image[]" class="form-control mb-1">

            <?php if (!empty($t['image'])): ?>
                <img src="<?= base_url($t['image']) ?>" width="100">
            <?php endif; ?>

            <label>Paragraph</label>
            <textarea name="travel_with_us_paragraph[]" class="form-control mb-2"><?= $t['paragraph'] ?? '' ?></textarea>

            <input type="hidden" name="travel_with_us_image_hidden[]" value="<?= $t['image'] ?? '' ?>">

            <button type="button" class="btn btn-danger remove-top">Remove</button>
        </div>
        <?php endforeach; ?>
    </div>

    <hr>

    <!-- Travellers -->
    <h4>Here It From Travellers</h4>
    <textarea name="here_it_from_travelrs" id="travellers" class="form-control mb-3"><?= $about->here_it_from_travelrs ?? '' ?></textarea>


    <!-- Bottom Icons -->
    <h4>Bottom Icons Section</h4>

    <button type="button" id="add-agency" class="btn btn-primary mb-3">Add Icon</button>

    <div id="best-agency-wrapper">
        <?php
        $bottom_icon = isset($about->best_agencies)
                       ? json_decode($about->best_agencies, true)
                       : [[]];
        foreach ($bottom_icon as $b):
        ?>
        <div class="best-agency-item mb-3 border p-3">
            <label>Heading</label>
            <input type="text" name="best_agency_heading[]" class="form-control mb-1"
                   value="<?= $b['heading'] ?? '' ?>">

            <label>Paragraph</label>
            <textarea name="best_agency_paragraph[]" class="form-control mb-1"><?= $b['paragraph'] ?? '' ?></textarea>

            <label>Image Upload</label>
            <input type="file" name="best_agency_image[]" class="form-control mb-2">
            <?php if (!empty($b['image'])): ?>
                <img src="<?= base_url($b['image']) ?>" width="100">
            <?php endif; ?>
            <input type="hidden" name="best_agency_image_hidden[]" value="<?= $b['image'] ?? '' ?>">

            <button type="button" class="btn btn-danger remove-agency">Remove</button>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if (isset($about->id)): ?>
        <input type="hidden" name="id" value="<?= $about->id ?>">
    <?php endif; ?>

    <button type="submit" class="btn btn-success mt-3">Save About Page</button>
</form>


<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

<script>
ClassicEditor.create(document.querySelector('#best_agency'));
ClassicEditor.create(document.querySelector('#meta_discription'));
ClassicEditor.create(document.querySelector('#travellers'));
ClassicEditor.create(document.querySelector('#travel_with_us_des'));
</script>


<script>

document.getElementById('add-desire').onclick = () => {
    document.getElementById('desire-place-wrapper').insertAdjacentHTML('beforeend', `
        <div class="desire-place-item mb-3 border p-3">
            <label>Heading</label>
            <input type="text" name="about_best_service_heading[]" class="form-control mb-1">

            <label>Description</label>
            <textarea name="about_best_service_description[]" class="form-control mb-2"></textarea>

            <label>Image Upload</label>
            <input type="file" name="about_best_service_image[]" class="form-control mb-2">

            <button type="button" class="btn btn-danger remove-desire">Remove</button>
        </div>
    `);
};

document.addEventListener('click', e => {
    if (e.target.classList.contains('remove-desire')) e.target.closest('.desire-place-item').remove();
});


document.getElementById('add-top').onclick = () => {
    document.getElementById('top-destination-wrapper').insertAdjacentHTML('beforeend', `
        <div class="top-destination-item mb-3 border p-3">
            <label>Image Upload</label>
            <input type="file" name="travel_with_us_image[]" class="form-control">

            <label>Paragraph</label>
            <textarea name="travel_with_us_paragraph[]" class="form-control mb-2"></textarea>

            <button type="button" class="btn btn-danger remove-top">Remove</button>
        </div>
    `);
};

document.addEventListener('click', e => {
    if (e.target.classList.contains('remove-top')) e.target.closest('.top-destination-item').remove();
});


document.getElementById('add-faq').onclick = () => {
    document.getElementById('faq-wrapper').insertAdjacentHTML('beforeend', `
        <div class="faq-item mb-3 border p-3">
            <label>Question</label>
            <input type="text" name="faq_question[]" class="form-control mb-2">

            <label>Answer</label>
            <textarea name="faq_answer[]" class="form-control mb-2"></textarea>

            <button type="button" class="btn btn-danger remove-faq">Remove</button>
        </div>
    `);
};

document.addEventListener('click', e => {
    if (e.target.classList.contains('remove-faq')) e.target.closest('.faq-item').remove();
});


document.getElementById('add-agency').onclick = () => {
    document.getElementById('best-agency-wrapper').insertAdjacentHTML('beforeend', `
        <div class="best-agency-item mb-3 border p-3">

            <label>Heading</label>
            <input type="text" name="best_agency_heading[]" class="form-control mb-1">

            <label>Paragraph</label>
            <textarea name="best_agency_paragraph[]" class="form-control mb-1"></textarea>

            <label>Image Upload</label>
            <input type="file" name="best_agency_image[]" class="form-control mb-2">

            <button type="button" class="btn btn-danger remove-agency">Remove</button>
        </div>
    `);
};

document.addEventListener('click', e => {
    if (e.target.classList.contains('remove-agency')) e.target.closest('.best-agency-item').remove();
});

</script>
