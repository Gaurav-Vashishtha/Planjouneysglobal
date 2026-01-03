<div class="d-flex justify-content-between align-items-center mb-3">
    <h3><?= $title ?? 'Tourguide'; ?></h3>
    <div>
        <a href="<?= site_url('admin/tourguide/add'); ?>" class="btn btn-primary">+ Add Tourguide</a>
    </div>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Specialization</th>
            <th>Image</th>
            <th>Status</th> 
            <th style="width:200px">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($tourguide)): $i=1; ?>
        <?php foreach ($tourguide as $t): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= htmlspecialchars($t->name); ?></td>
                <td><?= htmlspecialchars($t->specialization); ?></td>
                <td>
                    <?php if (!empty($t->image)): ?>
                        <img src="<?= base_url('uploads/tourguide/' . $t->image); ?>" width="80" class="img-thumbnail">
                    <?php endif; ?>
                </td>

                 <td>
                    <?php if ($t->status == 1): ?>
                        <span class="badge bg-success">Active</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Inactive</span>
                    <?php endif; ?>
                </td>

                <td>
                    <a class="btn btn-sm btn-warning" href="<?= site_url('admin/tourguide/edit/'.$t->id); ?>">Edit</a>
                    <a class="btn btn-sm btn-danger" href="<?= site_url('admin/tourguide/delete/'.$t->id); ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="6" class="text-center">No tourguides found. </td></tr>
    <?php endif; ?>
    </tbody>
</table>
