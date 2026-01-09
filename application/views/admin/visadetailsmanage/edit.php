<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Visa Details</h5>
    </div>

    <div class="card-body">

        <form action="<?= base_url('admin/visadetails/update/'.$visa->id); ?>" method="post" enctype="multipart/form-data">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Country Name <span class="text-danger">*</span></label>
                    <input type="text" name="country_name" class="form-control" required value="<?= htmlspecialchars($visa->country_name); ?>">
                </div>

              
                <div class="col-md-6 mb-3">
                    <label class="form-label">Processing Time <span class="text-danger">*</span></label>
                    <input type="text" name="processing_time" class="form-control" required value="<?= htmlspecialchars($visa->processing_time); ?>">
                </div>

                 <div class="mb-3">
                    <label class="form-label">Meta Title <span class="text-danger">*</span></label>
                    <input type="text" name="meta_title" class="form-control" required value="<?= htmlspecialchars($visa->meta_title); ?>">
                </div>
 
                 <div class="mb-3">
                    <label class="form-label">Meta Description <span class="text-danger">*</span></label>
                    <input type="text" name="meta_description" class="form-control" required value="<?= htmlspecialchars($visa->meta_description); ?>">
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label">Banner Image <small>(Max size: 2 MB)</small></label>
                    <input type="file" name="banner_image" class="form-control" accept="image/*">
                    <input type="hidden" name="banner_image_hidden" value="<?= $visa->banner_image; ?>">
                    <?php if(!empty($visa->banner_image)): ?>
                        <img src="<?= base_url($visa->banner_image); ?>" width="100" class="mt-2">
                    <?php endif; ?>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Image <small>(Max size: 2 MB)</small></label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <input type="hidden" name="image_hidden" value="<?= $visa->image; ?>">
                    <?php if(!empty($visa->image)): ?>
                        <img src="<?= base_url($visa->image); ?>" width="100" class="mt-2">
                    <?php endif; ?>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Document Required <span class="text-danger">*</span></label>
                    <textarea name="document_requirement" class="form-control" rows="4" required><?= $visa->document_requirement; ?></textarea>
                </div>

          
                <div class="col-12 mb-3">
                    <label class="form-label">Plan Journeys’s Visa Experts</label>
                    <textarea name="additional_requirement" class="form-control" rows="4"><?= $visa->additional_requirement; ?></textarea>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label">Special Note</label>
                    <textarea name="important_note" class="form-control" rows="4"><?= $visa->important_note; ?></textarea>
                </div>
                <hr>
                <h4>Frequently Asked Questions (FAQ)</h4>

                <div id="faqContainer">
                    <?php
                    $faqs = isset($visa->faq) ? json_decode($visa->faq, true) : [];

                    if (!empty($faqs)):
                        foreach ($faqs as $faq):
                    ?>
                            <div class="faqItem border p-3 mb-3">
                                <label>Question</label>
                                <textarea name="faq_question[]" class="form-control mb-2"><?= isset($faq['question']) ? $faq['question'] : '' ?></textarea>

                                <label>Answer</label>
                                <textarea name="faq_answer[]" class="form-control mb-2"><?= isset($faq['answer']) ? $faq['answer'] : '' ?></textarea>

                                <button type="button" class="btn btn-danger removeFaq">Remove</button>
                            </div>
                    <?php
                        endforeach;
                    else:
                    ?>
                        <div class="faqItem border p-3 mb-3">
                            <label>Question</label>
                            <textarea name="faq_question[]" class="form-control mb-2"></textarea>

                            <label>Answer</label>
                            <textarea name="faq_answer[]" class="form-control mb-2"></textarea>

                            <button type="button" class="btn btn-danger removeFaq">Remove</button>
                        </div>
                    <?php endif; ?>
                </div>
        
                <button type="button" id="addFaq" class="btn btn-primary mb-3">+ Add FAQ</button>
            </div>

            <div class = "row">
                  <div class="col-md-6 mb-3">
                    <input type="checkbox" name="status" value="1" <?= $visa->status == 1 ? 'checked' : ''; ?> id="statusCheckbox">
                    <label for="statusCheckbox"> Active</label>
                </div>
                 <div class="col-md-6 mb-3">
                    <input type="checkbox" name="popular" value="1" <?= $visa->popular == 1 ? 'checked' : ''; ?> id="popularCheckbox">
                    <label for="popularCheckbox"> Popular</label>
                 </div>
              </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= base_url('admin/visadetails'); ?>" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>


<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
CKEDITOR.replace('document_requirement');
CKEDITOR.replace('additional_requirement');
CKEDITOR.replace('conditional_requirement');
CKEDITOR.replace('important_note');
CKEDITOR.replace('visa_rejection_reasons');


</script>

<script>
$("#addFaq").click(function() {
    let html = `
    <div class="faqItem border p-3 mb-3">
        <label>Question</label>
        <textarea name="faq_question[]" class="form-control mb-2"></textarea>

        <label>Answer</label>
        <textarea name="faq_answer[]" class="form-control mb-2"></textarea>

        <button type="button" class="btn btn-danger removeFaq">Remove</button>
    </div>`;

    $("#faqContainer").append(html);
});

$(document).on("click", ".removeFaq", function() {
    $(this).closest(".faqItem").remove();
});

</script>

