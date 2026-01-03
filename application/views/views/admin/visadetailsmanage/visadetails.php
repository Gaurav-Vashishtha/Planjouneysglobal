<div class="d-flex justify-content-between align-items-center mb-3">
    <h3><?= $title ?? 'Visa Details'; ?></h3>
    <div>
        <a href="<?= site_url('admin/visadetails/add'); ?>" class="btn btn-primary">+ Add Visa Details</a>
    </div>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Country Name</th>
            <th>Banner Image</th>
            <th>Image</th>
            <th style="width:200px">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($visa_details)): $i = 1; ?>
        <?php foreach ($visa_details as $v): ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= htmlspecialchars($v->country_name); ?></td>
                <td>
                    <?php if (!empty($v->banner_image)): ?>
                        <img src="<?= base_url($v->banner_image); ?>" width="80" class="img-thumbnail">
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (!empty($v->image)): ?>
                        <img src="<?= base_url($v->image); ?>" width="80" class="img-thumbnail">
                    <?php endif; ?>
                </td>
                <td>
                    <a class="btn btn-sm btn-warning" href="<?= site_url('admin/visadetails/edit/'.$v->id); ?>">Edit</a>
                    <a class="btn btn-sm btn-danger" href="<?= site_url('admin/visadetails/delete/'.$v->id); ?>" onclick="return confirm('Are you sure you want to delete this?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" class="text-center">No Visa Details found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
