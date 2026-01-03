<h1><?= $title ?></h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($footer)): ?>
            <?php foreach($footer as $footer): ?>
                <tr>
                    <td><?= $footer->title ?></td>
                    <td>
                        <a href="<?= base_url('admin/footer/edit/'.$footer->id) ?>" class="btn btn-primary btn-sm">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2" class="text-center">
                    No footer Page found. <a href="<?= base_url('admin/footer/save') ?>">Add New</a>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
