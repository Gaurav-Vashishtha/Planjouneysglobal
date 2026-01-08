<h3><?php echo htmlspecialchars($activities->title); ?></h3>
<p><strong>Category:</strong> <?php echo ucfirst($activities->category); ?></p>
<p><strong>Price:</strong> <?php echo number_format($activities->price,2); ?></p>
<?php if (!empty($activities->image)): ?>
    <p><img src="<?php echo base_url($activities->image); ?>" width="250" alt=""></p>
<?php endif; ?>
<hr>
<div><?php echo nl2br(htmlspecialchars($activities->description)); ?></div>
<p class="mt-3">
    <a href="<?php echo site_url('admin/activities/edit/'.$activities->id); ?>" class="btn btn-warning">Edit</a>
    <a href="<?php echo site_url('admin/activities'); ?>" class="btn btn-secondary">Back</a>
</p>
