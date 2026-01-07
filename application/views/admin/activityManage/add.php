<h6 class="d-flex justify-content-between align-items-center">
    <?php echo $title; ?>
    <div class="steps-links">
        <a href="javascript:void(0)" class="step-link active" data-step="1">Step 1</a> |
        <a href="javascript:void(0)" class="step-link disabled" data-step="2">Step 2</a> |
        <a href="javascript:void(0)" class="step-link disabled" data-step="3">Step 3</a>
    </div>
</h6>

<?php echo form_open_multipart('admin/activities/create'); ?>

<!-- STEP 1 -->
<div id="step1" class="step-card">
    <div class="row">
        <div class="col-md-3 mb-3">
            <label class="form-label">Category <span class="text-danger">*</span></label>
            <select name="category" class="form-select" id="category" >
                <option value="">Select Category</option>
                <option value="domestic">Domestic</option>
                <option value="europe">Europe</option>
                <option value="asia">Asia</option>
                <option value="africa">Africa</option>
                <option value="oceania">Oceania</option>
                <option value="middle_east">Middle East</option>
                <option value="north_america">North America</option>
                
            </select>
    </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Location <span class="text-danger"></span></label>
            <select name="location_id" id="location_id" class="form-select" >
                <option value="">Select Location</option>
            </select>
        </div>

        <div class="col-md-3 mb-3">
            <label class="form-label">Activity Category <span class="text-danger"></span></label>
            <select name="category_activity" id="category_activity" class="form-select">
                <option value="">Select Activity Category</option>
                <?php foreach($activity_categories as $cat): ?>
                    <option value="<?= $cat->id ?>">
                        <?= $cat->category_name ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
   
        <div class="col-md-3 mb-3">
    <label class="form-label">Activities <span class="text-danger"></span></label>
    <select name="activities[]" id="activities" class="form-select select2" multiple>


        <option value="">Select Activities</option>
    </select>
</div>
    
      </div>  
    <div class="mb-3">
        <label class="form-label">Title <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control"  value="<?php echo set_value('title'); ?>">
        <?php echo form_error('title'); ?>
    </div>

    <div class="mb-3">
        <label class="form-label">Meta Title</label>
        <textarea name="meta_title" class="form-control" rows="1"><?php echo set_value('meta_title'); ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Short Description</label>
        <input type="text" name="short_description" class="form-control" value="<?php echo set_value('short_description'); ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" rows="4"><?php echo set_value('description'); ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Meta Description</label>
        <textarea name="meta_description" id="meta_description" class="form-control" rows="4"><?php echo set_value('meta_description'); ?></textarea>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo set_value('price','0.00'); ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Image <small>(Max size: 2 MB, 1800*900)</small></label>
            <input type="file" name="image" class="form-control">
        </div>
    </div>


    <div class="row">

    <div class="col-md-4 mb-3">
        <label class="form-label">Accommodation <span class="text-danger"></span></label>
        <select name="accommodation" class="form-select" >
            <option value="">Select Accommodation</option>
            <option value="5 Star Hotel">5 Star Hotel</option>
            <option value="4 Star Hotel">4 Star Hotel</option>
            <option value="Resort">Resort</option>
            <option value="Villa">Villa</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Meals</label>
        <select name="meals" class="form-select">
            <option value="">Select Meal Plan</option>
            <option value="Breakfast Only">Breakfast Only</option>
            <option value="Breakfast & Dinner">Breakfast & Dinner</option>
            <option value="All Meals">All Meals</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Transportation</label>
        <select name="transportation" class="form-select">
            <option value="">Select Transportation</option>
            <option value="Taxi">Taxi</option>
            <option value="Car">Car</option>
            <option value="Bus">Bus</option>
        </select>
    </div>

</div>

<div class="row">

    <div class="col-md-4 mb-3">
        <label class="form-label">Group Size</label>
        <select name="group_size" class="form-select">
            <option value="">Select Group Size</option>
            <option value="1-10">1–10</option>
            <option value="10-20">10–20</option>
            <option value="20-40">20–40</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Language</label>
        <select name="language[]" class="form-select select2" multiple>
            <option value="English">English</option>
            <option value="Spanish">Spanish</option>
            <option value="French">French</option>
            <option value="German">German</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Animal</label>
        <select name="animal" class="form-select">
            <option value="">Select Animal</option>
            <option value="Cat">Cat</option>
            <option value="Dog">Dog</option>
            <option value="Pet Only">Pet Only</option>
        </select>
    </div>

</div>

<div class="row">

    <div class="col-md-4 mb-3">
        <label class="form-label">Age Range</label>
        <select name="age_range" class="form-select">
            <option value="">Select Age Range</option>
            <option value="18-45">18–45</option>
            <option value="18-55">18–55</option>
            <option value="All Ages">All Ages</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Season</label>
        <select name="season" class="form-select">
            <option value="">Select Season</option>
            <option value="Winter Season">Winter Season</option>
            <option value="Summer Season">Summer Season</option>
            <option value="Rainy Season">Rainy Season</option>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Activity Type <span class="text-danger"></span></label>
        <select name="activity_type" class="form-select" >
            <option value="">Select Category</option>
            <option value="Adventure">Adventure</option>
            <option value="Family">Family</option>
            <option value="Honeymoon">Honeymoon</option>
            <option value="Luxury">Luxury</option>
        </select>
    </div>

