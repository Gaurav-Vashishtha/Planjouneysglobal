<?php
// echo "working"; die;
?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><?= isset($package) ? 'Edit Visa Package' : 'Add Visa Package' ?></h5>
    </div>

    <div class="card-body">
        <form action="<?= isset($package) ? base_url('admin/visa_package/update/'.$package->id) : base_url('admin/visa_package/save') ?>" method="post" enctype="multipart/form-data">
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Heading <span class="text-danger">*</span></label>
                    <input type="text" name="heading" class="form-control" value="<?= $package->heading ?? '' ?>" required>
                </div>



                <div class="col-md-6 mb-3">
                    <label class="form-label">Agency Heading <span class="text-danger"></span></label>
                    <input type="text" name="agencyheading" class="form-control" value="<?= $package->agency_heading ?? '' ?>" >
                </div>
                
                <div class=" mb-3">
                    <label class="form-label">Meta Title <span class="text-danger"></span></label>
                    <input type="text" name="meta_title" class="form-control" value="<?= $package->meta_title ?? '' ?>" >
                </div>

                 <div class=" mb-3">
                    <label class="form-label">Meta Description <span class="text-danger"></span></label>
                    <input type="text" name="meta_description" class="form-control" value="<?= $package->meta_description ?? '' ?>" >
                </div>

                <h6 class="mt-3">Visa Agency Tab</h6>
                <button type="button" id="add-visa-agency" class="btn btn-primary mb-3">Add More</button>
                <div id="visa-agency-wrapper">
                    <?php 
                    $agencies = isset($package->visa_agencies) ? json_decode($package->visa_agencies, true) : [[]];
                    foreach ($agencies as $a): ?>
                        <div class="visa-agency-item mb-3 border p-3">
                            <label>Title <span class="text-danger"></span></label>
                            <input type="text" name="agency_title[]" class="form-control mb-2" value="<?= $a['title'] ?? '' ?>" >

                            <label>Description <span class="text-danger"></span></label>
                            <input type="text" name="agency_description[]" class="form-control mb-2" value="<?= $a['description'] ?? '' ?>" >

                            <label>Image</label>
                            <input type="file" name="agency_image[]" class="form-control mb-2">
                           <?php if(!empty($a['image'])): ?>
                            <img src="<?= base_url($a['image']) ?>" width="100" class="mt-2">
                            <input type="hidden" name="agency_image_hidden[]" value="<?= $a['image'] ?>">
                        <?php else: ?>
                            <input type="hidden" name="agency_image_hidden[]" value="">
                        <?php endif; ?>


                            <button type="button" class="btn btn-danger remove-agency mt-2">Remove</button>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Sub Title <span class="text-danger"></span></label>
                    <textarea name="sub_title" class="form-control" id="sub_title"  rows="4"><?= $package->sub_title ?? '' ?></textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Link <span class="text-danger"></span></label>
                    <input type="text" name="link" class="form-control" value="<?= $package->link ?? '' ?>" >
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Image 2</label>
                   <input type="file" name="image_2" class="form-control" accept="image/">
                    <?php if(!empty($package->image_2)): ?>
                        <img src="<?= base_url($package->image_2) ?>" width="120" class="mt-2">
                        <input type="hidden" name="image_2_hidden" value="<?= $package->image_2 ?>">
                    <?php endif; ?>

                </div>

                

                 <div class="col-12 mb-3">
                    <label class="form-label">Wroking Process(Heading)<span class="text-danger"></span></label>
                    <textarea name="working_process_head" class="form-control" id="working_process_head"  rows="4"><?= $package->working_process_head ?? '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Working Process Link <span class="text-danger"></span></label>
                    <input type="text" name="working_process_link" class="form-control" value="<?= $package->working_process_link ?? '' ?>" >
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Working Process Mail <span class="text-danger"></span></label>
                    <input type="text" name="working_process_mail" class="form-control" value="<?= $package->working_process_mail ?? '' ?>" >
                </div>

                <button type="button" id="add-process" class="btn btn-primary mb-3">Add More</button>
                <div id="visa--wrapper">
                    <?php 
                    $processes = isset($package->working_process) ? json_decode($package->working_process, true) : [[]];
                    foreach ($processes as $p): ?>
                        <div class="working-process-item mb-3 border p-3">
                            <label>Title <span class="text-danger"></span></label>
                            <input type="text" name="process_title[]" class="form-control mb-2" value="<?= $p['title'] ?? '' ?>" >

                            <label>Description <span class="text-danger"></span></label>
                            <input type="text" name="process_description[]" class="form-control mb-2" value="<?= $p['description'] ?? '' ?>" >

                            <button type="button" class="btn btn-danger remove-process mt-2">Remove</button>
                        </div>
                    <?php endforeach; ?>
                </div>

                <h4>Frequently Asked Questions (FAQ)</h4>
                <button type="button" id="addFaqBtn" class="btn btn-primary mb-3">+ Add FAQ</button>
                <div id="faqContainer">
                    <?php 
                    $faqs = isset($package->faq) ? json_decode($package->faq, true) : [[]];
                    foreach ($faqs as $f): ?>
                        <div class="faqItem border p-3 mb-3">
                            <label>Question</label>
                            <textarea name="faq_question[]" class="form-control mb-2"><?= $f['question'] ?? '' ?></textarea>

                            <label>Answer</label>
                            <textarea name="faq_answer[]" class="form-control mb-2"><?= $f['answer'] ?? '' ?></textarea>

                            <button type="button" class="btn btn-danger removeFaq">Remove</button>
                        </div>
                    <?php endforeach; ?>
                </div>

            

            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="<?= base_url('admin/visapackage'); ?>" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>



