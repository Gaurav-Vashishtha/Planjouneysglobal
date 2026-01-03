<div class="container">
    <h3 class="mb-3">Manage Banners</h3>

    <a href="<?= base_url('admin/banner/add'); ?>" class="btn btn-primary mb-3">Add New Banner</a>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>Banner Name</th>
            <th>Image</th>
            <th>Link</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php foreach ($banners as $b): ?>
            <tr>
                <td><?= $b->id ?></td>
                <td><?= $b->banner_name ?></td>
                <td>
                    <?php if ($b->banners_image): ?>
                        <img src="<?= base_url('uploads/banners/' . $b->banners_image); ?>" width="80">
                    <?php endif; ?>
                </td>
                <td><?= $b->link ?></td>
                <td><?= $b->status ? 'Active' : 'Inactive' ?></td>
                <td>
                    <a href="<?= base_url('admin/banner/edit/' . $b->id); ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= base_url('admin/banner/delete/' . $b->id); ?>" 
                       onclick="return confirm('Delete banner?')" 
                       class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
