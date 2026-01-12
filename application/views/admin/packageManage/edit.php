<h6 class="d-flex justify-content-between align-items-center">
    <?= $title; ?>
    <div class="steps-links">
        <a href="javascript:void(0)" class="step-link active" data-step="1">Step 1</a> |
        <a href="javascript:void(0)" class="step-link disabled" data-step="2">Step 2</a> |
        <a href="javascript:void(0)" class="step-link disabled" data-step="3">Step 3</a>
    </div>
</h6>

<?= form_open_multipart('admin/package/edit/'.$package->id); ?>

<!-- STEP 1 -->
<div id="step1" class="step-card">

    <div class="row">
<div class="col-md-4 mb-3">
    <label class="form-label">Category <span class="text-danger">*</span></label>
    <select name="category" class="form-select" id="category" >
        <option value="">Select Category</option>

        <option value="domestic"      <?= ($package->category == "domestic") ? "selected" : "" ?>>Domestic</option>
        <option value="europe"        <?= ($package->category == "europe") ? "selected" : "" ?>>Europe</option>
        <option value="asia"          <?= ($package->category == "asia") ? "selected" : "" ?>>Asia</option>
        <option value="africa"        <?= ($package->category == "africa") ? "selected" : "" ?>>Africa</option>
        <option value="oceania"       <?= ($package->category == "oceania") ? "selected" : "" ?>>Oceania</option>
        <option value="middle_east"   <?= ($package->category == "middle_east") ? "selected" : "" ?>>Middle East</option>
        <option value="north_america" <?= ($package->category == "north_america") ? "selected" : "" ?>>North America</option>

    </select>
</div>


        <div class="col-md-4 mb-3">
        <label class="form-label">Location <span class="text-danger"></span></label>
        <select name="location_id" id="location_id" class="form-select" >
            <option value="">Loading...</option>
        </select>
    </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">No. of Destinations</label>
            <input type="text" name="destinations" class="form-control" value="<?= $package->destinations; ?>">
        </div>
    </div>


    <div class="mb-3">
        <label class="form-label">Title <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control"  value="<?= $package->title; ?>">
    </div>


    <div class="mb-3">
        <label class="form-label">Meta Title</label>
        <textarea name="meta_title" class="form-control" rows="1"><?= $package->meta_title; ?></textarea>
    </div>


    <div class="mb-3">
        <label class="form-label">Short Description</label>
        <input type="text" name="short_description" class="form-control" value="<?= $package->short_description; ?>">
    </div>


    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" rows="4"><?= $package->description; ?></textarea>
    </div>


    <div class="mb-3">
        <label class="form-label">Meta Description</label>
        <textarea name="meta_description" id="meta_description" class="form-control" rows=""><?= $package->meta_description; ?></textarea>
    </div>
      <div class="mb-3">
        <label class="form-label">Meta Keyword</label>
        <textarea name="meta_keyword" id="meta_keyword" class="form-control" rows=""><?= $package->meta_keyword; ?></textarea>
    </div>

    <div class="row">

        <div class="col-md-4 mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?= $package->price; ?>">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Image <small>(Max size: 2 MB , 1800*900)</small></label>
            <input type="file" name="image" class="form-control">
            <?php if ($package->image): ?>
                <img src="<?= base_url('' . $package->image) ?>" width="120" class="img-thumbnail mt-2">
            <?php endif; ?>
        </div>

           <div class="col-md-4 mb-3">
            <label class="form-label">Image Top<small>(Max size: 2 MB , 1800*900)</small></label>
            <input type="file" name="image_top" class="form-control">
            <?php if ($package->image_top): ?>
                <img src="<?= base_url('' . $package->image_top) ?>" width="120" class="img-thumbnail mt-2">
            <?php endif; ?>
        </div>
    </div>

 <div class="row">
    <div class="col-md-4 mb-3">
        <label class="form-label">Accommodation <span class="text-danger"></span></label>
        <?php
            $selected_acc = !empty($package->accommodation) ? json_decode($package->accommodation, true) : [];
            $accommodationOption = ['5 Star Hotel', '4 Star Hotel', '3 Star Hotel', 'Resort', 'Villa'];
        ?>
        <select name="accommodation[]" class="form-select select2 custom-form-select" multiple>
            <?php
                foreach ($accommodationOption as $option) {
                    $selected = in_array($option, $selected_acc) ? "selected" : "";
                    echo "<option value=\"$option\" $selected>$option</option>";
                }
                $new_accommodations = array_diff($selected_acc, $accommodationOption);
                foreach ($new_accommodations as $new_option) {
                    echo "<option value=\"$new_option\" selected>$new_option</option>";
                }
            ?>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Meals</label>
        <?php
            $selected_meal[] = !empty($package->meals) ? $package->meals : ''; 
            $mealOptions = ['Breakfast Only', 'Breakfast & Dinner', 'All Meals'];
        ?>

        <select name="meals" class="form-select select2 custom-form-select">
            <option value="">Select Meal Plan</option>
            <?php
                foreach ($mealOptions as $option) {
                    $selected = in_array($option, $selected_meal) ? "selected" : "";
                    echo "<option value=\"$option\" $selected>$option</option>";
                }
                $new_meals = array_diff($selected_meal, $mealOptions);
                foreach ($new_meals as $new_option) {
                    echo "<option value=\"$new_option\" selected>$new_option</option>";
                }
            ?>
        </select>
    </div>

   <div class="col-md-4 mb-3">
    <label class="form-label">Transportation</label>
    <?php
        $selected_transportation = !empty($package->transportation) ? (array)$package->transportation : []; 
        $transportationOptions = ['Taxi', 'Car', 'Bus'];
    ?>

    <select name="transportation" class="form-select select2 custom-form-select">
        <option value="">Select Transportation</option>
        <?php
            foreach ($transportationOptions as $option) {
                $selected = in_array($option, $selected_transportation) ? "selected" : "";
                echo "<option value=\"$option\" $selected>$option</option>";
            }
            $new_transportations = array_diff($selected_transportation, $transportationOptions);
            foreach ($new_transportations as $new_option) {
                echo "<option value=\"$new_option\" selected>$new_option</option>";
            }
        ?>
    </select>
