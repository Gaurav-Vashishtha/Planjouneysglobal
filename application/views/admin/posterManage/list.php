<div class="d-flex justify-content-between align-items-center mb-3">
    <h4><?= $title ?></h4>
    <a href="<?= base_url('admin/poster/create') ?>" class="btn btn-primary">+ Add Poster</a>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th width="60">ID</th>
            <th>Link</th>
            <th>Poster</th>
            <th>Status</th>
            <th width="130">Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php if(!empty($poster)): $i =1; foreach($poster as $b): ?>
        <tr>
            <td><?= $i++ ?></td>

            <td><?= $b->link ?></td>

            <td>
                <?php if ($b->poster): ?>
                    <img src="<?= base_url($b->poster) ?>" width="80">
                <?php else: ?>
                    <span class="text-muted">No Image</span>
                <?php endif; ?>
            </td>


            <td>
                <?= $b->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' ?>
            </td>

           

            <td>
                <a href="<?= base_url('admin/poster/edit/'.$b->id) ?>" class="btn btn-sm btn-warning">Edit</a>

                <a href="<?= base_url('admin/poster/delete/'.$b->id) ?>" 
                   onclick="return confirm('Delete this Poster?')" 
                   class="btn btn-sm btn-danger">Delete</a>
            </td>

        </tr>
        <?php endforeach; else: ?>
        <tr>
            <td colspan="7" class="text-center text-muted">No Poster found.</td>
        </tr>
        <?php endif; ?>
    </tbody>

</table>
