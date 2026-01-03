<h1><?= $title ?></h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if($home): ?>
            <tr>
                <td><?= $home->title ?></td>
                <td>
                    <a href="<?= base_url('admin/home_page/edit/'.$home->id) ?>" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center">No Home Page found. <a href="<?= base_url('admin/home_page/save') ?>">Add New</a></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
