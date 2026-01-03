<h1><?= $title ?></h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($contacts)): ?>
            <?php foreach($contacts as $contact): ?>
                <tr>
                    <td><?= $contact->title ?></td>
                    <td>
                        <a href="<?= base_url('admin/contact/edit/'.$contact->id) ?>" class="btn btn-primary btn-sm">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2" class="text-center">
                    No Contact Page found. <a href="<?= base_url('admin/contact/save') ?>">Add New</a>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
