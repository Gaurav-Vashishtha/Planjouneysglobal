<h4 class="mb-3">Edit Location</h4>

<?php echo form_open_multipart('admin/location/edit/' . $location->id); ?>
<div class="row">

    <div class="col-md-4 mb-3">
        <label class="form-label">Category <span class="text-danger">*</span></label>
        <select name="category" class="form-select">
            <option value="">Select Category</option>
            <option value="domestic" <?= ($location->category == 'domestic') ? 'selected' : ''; ?>>Domestic</option>
            <option value="europe" <?= ($location->category == 'europe') ? 'selected' : ''; ?>>Europe</option>
            <option value="asia" <?= ($location->category == 'asia') ? 'selected' : ''; ?>>asia</option>
            <option value="africa" <?= ($location->category == 'africa') ? 'selected' : ''; ?>>africa</option>
            <option value="oceania" <?= ($location->category == 'oceania') ? 'selected' : ''; ?>>oceania</option>
            <option value="middle_east" <?= ($location->category == 'middle_east') ? 'selected' : ''; ?>>middle_east</option>           
            <option value="north_america" <?= ($location->category == 'north_america') ? 'selected' : ''; ?>>north_america</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Name <span class="text-danger">*</span></label>
        <input type="text" name="name" id="location_name" class="form-control"
               value="<?php echo set_value('name', $location->name); ?>">
        <?php echo form_error('name'); ?>
    </div>


    <div class="col-md-4 mb-3">
    <label class="form-label">Location Icon</label>
    <?php if(isset($location->location_icon) && $location->location_icon): ?>
        <div class="mb-2">
            <img src="<?= base_url(''.$location->location_icon) ?>" 
                 alt="Icon" style="height:50px;">
        </div>
    <?php endif; ?>
    <input type="file" name="location_icon" class="form-control" accept=".jpg,.jpeg,.png,.webp">
</div>


</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Language</label>
        <input type="text" name="language" class="form-control"
               value="<?php echo set_value('language', $location->language); ?>">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Capital</label>
        <input type="text" name="capital" class="form-control"
               value="<?php echo set_value('capital', $location->capital); ?>">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Currency</label>
        <input type="text" name="currency" class="form-control"
               value="<?php echo set_value('currency', $location->currency); ?>">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label>Main Image</label><br>
        <?php if ($location->image): ?>
            <img src="<?php echo base_url('uploads/location/' . $location->image); ?>"
                 height="80" class="mb-2">
        <?php endif; ?>
        <input type="file" name="image" class="form-control">
    </div>

<div class="col-md-6 mb-3">
    <label>Gallery Images</label><br>

    <?php
    $gallery = json_decode($location->gallery, true);

    if (!empty($gallery)):
        foreach ($gallery as $img):
    ?>
        <div class="d-inline-block text-center m-2" style="position:relative;">


            <img src="<?php echo base_url('uploads/location/gallery/' . $img); ?>"
                 width="100" style="border:1px solid #ddd;">


            <a href="<?php echo base_url('admin/location/delete-gallery/' . $location->id . '/' . urlencode($img)); ?>"
               onclick="return confirm('Delete this image?');"
               class="btn btn-sm btn-danger"
               style="position:absolute; top:0; right:0;">
                ×
            </a>

        </div>
    <?php
        endforeach;
    endif;
    ?>

    <input type="file" name="gallery[]" class="form-control mt-2" multiple>
</div>

<div class="mb-3">
    <label>Video</label><br>
    <?php if ($location->video): ?>
        <video src="<?php echo base_url('uploads/location/video/' . $location->video); ?>"
               width="200" controls></video>
    <?php endif; ?>
    <input type="file" name="video" class="form-control mt-2">
</div>

<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" id="description" class="form-control">
        <?php echo set_value('description', $location->description); ?>
    </textarea>
</div>


<div class="mb-4">
    <h5>Best Time to Visit</h5>
    <div id="best_time_container">

        <?php if (!empty($best_time)): ?>
            <?php foreach ($best_time as $index => $bt): ?>
                <div class="best-time-item border p-3 mb-3 position-relative">
                    <?php if ($index > 0): ?>
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-best-time">Remove</button>
                    <?php endif; ?>

                    <div class="row g-2">
                        <div class="col-md-3">
                            <label>Season</label>
                            <input type="text" name="best_time[season][]" class="form-control"
                                   value="<?= htmlspecialchars($bt['season']); ?>">
                        </div>

                        <div class="col-md-3">
                            <label>Weather</label>
                            <input type="text" name="best_time[weather][]" class="form-control"
                                   value="<?= htmlspecialchars($bt['weather']); ?>">
                        </div>

                        <div class="col-md-3">
                            <label>Perfect For</label>
                            <input type="text" name="best_time[perfect_for][]" class="form-control"
                                   value="<?= htmlspecialchars($bt['perfect_for']); ?>">
                        </div>
                    </div>

                    <div class="mt-2">
                        <label>Image</label><br>
                        <?php if (!empty($bt['image'])): ?>
                            <img src="<?php echo base_url('uploads/location/best_time/' . $bt['image']); ?>"
                                 width="100" class="mb-2">
                        <?php endif; ?>
                        <input type="file" name="best_time_image[]" class="form-control">
                    </div>

                    <div class="mt-2">
                        <label>Highlights</label>
                        <textarea name="best_time[highlights][]" class="form-control highlight-editor">
                            <?= htmlspecialchars($bt['highlights']); ?>
                        </textarea>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php else: ?>

            <!-- Default Item -->
            <div class="best-time-item border p-3 mb-3 position-relative">
                <div class="row g-2">

                    <div class="col-md-3">
                        <label>Season</label>
                        <input type="text" name="best_time[season][]" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>Weather</label>
                        <input type="text" name="best_time[weather][]" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>Perfect For</label>
                        <input type="text" name="best_time[perfect_for][]" class="form-control">
                    </div>

                </div>

                <div class="mt-2">
                    <label>Image</label>
                    <input type="file" name="best_time_image[]" class="form-control">
                </div>

                <div class="mt-2">
                    <label>Highlights</label>
                    <textarea name="best_time[highlights][]" class="form-control highlight-editor"></textarea>
                </div>
            </div>

        <?php endif; ?>

    </div>

    <button type="button" id="add_best_time" class="btn btn-outline-primary btn-sm">Add More</button>
