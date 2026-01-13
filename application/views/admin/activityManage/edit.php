<h6 class="d-flex justify-content-between align-items-center">
    <?= $title; ?>
    <div class="steps-links">
        <a href="javascript:void(0)" class="step-link active" data-step="1">Step 1</a> |
        <a href="javascript:void(0)" class="step-link disabled" data-step="2">Step 2</a> |
        <a href="javascript:void(0)" class="step-link disabled" data-step="3">Step 3</a>
    </div>
</h6>

<?= form_open_multipart('admin/activities/edit/'.$activities->id); ?>

<!-- STEP 1 -->
<div id="step1" class="step-card">

    <div class="row">
<div class="col-md-3 mb-3">
    <label class="form-label">Category <span class="text-danger">*</span></label>
    <select name="category" class="form-select" id="category" >
        <option value="">Select Category</option>

        <option value="domestic"      <?= ($activities->category == "domestic") ? "selected" : "" ?>>Domestic</option>
        <option value="europe"        <?= ($activities->category == "europe") ? "selected" : "" ?>>Europe</option>
        <option value="asia"          <?= ($activities->category == "asia") ? "selected" : "" ?>>Asia</option>
        <option value="africa"        <?= ($activities->category == "africa") ? "selected" : "" ?>>Africa</option>
        <option value="oceania"       <?= ($activities->category == "oceania") ? "selected" : "" ?>>Oceania</option>
        <option value="middle_east"   <?= ($activities->category == "middle_east") ? "selected" : "" ?>>Middle East</option>
        <option value="north_america" <?= ($activities->category == "north_america") ? "selected" : "" ?>>North America</option>

    </select>
</div>


        <div class="col-md-3 mb-3">
        <label class="form-label">Location <span class="text-danger"></span></label>
        <select name="location_id" id="location_id" class="form-select" >
            <option value="">Loading...</option>
        </select>
    </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">Activity Category <span class="text-danger"></span></label>
            <select name="category_id" id="category_id" class="form-select">
                <option value="">Select Activity Category</option>
                <?php foreach($activity_categories as $cat): ?>
                    <option value="<?= $cat->id ?>"
                        <?= ($activities->category_id == $cat->id) ? 'selected' : '' ?>>
                        <?= $cat->category_name ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">Activities <span class="text-danger"></span></label>
            <select name="activities[]" id="activities" class="form-select select2" multiple>
                
            </select>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Title <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control"  value="<?= $activities->title; ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Meta Title</label>
        <textarea name="meta_title" class="form-control" rows="1"><?= $activities->meta_title; ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Short Description</label>
        <input type="text" name="short_description" class="form-control" value="<?= $activities->short_description; ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" rows="4"><?= $activities->description; ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Meta Description</label>
        <textarea name="meta_description" id="meta_description" class="form-control"><?= $activities->meta_description; ?></textarea>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?= $activities->price; ?>">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Image <small>(Max size: 2 MB, 1800*900)</small></label>
            <input type="file" name="image" class="form-control">
            <?php if ($activities->image): ?>
                <img src="<?= base_url('' . $activities->image) ?>" width="120" class="img-thumbnail mt-2">
            <?php endif; ?>
        </div>
    </div>

