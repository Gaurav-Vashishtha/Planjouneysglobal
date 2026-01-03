<h4><?php echo $title; ?></h4>

<?php echo form_open_multipart(isset($hotels) ? 'admin/hotels/edit/'.$hotels->id : 'admin/hotels/create'); ?>

<div class="row">

    <div class="col-md-4 mb-3">
        <label class="form-label">Hotel Type <span class="text-danger">*</span></label>
        <select name="hotel_type" class="form-select">
            <option value="">-- Select Type --</option>
            <option value="domestic" <?php echo set_select('hotel_type','domestic', (isset($hotels) && $hotels->hotel_type=='domestic')); ?>>Domestic</option>
            <option value="international" <?php echo set_select('hotel_type','international', (isset($hotels) && $hotels->hotel_type=='international')); ?>>International</option>
        </select>
        <?php echo form_error('hotel_type'); ?>
    </div>

       <div class="col-md-4 mb-3">
        <label class="form-label">Location <span class="text-danger">*</span></label>
        <select name="location_id" class="form-select" required>
            <option value="">Select Location</option>
            <?php if(!empty($locations)): ?>
                <?php foreach($locations as $loc): ?>
                    <option value="<?php echo $loc->id; ?>"
                        <?php 
                           
                            echo set_select('location_id', $loc->id, 
                                (isset($hotels->location_id) && $hotels->location_id == $loc->id)
                            ); 
                        ?>>
                        <?php echo ucfirst($loc->name); ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Hotel Name <span class="text-danger">*</span></label>
        <input type="text" name="hotel_name" class="form-control" value="<?php echo set_value('hotel_name', $hotels->hotel_name ?? ''); ?>">
        <?php echo form_error('hotel_name'); ?>
    </div>
</div>

<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Meta Title</label>
        <input type="text" name="meta_title" class="form-control" value="<?php echo set_value('meta_title', $hotels->meta_title ?? ''); ?>">
    </div>

 
    <div class="col-md-6 mb-3">
        <label class="form-label">Meta Description</label>
        <textarea name="meta_description" class="form-control" rows="2"><?php echo set_value('meta_description', $hotels->meta_description ?? ''); ?></textarea>
    </div>
</div>


   
    <div class=" mb-3">
        <label class="form-label">Hotel Title</label>
        <input type="text" name="hotel_title" class="form-control" value="<?php echo set_value('hotel_title', $hotels->hotel_title ?? ''); ?>">
    </div>

<div class="row">

    <div class="col-md-3 mb-3">
        <label class="form-label">Destination</label>
        <input type="text" name="city" class="form-control" value="<?php echo set_value('city', $hotels->city ?? ''); ?>">
    </div>
    <div class="col-md-3 mb-3">
        <label class="form-label">Hotel Charge</label>
        <input type="number" step="0.01" name="hotel_charge" class="form-control" value="<?php echo set_value('hotel_charge', $hotels->hotel_charge ?? ''); ?>">
    </div>

    <div class="col-md-3 mb-3">
        <label class="form-label">Hotel Image</label>
        <input type="file" name="hotel_image" class="form-control">
        <?php if (!empty($hotels->hotel_image)): ?>
            <div class="mt-2">
                <img src="<?php echo base_url(''.$hotels->hotel_image); ?>" width="120" alt="Hotel Image">
            </div>
        <?php endif; ?>
    </div>


    <div class="col-md-3 mb-3">
        <label class="form-label">Hotel Star</label>
        <select name="hotel_star" class="form-select">
            <option value="">-- Select Star Rating --</option>
            <?php for($i=1; $i<=5; $i++): ?>
                <option value="<?php echo $i; ?>" <?php echo set_select('hotel_star', $i, (isset($hotels) && $hotels->hotel_star==$i)); ?>>
                    <?php echo $i; ?> Star<?php echo $i>1 ? 's' : ''; ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>

</div>

<div class="mb-3">
    <label class="form-label">Brief Description</label>
    <textarea name="brief_description" class="form-control" rows="3"><?php echo set_value('brief_description', $hotels->brief_description ?? ''); ?></textarea>
</div>

<div class="mb-3">
    <label class="form-label">Overview</label>
    <textarea name="overview" class="form-control" rows="4"><?php echo set_value('overview', $hotels->overview ?? ''); ?></textarea>
</div>

<div class="mb-3">
    <label class="form-label">Features</label>
    <textarea name="features" class="form-control" rows="3" placeholder="Comma-separated features"><?php echo set_value('features', $hotels->features ?? ''); ?></textarea>
</div>

<div class="mb-3">
    <label class="form-label">Full Description</label>
    <textarea name="full_description" class="form-control" rows="6"><?php echo set_value('full_description', $hotels->full_description ?? ''); ?></textarea>
</div>
<div class="col-md-4 mb-3">
        <label class="form-label d-block">Status</label>
        <div class="form-check form-switch">
            <input type="checkbox" name="status" class="form-check-input" id="status" value="1" <?php echo set_checkbox('status','1', (isset($hotels) && $hotels->status)); ?>>
            <label class="form-check-label" for="status">Active</label>
        </div>
    </div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="<?php echo site_url('admin/hotels'); ?>" class="btn btn-secondary">Cancel</a>
</div>


<?php echo form_close(); ?>
