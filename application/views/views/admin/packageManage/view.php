<h3><?php echo htmlspecialchars($package->title); ?></h3>
<p><strong>Category:</strong> <?php echo ucfirst($package->category); ?></p>
<p><strong>Price:</strong> <?php echo number_format($package->price,2); ?></p>
<p><strong>Duration:</strong> <?php echo htmlspecialchars($package->duration); ?></p>
<?php if (!empty($package->image)): ?>
    <p><img src="<?php echo base_url($package->image); ?>" width="250" alt=""></p>
<?php endif; ?>
<hr>
<div><?php echo nl2br(htmlspecialchars($package->description)); ?></div>
<p class="mt-3">
    <a href="<?php echo site_url('admin/package/edit/'.$package->id); ?>" class="btn btn-warning">Edit</a>
    <a href="<?php echo site_url('admin/package'); ?>" class="btn btn-secondary">Back</a>
</p>
<a href="<?= site_url('admin/package/download/'.$package->id) ?>" class="btn btn-primary">
    Download PDF
</a>
