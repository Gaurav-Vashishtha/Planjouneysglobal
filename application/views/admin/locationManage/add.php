<form action="<?= base_url('admin/location/add') ?>" method="post" enctype="multipart/form-data">

    <div class="row"> 
        <div class="col-md-4 mb-3">
            <label class="form-label">Category <span class="text-danger">*</span></label>
            <select name="category" class="form-select" required>
                <option value="">Select Category</option>
                <option value="domestic" <?= set_select('category','domestic'); ?>>Domestic</option>
                <option value="europe" <?= set_select('category','europe'); ?>>Europe</option>
                <option value="asia" <?= set_select('category','asia'); ?>>Asia</option>
                <option value="africa" <?= set_select('category','africa'); ?>>Africa</option>
                <option value="oceania" <?= set_select('category','oceania'); ?>>Oceania</option>
                <option value="middle_east" <?= set_select('category','middle_east'); ?>>Middle East</option>
                <option value="north_america" <?= set_select('category','north_america'); ?>>North America</option>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Location Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="location_name" class="form-control" value="<?= set_value('name'); ?>" required>
            <?= form_error('name'); ?>
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Location Icon</label>
            <input type="file" name="location_icon" class="form-control" accept=".jpg,.jpeg,.png,.webp">
            <?php if(isset($location->location_icon) && $location->location_icon): ?>
                <img src="<?= base_url('uploads/location/'.$location->location_icon) ?>" alt="Icon" style="height:50px;margin-top:10px;">
            <?php endif; ?>
        </div>

    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Language</label>
            <input type="text" name="language" class="form-control" value="<?= set_value('language'); ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Capital</label>
            <input type="text" name="capital" class="form-control" value="<?= set_value('capital'); ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Currency</label>
            <input type="text" name="currency" class="form-control" value="<?= set_value('currency'); ?>">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Main Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Gallery Images (multiple)</label>
            <input type="file" name="gallery[]" class="form-control" multiple>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Upload Video</label>
        <input type="file" name="video" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control"><?= set_value('description'); ?></textarea>
    </div>

    <h4>Best Time to Visit</h4>
    <div id="bestTimeContainer">
        <div class="bestTimeItem border p-3 mb-3">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Season</label>
                    <input type="text" name="best_time[season][]" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Weather</label>
                    <input type="text" name="best_time[weather][]" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Image</label>
                    <input type="file" name="best_time_image[]" class="form-control">
                </div>
               
                <div class="col-md-6 mb-3">
                    <label>Perfect For</label>
                    <input type="text" name="best_time[perfect_for][]" class="form-control">
                </div>
                 <div class="col-md-6 mb-3">
                    <label>Highlights</label>
                    <textarea name="best_time[highlights][]" class="form-control editor"></textarea>
                </div>
                <button type="button" class="btn btn-danger removeBestTime">Remove</button>
            </div>
        </div>
    </div>
    <button type="button" id="addBestTime" class="btn btn-primary mb-3">+ Add More</button>

    <hr>
    <h4>Frequently Asked Questions (FAQ)</h4>
    <div id="faqContainer">
        <div class="faqItem border p-3 mb-3">
            <label>Question</label>
            <textarea name="faq_question[]" class="form-control editor mb-2"></textarea>
            <label>Answer</label>
            <textarea name="faq_answer[]" class="form-control editor mb-2"></textarea>
            <button type="button" class="btn btn-danger removeFaq">Remove</button>
        </div>
    </div>
    <button type="button" id="addFaq" class="btn btn-primary mb-3">+ Add FAQ</button>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Markup (₹ or %)</label>
            <input type="text" name="markup" value="<?= set_value('markup', isset($location->markup) ? $location->markup : '0'); ?>" class="form-control" placeholder="Ex: 500 or 10%">
        </div>
    </div>

    <div class="form-check mb-3">
        <input type="checkbox" name="status" class="form-check-input" id="status" value="1" <?= set_checkbox('status','1'); ?>>
        <label class="form-check-label" for="status">Active</label>
    </div>
       <div class="form-check mb-3">
        <input type="checkbox" name="top_destination" class="form-check-input" id="top_destination" value="1" <?= set_checkbox('top_destination','1'); ?>>
        <label class="form-check-label" for="top_destination">Top Destination</label>
    </div>
    <div class="form-check mb-3">
        <input type="checkbox" name="popular" class="form-check-input" id="top_destination" value="1" <?= set_checkbox('popular','1'); ?>>
        <label class="form-check-label" for="top_destination">Popular Location</label>
    </div>
    <button type="submit" class="btn btn-success">Add Location</button>
    <a href="<?= base_url('admin/location'); ?>" class="btn btn-secondary">Cancel</a>
</form>


<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
function initEditor(textarea){
    ClassicEditor.create(textarea).catch(error => { console.error(error); });
}

// Init editors for existing fields
initEditor(document.querySelector('#description'));
document.querySelectorAll('textarea.editor').forEach(initEditor);

// Add more Best Time
$("#addBestTime").click(function(){
    let html = `<div class="bestTimeItem border p-3 mb-3">
        <div class="row">
            <div class="col-md-4 mb-3"><label>Season</label><input type="text" name="best_time[season][]" class="form-control"></div>
            <div class="col-md-4 mb-3"><label>Weather</label><input type="text" name="best_time[weather][]" class="form-control"></div>
            <div class="col-md-4 mb-3"><label>Image</label><input type="file" name="best_time_image[]" class="form-control"></div>
            <div class="col-md-6 mb-3"><label>Highlights</label><textarea name="best_time[highlights][]" class="form-control editor"></textarea></div>
            <div class="col-md-6 mb-3"><label>Perfect For</label><input type="text" name="best_time[perfect_for][]" class="form-control"></div>
            <button type="button" class="btn btn-danger removeBestTime">Remove</button>
        </div>
    </div>`;
    $("#bestTimeContainer").append(html);
    initEditor($("#bestTimeContainer").find('textarea.editor').last()[0]);
});
$(document).on("click",".removeBestTime",function(){ $(this).closest(".bestTimeItem").remove(); });


$("#addFaq").click(function(){
    let html = `<div class="faqItem border p-3 mb-3">
        <label>Question</label><textarea name="faq_question[]" class="form-control editor mb-2"></textarea>
        <label>Answer</label><textarea name="faq_answer[]" class="form-control editor mb-2"></textarea>
        <button type="button" class="btn btn-danger removeFaq">Remove</button>
    </div>`;
    $("#faqContainer").append(html);
    let items = $("#faqContainer .faqItem");
    initEditor(items.last().find('textarea')[0]); 
    initEditor(items.last().find('textarea')[1]); 
});
$(document).on("click",".removeFaq",function(){ $(this).closest(".faqItem").remove(); });
</script>
