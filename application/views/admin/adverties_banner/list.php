<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><?= $title ?></h4>
    <a href="<?= base_url('admin/adverties_banner/create') ?>" class="btn btn-primary">+ Add Banner</a>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th width="60">ID</th>
           
            <th>Banner 1</th>
            <th>Banner 2</th>
            <th>Status</th>
            <th width="130">Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php if(!empty($banners)): foreach($banners as $b): ?>
        <tr>
            <td><?= $b->id ?></td>

            <td>
                <?php if ($b->banner1): ?>
                    <img src="<?= base_url($b->banner1) ?>" width="80">
                <?php else: ?>
                    <span class="text-muted">No Image</span>
                <?php endif; ?>
            </td>

            <td>
                <?php if ($b->banner2): ?>
                    <img src="<?= base_url($b->banner2) ?>" width="80">
                <?php else: ?>
                    <span class="text-muted">No Image</span>
                <?php endif; ?>
            </td>

            <td>
                <?= $b->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' ?>
            </td>

           

            <td>
                <a href="<?= base_url('admin/adverties_banner/edit/'.$b->id) ?>" class="btn btn-sm btn-warning">Edit</a>

                <a href="<?= base_url('admin/adverties_banner/delete/'.$b->id) ?>" 
                   onclick="return confirm('Delete this banner?')" 
                   class="btn btn-sm btn-danger">Delete</a>
            </td>

        </tr>
        <?php endforeach; else: ?>
        <tr>
            <td colspan="7" class="text-center text-muted">No banners found.</td>
        </tr>
        <?php endif; ?>
    </tbody>

</table>