</div>
  <div class="row">
    <div class="col-md-6 mb-3 form-check">
        <input type="checkbox" name="status" class="form-check-input" id="status" value="1" <?php echo set_checkbox('status','1'); ?>>
        <label class="form-check-label" for="status">Active</label>
    </div>
    <div class="col-md-6 mb-3 form-check">
        <input type="checkbox" name="popular" class="form-check-input" id="popular" value="1" <?php echo set_checkbox('popular','1'); ?>>
        <label class="form-check-label" for="popular">Popular</label>
    </div>
  </div>
    <div class="text-end">
        <button type="button" class="btn btn-primary next-step" data-next="2">Next →</button>
    </div>
</div>

<!-- STEP 2 -->
<div id="step2" class="step-card d-none">


    <div class="form-group mb-3">
        <label>Highlights of Activity</label>
        <textarea name="highlights_of_activity" id="highlights_of_tours" class="form-control" rows="4"><?php echo set_value('highlights_of_activity'); ?></textarea>
    </div>

    <div class="form-group mb-3">
        <label>Additional Info</label>
        <textarea name="additional_info" id="additional_info" class="form-control" rows="4"><?php echo set_value('additional_info'); ?></textarea>
    </div>
   <div class="form-group mb-3">
        <label>Activity Overview</label>
        <textarea name="activity_overview" id="note" class="form-control" rows="4"><?php echo set_value('activity_overview'); ?></textarea>
    </div>
    <div class="text-end">
        <button type="button" class="btn btn-secondary prev-step" data-prev="1">← Previous</button>
        <button type="button" class="btn btn-primary next-step" data-next="3">Next →</button>
    </div>
</div>

<!-- STEP 3 -->
<div id="step3" class="step-card d-none">
    <div class="form-group mb-3">
        <label>Inclusion</label>
        <textarea name="inclusion" id="inclusion" class="form-control" rows="4"><?php echo set_value('inclusion'); ?></textarea>
    </div>
    <div class="form-group mb-3">
        <label>Exclusion</label>
        <textarea name="exclusion" id="exclusion" class="form-control" rows="4"><?php echo set_value('exclusion'); ?></textarea>
    </div>
    <div class="form-group mb-3">
        <label>Additional Charge</label>
        <textarea name="addtional_charge" id="addtional_charge" class="form-control" rows="4"><?php echo set_value('addtional_charge'); ?></textarea>
    </div>
    
    <div class="text-end">
        <button type="button" class="btn btn-secondary prev-step" data-prev="2">← Previous</button>
        <button type="submit" class="btn btn-success">Save activities</button>
    </div>
</div>

<?php echo form_close(); ?>

<!-- JS + Styles -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editors = ['description','day_details','highlights_of_tours','additional_info','inclusion','exclusion','addtional_charge','note'];
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
        document.querySelector('.step-link[data-step="'+step+'"]').classList.add('active');
    }

    document.querySelectorAll('.next-step').forEach(btn => {
        btn.addEventListener('click', () => {
            const step = btn.dataset.next;
            showStep(step);
            document.querySelector('.step-link[data-step="'+step+'"]').classList.remove('disabled');
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
});
$(document).ready(function() {
    $('.select2').select2();
});

</script>

<script>
    $(document).on('change', '#category', function () {
    let category = $(this).val();

    $("#location_id").html('<option value="">Loading...</option>');

    if (category !== '') {

        $.ajax({
            url: "<?= base_url('admin/activities/get_location/'); ?>" + category,
            type: "GET",
            dataType: "json",
            success: function (res) {
                $("#location_id").html('<option value="">Select Location</option>');

                if (res.length > 0) {
                    $.each(res, function (i, loc) {
                        $("#location_id").append(
                            `<option value="${loc.id}">${loc.name}</option>`
                        );
                    });
                } else {
                    $("#location_id").html('<option value="">No Locations Found</option>');
                }
            }
        });
    }
});


$(document).ready(function() {
    $('#category_activity').on('change', function() {
        var category_id = $(this).val();
        var $activities = $('#activities');
        $activities.html('<option value="">Loading...</option>');

        if(category_id) {
            $.ajax({
                url: '<?= base_url("admin/activities/get_activities_by_category/") ?>' + category_id,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    $activities.empty();
                    if(res.length > 0) {
                        $.each(res, function(i, activity) {
                            $activities.append('<option value="'+activity.id+'">'+activity.activity_name+'</option>');
                        });
                    } else {
                        $activities.append('<option value="">No activities found</option>');
                    }
                }
            });
        } else {
            $activities.html('<option value="">Select Activities</option>');
        }
    });
});
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Select Activities"
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
</style>