<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#sub_title')).catch(err => console.error(err));
ClassicEditor.create(document.querySelector('#working_process_head')).catch(err => console.error(err));

</script>
<script>
document.getElementById('add-visa-agency').addEventListener('click', function () {
    let wrapper = document.getElementById('visa-agency-wrapper');
   let html = `
    <div class="visa-agency-item mb-3 border p-3">
        <label>Title <span class="text-danger"></span></label>
        <input type="text" name="agency_title[]" class="form-control mb-2" >

        <label>Description <span class="text-danger"></span></label>
        <input type="text" name="agency_description[]" class="form-control mb-2" >

        <label>Image</label>
        <input type="file" name="agency_image[]" class="form-control mb-2">

        <input type="hidden" name="agency_image_hidden[]" value="">

        <button type="button" class="btn btn-danger remove-agency mt-2">Remove</button>
    </div>`;

    wrapper.insertAdjacentHTML('beforeend', html);
});
document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-agency')){
        e.target.closest('.visa-agency-item').remove();
    }
});

document.getElementById('add-process').addEventListener('click', function () {
    let wrapper = document.getElementById('visa--wrapper');
    let html = `
        <div class="working-process-item mb-3 border p-3">
            <label>Title <span class="text-danger"></span></label>
            <input type="text" name="process_title[]" class="form-control mb-2" >
            <label>Description <span class="text-danger"></span></label>
            <input type="text" name="process_description[]" class="form-control mb-2" >
            <button type="button" class="btn btn-danger remove-process mt-2">Remove</button>
        </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
});
document.addEventListener('click', function(e){
    if(e.target.classList.contains('remove-process')){
        e.target.closest('.working-process-item').remove();
    }
});

document.getElementById('addFaqBtn').addEventListener('click', function () {
    let wrapper = document.getElementById('faqContainer');
    let html = `
        <div class="faqItem border p-3 mb-3">
            <label>Question</label>
            <textarea name="faq_question[]" class="form-control mb-2"></textarea>
            <label>Answer</label>
            <textarea name="faq_answer[]" class="form-control mb-2"></textarea>
            <button type="button" class="btn btn-danger removeFaq">Remove</button>
        </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
});
document.addEventListener('click', function(e){
    if(e.target.classList.contains('removeFaq')){
        e.target.closest('.faqItem').remove();
    }
});
</script>
    