</div>

 </div>

   <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Tour Type <span class="text-danger"></span></label>
            <?php
                $selected_tour = !empty($package->tour_type) ? json_decode($package->tour_type, true) : [];
                $tourTypeOptions = ['Adventure', 'Family', 'Honeymoon', 'Luxury', 'Solo', 'Group'];
            ?>
            <select name="tour_type[]" class="form-select select2 custom-form-select" multiple>
                <?php
                    foreach ($tourTypeOptions as $option) {
                        $selected = in_array($option, $selected_tour) ? "selected" : "";
                        echo "<option value=\"$option\" $selected>$option</option>";
                    }
                    $new_tour_types = array_diff($selected_tour, $tourTypeOptions);
                    foreach ($new_tour_types as $new_option) {
                        echo "<option value=\"$new_option\" selected>$new_option</option>";
                    }
                ?>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Duration</label>
            <input type="text" name="duration" class="form-control" value="<?= $package->duration; ?>">
        </div>

    </div>


    <div class="mb-3 form-check">
        <input type="checkbox" name="status" value="1" class="form-check-input" <?= ($package->status == 1) ? "checked" : "" ?>>
        <label class="form-check-label">Active</label>
    </div>

      <div class="mb-3 form-check">
        <input type="checkbox" name="popular" value="1" class="form-check-input" <?= ($package->popular == 1) ? "checked" : "" ?>>
        <label class="form-check-label">Popular</label>
    </div>

    <div class="text-end">
        <button type="button" class="btn btn-primary next-step" data-next="2">Next →</button>
    </div>

</div>

<!-- STEP 2 -->
<div id="step2" class="step-card d-none">
    <label>Day Deatails</label>
    <textarea name="day_details" id="day_details" class="form-control mb-3" rows="4"><?= $package->day_details; ?></textarea>
    <label>Highlights of Tour</label>
    <textarea name="highlights_of_tours" id="highlights_of_tours" class="form-control mb-3" rows="4"><?= $package->highlights_of_tours; ?></textarea>
   <label>Additional Info</label>
    <textarea name="additional_info" id="additional_info" class="form-control mb-3" rows="4"><?= $package->additional_info; ?></textarea>

    <div class="text-end">
        <button type="button" class="btn btn-secondary prev-step" data-prev="1">← Previous</button>
        <button type="button" class="btn btn-primary next-step" data-next="3">Next →</button>
    </div>
</div>

<!-- STEP 3 -->
<div id="step3" class="step-card d-none">
    <label>Inclusion</label>
    <textarea name="inclusion" id="inclusion" class="form-control mb-3" rows="4"><?= $package->inclusion; ?></textarea>
    <label>Exclusion</label>
    <textarea name="exclusion" id="exclusion" class="form-control mb-3" rows="4"><?= $package->exclusion; ?></textarea>
    <label>Additional Charge</label>
    <textarea name="addtional_charge" id="addtional_charge" class="form-control mb-3" rows="4"><?= $package->addtional_charge; ?></textarea>
    <label>Note</label>
    <textarea name="note" id="note" class="form-control mb-3" rows="4"><?= $package->note; ?></textarea>

    <div class="text-end">
        <button type="button" class="btn btn-secondary prev-step" data-prev="2">← Previous</button>
        <button type="submit" class="btn btn-success">Update Package</button>
    </div>
</div>

<?= form_close(); ?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editors = [
            'description',  'day_details',
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

    let selectedLocation = "<?= $package->location_id ?>";
    let currentCategory  = "<?= $package->category ?>";

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
            url: "<?= base_url('package/get_locations_by_category/'); ?>" + category,
            type: "GET",
            dataType: "json",
            success: function (res) {

                $("#location_id").html('<option value="">Select Location</option>');

                if (res.length > 0) {

                    $.each(res, function (i, loc) {
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
    $(document).ready(function() {
        $('.select2').select2({
            tags: true, 
            tokenSeparators: [',', ' '], 
            placeholder: 'Select or type an option'  
        });
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

.select2-container .select2-selection--single {
    height: calc(2.25rem + 2px);  
    padding: 0.375rem 0.75rem;   
}

.select2-container--default .select2-selection--multiple {
    min-height: calc(2.25rem + 2px);
    padding: 0.375rem 0.75rem;      
}

.select2-container .select2-selection__rendered {
    padding-left: 0.75rem;
    padding-right: 0.75rem;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 26px;
    position: absolute;
    top: 6px;
    right: 3px;
    width: 20px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 28px;
    margin-top: -2px;
    margin-left: -10px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    margin-left: 0px;
    margin-top: -1px;

}
</style>