</div>

<!-- FAQ Section -->
<div class="mb-4">
    <h5>FAQs</h5>

    <div id="faq_container">

        <?php if (!empty($faqs)): ?>
            <?php foreach ($faqs as $index => $faq): ?>
                <div class="faq-item border p-3 mb-3 position-relative">

                    <?php if ($index > 0): ?>
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-faq">Remove</button>
                    <?php endif; ?>

                    <div class="mb-2">
                        <label>Question</label>
                        <input type="text" name="faq_question[]" class="form-control"
                               value="<?= htmlspecialchars($faq['question']); ?>">
                    </div>

                    <div>
                        <label>Answer</label>
                        <textarea name="faq_answer[]" class="form-control faq-editor" rows="3">
                            <?= htmlspecialchars($faq['answer']); ?>
                        </textarea>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php else: ?>

            <div class="faq-item border p-3 mb-3 position-relative">
                <div class="mb-2">
                    <label>Question</label>
                    <input type="text" name="faq_question[]" class="form-control">
                </div>

                <div>
                    <label>Answer</label>
                    <textarea name="faq_answer[]" class="form-control faq-editor" rows="3"></textarea>
                </div>
            </div>

        <?php endif; ?>

    </div>

    <button type="button" id="add_faq" class="btn btn-outline-primary btn-sm">Add More</button>
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="status" class="form-check-input" id="status" value="1"
        <?php echo set_checkbox('status', '1', $location->status == 1); ?>>
    <label class="form-check-label" for="status">Active</label>
</div>


<div class="form-check mb-3">
    <input type="checkbox" name="top_destination" class="form-check-input" id="top_destination" value="1"
        <?php echo set_checkbox('top_destination', '1', $location->top_destination == 1); ?>>
    <label class="form-check-label" for="top_destination">Top Destination</label>
</div>

<div class="form-check mb-3">
    <input type="checkbox" name="popular" class="form-check-input" id="top_destination" value="1"
        <?php echo set_checkbox('popular', '1', $location->popular == 1); ?>>
    <label class="form-check-label" for="top_destination">Popular Location</label>
</div>


<button type="submit" class="btn btn-primary">Update Location</button>
<a href="<?= base_url('admin/location'); ?>" class="btn btn-secondary">Cancel</a>

<?php echo form_close(); ?>

<!-- CKEditor + jQuery -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
/* Initialize CKEditor instances */
ClassicEditor.create(document.querySelector('#description')).catch(console.error);

document.querySelectorAll('.highlight-editor').forEach(el => {
    ClassicEditor.create(el).catch(console.error);
});

document.querySelectorAll('.faq-editor').forEach(el => {
    ClassicEditor.create(el).catch(console.error);
});

/* Add Best Time */
$('#add_best_time').on('click', function () {
    var html = `
    <div class="best-time-item border p-3 mb-3 position-relative">
        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-best-time">Remove</button>

        <div class="row g-2">
            <div class="col-md-3"><label>Season</label><input type="text" name="best_time[season][]" class="form-control"></div>
            <div class="col-md-3"><label>Weather</label><input type="text" name="best_time[weather][]" class="form-control"></div>
            <div class="col-md-3"><label>Perfect For</label><input type="text" name="best_time[perfect_for][]" class="form-control"></div>
        </div>

        <div class="mt-2"><label>Image</label><input type="file" name="best_time_image[]" class="form-control"></div>

        <div class="mt-2">
            <label>Highlights</label>
            <textarea name="best_time[highlights][]" class="form-control highlight-editor"></textarea>
        </div>
    </div>`;

    $('#best_time_container').append(html);


    ClassicEditor.create($('#best_time_container .best-time-item:last textarea.highlight-editor')[0])
        .catch(console.error);
});


$(document).on('click', '.remove-best-time', function () {
    $(this).closest('.best-time-item').remove();
});


$('#add_faq').on('click', function () {
    var html = `
    <div class="faq-item border p-3 mb-3 position-relative">
        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-faq">Remove</button>

        <div class="mb-2"><label>Question</label><input type="text" name="faq_question[]" class="form-control"></div>

        <div>
            <label>Answer</label>
            <textarea name="faq_answer[]" class="form-control faq-editor" rows="3"></textarea>
        </div>
    </div>`;

    $('#faq_container').append(html);


    ClassicEditor.create($('#faq_container .faq-item:last textarea.faq-editor')[0])
        .catch(console.error);
});

$(document).on('click', '.remove-faq', function () {
    $(this).closest('.faq-item').remove();
});
</script>
