<div class="d-flex justify-content-between align-items-center mb-3">
    <h3><?php echo $title ?? 'Hotels'; ?></h3>
    <div>
        <a href="<?php echo site_url('admin/hotels/create'); ?>" class="btn btn-primary">+ Add Hotel</a>
    </div>
</div>

<form method="get" class="row g-2 mb-3">
    <div class="col-auto">
        <select name="hotel_type" class="form-select">
            <option value="">-- All Categories --</option>
            <option value="domestic" <?php echo (isset($filters['hotel_type']) && $filters['hotel_type']=='domestic')?'selected':''; ?>>Domestic</option>
            <option value="international" <?php echo (isset($filters['hotel_type']) && $filters['hotel_type']=='international')?'selected':''; ?>>International</option>
        </select>
    </div>
    <div class="col-auto">
        <select name="status" class="form-select">
            <option value="">-- Any Status --</option>
            <option value="1" <?php echo (isset($filters['status']) && $filters['status']=='1')?'selected':''; ?>>Active</option>
            <option value="0" <?php echo (isset($filters['status']) && $filters['status']=='0')?'selected':''; ?>>Inactive</option>
        </select>
    </div>
    <div class="col-auto">
        <button class="btn btn-secondary" type="submit">Filter</button>
        <a href="<?php echo site_url('admin/hotels'); ?>" class="btn btn-light">Reset</a>
    </div>
</form>

<table class="table table-bordered table-striped align-middle">
    <thead>
        <tr>
            <th>S.No.</th>
            <th>Category</th>
            <th>Image</th>
            <th>Hotel Charge</th>
            <th>Status</th>
            <th style="width:180px">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($hotels)): $i=1; foreach ($hotels as $h): ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo ucfirst($h->hotel_type); ?></td>
            <td>
                <?php if (!empty($h->hotel_image)): ?>
                    <img src="<?php echo base_url(''.$h->hotel_image); ?>" alt="Hotel Image" width="60" height="50">
                <?php else: ?>
                    <!-- <span class="text-muted">No Image</span> -->
                <?php endif; ?>
            </td>
            <td><?php echo number_format($h->hotel_charge ?? 0, 2); ?></td>
            <td>
                <?php echo $h->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'; ?>
            </td>
            <td>
                <a class="btn btn-sm btn-info" href="<?php echo site_url('admin/hotels/view/'.$h->id); ?>">View</a>
                <a class="btn btn-sm btn-warning" href="<?php echo site_url('admin/hotels/edit/'.$h->id); ?>">Edit</a>
                <a class="btn btn-sm btn-secondary" href="<?php echo site_url('admin/hotels/toggle/'.$h->id); ?>">
                    <?php echo $h->status ? 'Deactivate' : 'Activate'; ?>
                </a>
                <a class="btn btn-sm btn-danger" href="<?php echo site_url('admin/hotels/delete/'.$h->id); ?>" onclick="return confirm('Are you sure you want to delete this hotel?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; else: ?>
        <tr><td colspan="10" class="text-center">No hotel found.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
