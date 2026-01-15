<form action="<?= base_url('admin/home_page/save') ?>" method="post" enctype="multipart/form-data">

    <label>Page Title</label>
    <input type="text" name="title" class="form-control mb-2" value="<?= isset($home->title) ? $home->title : '' ?>" required>


    <h3>Desire Place Tab</h3>
    <input type="text" name="tab_title" class="form-control mb-1" placeholder="Tab Title" value="<?= isset($home->tab_title) ? $home->tab_title : '' ?>"><br>
    <input type="text" name="tab_link" class="form-control mb-1" placeholder="Tab Link" value="<?= isset($home->tab_link) ? $home->tab_link : '' ?>"><br>

   
    <button type="button" id="add-desire" class="btn btn-primary mb-3">Add More Desire Place</button>
    <div id="desire-place-wrapper">
        <?php
        $desire_places = isset($home->desire_places) ? json_decode($home->desire_places,true) : [[]];
        foreach($desire_places as $d):
        ?>
        <div class="desire-place-item mb-3 border p-3">
            <label>Heading</label>
            <input type="text" name="desire_place_heading[]" class="form-control mb-1" value="<?= $d['heading'] ?? '' ?>">
            <label>Description</label>
            <textarea name="desire_place_description[]" class="form-control mb-1"><?= $d['description'] ?? '' ?></textarea>
            <label>Image Upload <small>(Max size: 2 MB)</small></label>
            <input type="file" name="desire_place_image[]" class="form-control mb-2">
            <?php if(!empty($d['image'])): ?>
                <img src="<?= base_url(''.$d['image']) ?>" width="100">
            <?php endif; ?>

            
            <input type="hidden" name="desire_place_image_hidden[]" value="<?= $d['image'] ?? '' ?>">
            <button type="button" class="btn btn-danger remove-desire">Remove</button>
        </div>
        <?php endforeach; ?>
    </div><br>


    <h3>Popular Packages</h3>
    <textarea name="popular_packages" id="popular_packages" class="form-control mb-3"><?= isset($home->popular_packages) ? $home->popular_packages : '' ?></textarea><br>
    

   <h3>Popular Packages Bottom Text</h3>
    <textarea name="popular_packages_bottom" id="popular_packages_bottom" class="form-control mb-3"><?= isset($home->popular_packages_bottom) ? $home->popular_packages_bottom : '' ?></textarea><br>

    <h3>Popular Activities</h3>
    <textarea name="popular_activies" id="popular_activies" class="form-control mb-3"><?= isset($home->popular_activies) ? $home->popular_activies : '' ?></textarea><br>

    <h3>Popular Activities Bottom Text</h3>
    <textarea name="popular_activies_bottom" id="popular_activies_bottom" class="form-control mb-3"><?= isset($home->popular_activies_bottom) ? $home->popular_activies_bottom : '' ?></textarea><br>


    <h3>Popular Blogs</h3>
    <textarea name="popular_blogs" id="popular_blogs" class="form-control mb-3"><?= isset($home->popular_blogs) ? $home->popular_blogs : '' ?></textarea><br>

    <h3>Popular Blogs Bottom Text</h3>
    <textarea name="popular_blogs_bottom" id="popular_blogs_bottom" class="form-control mb-3"><?= isset($home->popular_blogs_bottom) ? $home->popular_blogs_bottom : '' ?></textarea><br>


     <h3>Popular Visa</h3>
    <textarea name="popular_visa" id="popular_visa" class="form-control mb-3"><?= isset($home->popular_visa) ? $home->popular_visa : '' ?></textarea><br>
    
     <h3>Popular Visa Bottom Text</h3>
    <textarea name="popular_visa_bottom" id="popular_visa_bottom" class="form-control mb-3"><?= isset($home->popular_visa_bottom) ? $home->popular_visa_bottom : '' ?></textarea><br>


    <h3>Top Destination</h3>
    <input type="text" name="heading" class="form-control mb-1" placeholder="Heading" value="<?= isset($home->top_destination_heading) ? $home->top_destination_heading : '' ?>">
    <textarea name="top_destination_description" class="form-control mb-1"><?= isset($home->top_destination_description) ? $home->top_destination_description : '' ?></textarea><br><br><br>

    <button type="button" id="add-top" class="btn btn-primary mb-3">Add More Top Destination</button>
    <div id="top-destination-wrapper">
        <?php
        $top_destinations = isset($home->top_destinations) ? json_decode($home->top_destinations,true) : [[]];
        foreach($top_destinations as $t):
        ?>
        <div class="top-destination-item mb-3 border p-3">
            <label>Image Upload <small>(Max size: 2 MB)</small></label>
            <input type="file" name="top_destination_image[]" class="form-control mb-1">
            <?php if(!empty($t['image'])): ?>
                <img src="<?= base_url(''.$t['image']) ?>" width="100">
            <?php endif; ?>
            <label>Paragraph</label>
            <textarea name="top_destination_paragraph[]" class="form-control mb-2"><?= $t['paragraph'] ?? '' ?></textarea>
            <input type="hidden" name="top_destination_image_hidden[]" value="<?= $t['image'] ?? '' ?>">
            <button type="button" class="btn btn-danger remove-top">Remove</button>
        </div>
        <?php endforeach; ?>
    </div>


    <h6>Rating</h6>
   <input type="text" name="rating" class="form-control mb-3" 
       value="<?= isset($home->rating) ? htmlspecialchars($home->rating) : '' ?>" 
       placeholder="">



    <h3>Best Agency</h3>
   
    <textarea name="top_agency" id="top_agency" class="form-control mb-2"><?= isset($home->top_agency) ? $home->top_agency : '' ?></textarea><br>
   
      

    <label>Top Agency Image<small>(Max size: 4.88 MB)</small></label>
    <input type="file" name="top_agency_image" class="form-control mb-2">
    <?php if(!empty($home->top_agency_image)): ?>
        <img src="<?= base_url('uploads/home/best_agency/'.$home->top_agency_image) ?>" width="100">
    <?php endif; ?>

    <label>Top Agency Link</label>
    <input type="text" name="top_agency_link" class="form-control mb-2" value="<?= isset($home->top_agency_link) ? $home->top_agency_link : '' ?>">

    <button type="button" id="add-agency" class="btn btn-primary mb-3">Add More Best Agency</button>
    <div id="best-agency-wrapper">
        <?php
        $best_agencies = isset($home->best_agencies) ? json_decode($home->best_agencies,true) : [[]];
        foreach($best_agencies as $b):
        ?>
        <div class="best-agency-item mb-3 border p-3">
            <label>Heading</label>
            <input type="text" name="best_agency_heading[]" class="form-control mb-1" value="<?= $b['heading'] ?? '' ?>">
            <label>Paragraph</label>
            <textarea name="best_agency_paragraph[]" class="form-control mb-1"><?= $b['paragraph'] ?? '' ?></textarea>
            <label>Image Upload <small>(Max size: 2 MB)</small></label>
            <input type="file" name="best_agency_image[]" class="form-control mb-2">
            <?php if(!empty($b['image'])): ?>
                <img src="<?= base_url(''.$b['image']) ?>" width="100">
            <?php endif; ?>
            <input type="hidden" name="best_agency_image_hidden[]" value="<?= $b['image'] ?? '' ?>">
            <button type="button" class="btn btn-danger remove-agency">Remove</button>
        </div>
        <?php endforeach; ?>
    </div>


    <h5>Tour guided Section</h5>
    <textarea name="final_editor" id="final_editor" class="form-control mb-2"><?= isset($home->final_editor) ? $home->final_editor : '' ?></textarea><br>


    
    <h5>Testimonial Section</h5>
    <textarea name="testimonial_section" id="testimonial_section" class="form-control mb-2"><?= isset($home->testimonial_section) ? $home->testimonial_section : '' ?></textarea><br>
    <input type="text" name="final_link" class="form-control mb-1" placeholder="Link" value="<?= isset($home->final_link) ? $home->final_link : '' ?>"><br>
    <textarea name="final_paragraph" class="form-control mb-1" placeholder="Paragraph"><?= isset($home->final_paragraph) ? $home->final_paragraph : '' ?></textarea>


    <?php if(isset($home->id)): ?>
        <input type="hidden" name="id" value="<?= $home->id ?>">
    <?php endif; ?>

    <button type="submit" class="btn btn-success mt-3">Save Home Page</button>
