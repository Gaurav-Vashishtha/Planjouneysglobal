<h1><?= $title ?></h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if($about): ?>
            <tr>
                <td><?= $about->title ?></td>
                <td>
                    <a href="<?= base_url('admin/about_us/edit'.$about->id) ?>" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="2" class="text-center">
                    No About Page found. <a href="<?= base_url('admin/about_us/save') ?>">Add New</a>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
