<!-- <h3><?php // echo htmlspecialchars($hotels->title); ?></h3> -->
<p><strong>Category:</strong> <?php echo ucfirst($hotels->hotel_type); ?></p>
<p><strong>Price:</strong> <?php echo number_format($hotels->hotel_charge,2); ?></p>
<p><strong>Duration:</strong> <?php echo htmlspecialchars($hotels->stay_day_night); ?></p>
<?php if (!empty($hotels->hotel_image)): ?>
    <p><img src="<?php echo base_url($hotels->hotel_image); ?>" width="250" alt=""></p>
<?php endif; ?>
<hr>
<div><?php echo nl2br(htmlspecialchars($hotels->brief_description)); ?></div>
<p class="mt-3">
    <a href="<?php echo site_url('admin/hotels/edit/'.$hotels->id); ?>" class="btn btn-warning">Edit</a>
    <a href="<?php echo site_url('admin/hotels'); ?>" class="btn btn-secondary">Back</a>
</p>