<div class="mb-4">
    <h5>Multiple Images</h5>
    <div id="galleryContainer">

        <?php if (!empty($activities->gallery) && is_array($activities->gallery)): ?>
            <?php foreach ($activities->gallery as $index => $mt): ?>
                <div class="galleryContainerItem border p-3 mb-3 position-relative">
                    <?php if ($index > 0): ?>
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 removeImage">Remove</button>
                    <?php endif; ?>

                    <div class="row g-2">
                        <div class="col-md-4">
                            <label>Name</label>
                            <input type="text" name="image_name[]" class="form-control"
                                   value="<?= htmlspecialchars($mt['image_name']); ?>">
                        </div>

                        <div class="col-md-8">
                            <label>Image <small>(Max size: 5 MB)</small></label><br>
                            <?php if (!empty($mt['image'])): ?>
                                <img src="<?php echo base_url($mt['image']); ?>" width="100" class="mb-2">
                            <?php endif; ?>
                            <input type="file" name="multi_image[]" class="form-control">
                        </div>

                        <input type="hidden" name="existing_images[]" value="<?= htmlspecialchars($mt['image']); ?>">
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="galleryContainerItem border p-3 mb-3 position-relative">
                <div class="row g-2">
                    <div class="col-md-4">
                        <label>Name</label>
                        <input type="text" name="image_name[]" class="form-control">
                    </div>

                    <div class="col-md-8">
                        <label>Image <small>(Max size: 5 MB)</small></label>
                        <input type="file" name="multi_image[]" class="form-control">
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <button type="button" id="addImage" class="btn btn-outline-primary btn-sm">Add More</button>
</div>


    
 <div class="row">
    <div class="col-md-6 mb-3 form-check">
        <input type="checkbox" name="status" value="1" class="form-check-input" <?= ($activities->status == 1) ? "checked" : "" ?>>
        <label class="form-check-label">Active</label>
    </div>
    <div class="col-md-6 mb-3 form-check">
        <input type="checkbox" name="popular" value="1" class="form-check-input" <?= ($activities->popular == 1) ? "checked" : "" ?>>
        <label class="form-check-label">Popular</label>
    </div>
 </div>
    <div class="text-end">
        <button type="button" class="btn btn-primary next-step" data-next="2">Next →</button>
    </div>

</div>

<!-- STEP 2 -->
<div id="step2" class="step-card d-none">
    
    
    <label>Highlights of Activity</label>
    <textarea name="highlights_of_activity" id="highlights_of_tours" class="form-control mb-3" rows="4"><?= $activities->highlights_of_activity; ?></textarea>
   <label>Additional Info</label>
    <textarea name="additional_info" id="additional_info" class="form-control mb-3" rows="4"><?= $activities->additional_info; ?></textarea>
    <label>Activity Overview</label>
    <textarea name="activity_overview" id="note" class="form-control mb-3" rows="4"><?= $activities->activity_overview; ?></textarea>
    <div class="text-end">
        <button type="button" class="btn btn-secondary prev-step" data-prev="1">← Previous</button>
        <button type="button" class="btn btn-primary next-step" data-next="3">Next →</button>
    </div>
</div>

<!-- STEP 3 -->
<div id="step3" class="step-card d-none">
    <label>Inclusion</label>
    <textarea name="inclusion" id="inclusion" class="form-control mb-3" rows="4"><?= $activities->inclusion; ?></textarea>
    <label>Exclusion</label>
    <textarea name="exclusion" id="exclusion" class="form-control mb-3" rows="4"><?= $activities->exclusion; ?></textarea>
    <label>Additional Charge</label>
    <textarea name="addtional_charge" id="addtional_charge" class="form-control mb-3" rows="4"><?= $activities->addtional_charge; ?></textarea>
    <label>Activity Overview</label>
    <textarea name="activity_overview" id="note" class="form-control mb-3" rows="4"><?= $activities->activity_overview; ?></textarea>

    <div class="text-end">
        <button type="button" class="btn btn-secondary prev-step" data-prev="2">← Previous</button>
        <button type="submit" class="btn btn-success">Update activities</button>
    </div>
</div>

<?= form_close(); ?>