</form>

<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#popular_packages')).catch(err => console.error(err));
ClassicEditor.create(document.querySelector('#final_editor')).catch(err => console.error(err));
ClassicEditor.create(document.querySelector('#top_agency')).catch(err => console.error(err));
ClassicEditor.create(document.querySelector('#testimonial_section')).catch(err => console.error(err));
ClassicEditor.create(document.querySelector('#popular_visa')).catch(err => console.error(err));
ClassicEditor.create(document.querySelector('#popular_blogs')).catch(err => console.error(err));
ClassicEditor.create(document.querySelector('#popular_activies')).catch(err => console.error(err));
ClassicEditor.create(document.querySelector('#popular_packages_bottom')).catch(err => console.error(err));
ClassicEditor.create(document.querySelector('#popular_activies_bottom')).catch(err => console.error(err));
ClassicEditor.create(document.querySelector('#popular_blogs_bottom')).catch(err => console.error(err));
ClassicEditor.create(document.querySelector('#popular_visa_bottom')).catch(err => console.error(err));


</script>

<script>
document.getElementById('add-desire').addEventListener('click', function(){
    let wrapper = document.getElementById('desire-place-wrapper');
    let html = `
    <div class="desire-place-item mb-3 border p-3">
        <label>Heading</label>
        <input type="text" name="desire_place_heading[]" class="form-control mb-1">
        <label>Description</label>
        <textarea name="desire_place_description[]" class="form-control mb-1"></textarea>
        <label>Image Upload</label>
        <input type="file" name="desire_place_image[]" class="form-control mb-2">
        <button type="button" class="btn btn-danger remove-desire">Remove</button>
    </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
});

document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-desire')){
        e.target.closest('.desire-place-item').remove();
    }
});


document.getElementById('add-top').addEventListener('click', function(){
    let wrapper = document.getElementById('top-destination-wrapper');
    let html = `
    <div class="top-destination-item mb-3 border p-3">
        <label>Image Upload</label>
        <input type="file" name="top_destination_image[]" class="form-control mb-1">
        <label>Paragraph</label>
        <textarea name="top_destination_paragraph[]" class="form-control mb-2"></textarea>
        <button type="button" class="btn btn-danger remove-top">Remove</button>
    </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
});

document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-top')){
        e.target.closest('.top-destination-item').remove();
    }
});

document.getElementById('add-agency').addEventListener('click', function(){
    let wrapper = document.getElementById('best-agency-wrapper');
    let html = `
    <div class="best-agency-item mb-3 border p-3">
        <label>Heading</label>
        <input type="text" name="best_agency_heading[]" class="form-control mb-1">
        <label>Paragraph</label>
        <textarea name="best_agency_paragraph[]" class="form-control mb-1"></textarea>
        <label>Image Upload</label>
        <input type="file" name="best_agency_image[]" class="form-control mb-2">
        <button type="button" class="btn btn-danger remove-agency">Remove</button>
    </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
});

document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-agency')){
        e.target.closest('.best-agency-item').remove();
    }
});
</script>
