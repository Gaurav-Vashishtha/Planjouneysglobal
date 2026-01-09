<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add Visa Details</h5>
    </div>

    <div class="card-body">

        <form action="<?= base_url('admin/visadetails/save_add'); ?>" method="post" enctype="multipart/form-data">

            <div class="row">

                                                                                                                                                                                                            
                <div class="col-md-6 mb-3">
                    <label class="form-label">Country Name <span class="text-danger">*</span></label>
                    <input type="text" name="country_name" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Processing Time <span class="text-danger">*</span></label>
                    <input type="text" name="processing_time" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Meta Title <span class="text-danger"></span></label>
                    <input type="text" name="meta_title" class="form-control" >
                </div>

                <div class="mb-3">
                    <label class="form-label">Meta Description<span class="text-danger"></span></label>
                    <input type="text" name="meta_description" class="form-control" >
                </div>

                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Banner Image <small>(Max size: 2 MB)</small></label>
                    <input type="file" name="banner_image" class="form-control" accept="image/*">
                </div>

              
                <div class="col-md-6 mb-3">
                    <label class="form-label">Image <small>(Max size: 2 MB)</small></label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
          
                <div class="col-12 mb-3">
                    <label class="form-label">Document Required <span class="text-danger">*</span></label>
                    <textarea name="document_requirement" class="form-control" rows="4" required></textarea>
                </div>

                
                <div class="col-12 mb-3">
                    <label class="form-label">Plan Journeys’s Visa Experts</label>
                    <textarea name="additional_requirement" class="form-control" rows="4"></textarea>
                </div>

                
                <div class="col-12 mb-3">
                    <label class="form-label">Special Note</label>
                    <textarea name="important_note" class="form-control" rows="4"></textarea>
                </div>

                <hr>
                <h4>Frequently Asked Questions (FAQ)</h4>
                <div id="faqContainer">
                <div class="faqItem border p-3 mb-3">
                    <label>Question</label>
                    <textarea name="faq_question[]" class="form-control mb-2"></textarea>

                    <label>Answer</label>
                    <textarea name="faq_answer[]" class="form-control mb-2"></textarea>

                    <button type="button" class="btn btn-danger removeFaq">Remove</button>
                </div>

            
            </div>
            <button type="button" id="addFaq" class="btn btn-primary mb-3">+ Add FAQ</button>
            </div>

                <div class = "row">
                    <div class= "col-md-6 mb-3">
                    <input type="checkbox" name="status" value="1" id="statusCheckbox">
                    <label for="statusCheckbox"> Active</label>
                    </div>

                     <div class= "col-md-6 mb-3">       
                    <input type="checkbox" name="popular" value="1" id="popularCheckbox">
                    <label for="popularCheckbox"> Popular</label>
                    </div>
                </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="<?= base_url('admin/visadetails'); ?>" class="btn btn-secondary">Back</a>

        </form>

    </div>
</div>






<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
CKEDITOR.replace('document_requirement');
CKEDITOR.replace('additional_requirement');
CKEDITOR.replace('important_note');

</script>

<script>
$("#addFaq").click(function () {

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


$(document).on("click", ".removeFaq", function () {
    $(this).closest(".faqItem").remove();
});
</script>