<script>
    let savedActivities = <?= json_encode(
        !empty($activities->activity_names)
            ? array_map('trim', explode(',', $activities->activity_names))
            : []
    ); ?>;
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editors = [
            'description','day_details',
            'highlights_of_tours', 'additional_info',
            'inclusion', 'exclusion', 'addtional_charge', 'note'
        ];

        editors.forEach(id => {
            const el = document.getElementById(id);
            if (el) ClassicEditor.create(el).catch(() => {});
        });

        const steps = document.querySelectorAll('.step-card');
        const links = document.querySelectorAll('.step-link');

        function showStep(step) {
            steps.forEach(s => s.classList.add('d-none'));
            document.getElementById('step' + step).classList.remove('d-none');
            links.forEach(l => l.classList.remove('active'));
            document.querySelector('.step-link[data-step="' + step + '"]').classList.add('active');
        }

        document.querySelectorAll('.next-step').forEach(btn => {
            btn.addEventListener('click', () => {
                const step = btn.dataset.next;
                showStep(step);
                document.querySelector('.step-link[data-step="' + step + '"]').classList.remove('disabled');
            });
        });

        document.querySelectorAll('.prev-step').forEach(btn => {
            btn.addEventListener('click', () => showStep(btn.dataset.prev));
        });

        links.forEach(link => {
            link.addEventListener('click', function() {
                if (!this.classList.contains('disabled')) showStep(this.dataset.step);
            });
        });

        $('.select2').select2();
    });
</script>

    <script>
$(document).ready(function() {

    let selectedLocation = "<?= $activities->location_id ?>";
    let currentCategory  = "<?= $activities->category ?>";

    if (currentCategory !== "") {
        loadLocations(currentCategory, selectedLocation);
    }

    $(document).on('change', 'select[name="category"]', function () {
        let category = $(this).val();
        $("#location_id").html('<option value="">Loading...</option>');

        if (category !== "") {
            loadLocations(category, null);
        }
    });

   

    function loadLocations(category, selected = null) {
    $.ajax({
        url: "<?= base_url('admin/activities/get_location/'); ?>" + encodeURIComponent(category),
        type: "GET",
        dataType: "json",
        success: function(res) {
            $("#location_id").html('<option value="">Select Location</option>');

            if (res.length > 0) {
                $.each(res, function(i, loc) {
                    let isSelected = (selected == loc.id) ? "selected" : "";
                    $("#location_id").append(
                        `<option value="${loc.id}" ${isSelected}>${loc.name}</option>`
                    );
                });
            } else {
                $("#location_id").html('<option value="">No Locations Found</option>');
            }
        }
    });
}


});
</script>

<script>
$(document).ready(function () {

    $('.select2').select2({
        placeholder: "Select Activities"
    });

    let categoryActivity = "<?= $activities->category_id ?>";

    if (categoryActivity) {
        loadActivities(categoryActivity);
    }

    $('#category_id').on('change', function () {
        let categoryId = $(this).val();
        $('#activities').empty().trigger('change');

        if (categoryId) {
            loadActivities(categoryId);
        }
    });

    function loadActivities(categoryId) {
        $.ajax({
            url: "<?= base_url('admin/activities/get_activities_by_category/') ?>" + categoryId,
            type: "GET",
            dataType: "json",
            success: function (res) {
                let options = '';

                $.each(res, function (i, activity) {
                    let selected = savedActivities.includes(activity.activity_name)
                        ? 'selected'
                        : '';

                    options += `
                        <option value="${activity.id}" ${selected}>
                            ${activity.activity_name}
                        </option>`;
                });

                $('#activities').html(options).trigger('change');
            }
        });
    }

});
</script>
<script>
    $('#addImage').on('click', function () {
        var html = `
            <div class="galleryContainerItem border p-3 mb-3 position-relative">
                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 removeImage">Remove</button>
                <div class="row g-2">
                    <div class="col-md-4">
                        <label>Name</label>
                        <input type="text" name="image_name[]" class="form-control">
                    </div>
                    <div class="col-md-8">
                        <label>Image</label>
                        <input type="file" name="multi_image[]" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>`;
        $("#galleryContainer").append(html);
    });
    $(document).on("click", ".removeImage", function () {
        $(this).closest(".galleryContainerItem").remove();
    });
</script>
<style>
.steps-links a {
    margin-left: 5px;
    text-decoration: none;
    color: #0d6efd;
    font-weight: 600;
}
.steps-links a.active { text-decoration: underline; }
.steps-links a.disabled { color: #aaa; pointer-events: none; }
.step-card {
    border-radius: 12px;
    background: #fff;
    padding: 20px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
}
.ck-editor__editable_inline {
    min-height: 120px !important;
}
</style>