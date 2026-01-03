<div class="d-flex justify-content-between align-items-center mb-3">
    <h3><?php echo $title ?? 'list'; ?></h3>
    <div>
        <a href="<?php echo site_url('admin/activities/create'); ?>" class="btn btn-primary">+ Add Activity</a>
    </div>
</div>

<form method="get" class="row g-2 mb-3">
    <div class="col-auto">
        <select name="category" class="form-select">
            <option value="">-- All Categories --</option>
            <option value="domestic" <?php echo (isset($filters['category']) && $filters['category']=='domestic')?'selected':''; ?>>Domestic</option>
            <option value="international" <?php echo (isset($filters['category']) && $filters['category']=='international')?'selected':''; ?>>International</option>
            <option value="europe" <?php echo (isset($filters['category']) && $filters['category']=='europe')?'selected':''; ?>>Europe</option>
        </select>
    </div>
    <div class="col-auto">
        <select name="status" class="form-select">
            <option value="">-- Any status --</option>
            <option value="1" <?php echo (isset($filters['status']) && $filters['status']=='1')?'selected':''; ?>>Active</option>
            <option value="0" <?php echo (isset($filters['status']) && $filters['status']=='0')?'selected':''; ?>>Inactive</option>
        </select>
    </div>
    <div class="col-auto">
        <input type="text" name="search" class="form-control" placeholder="Search title/desc" value="<?php echo htmlspecialchars($filters['search'] ?? ''); ?>">
    </div>
    <div class="col-auto">
        <button class="btn btn-secondary" type="submit">Filter</button>
        <a href="<?php echo site_url('admin/activities'); ?>" class="btn btn-light">Reset</a>
    </div>
</form>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Category</th>
            <th>Price</th>
            <th>Status</th>
            <th>Created</th>
            <th style="width:200px">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($activities)): $i=1; foreach ($activities as $a): ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($a->title); ?></td>
            <td><?php echo ucfirst($a->category); ?></td>
            <td><?php echo number_format($a->price,2); ?></td>
            <td><?php echo $a->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'; ?></td>
            <td><?php echo date('Y-m-d', strtotime($a->created_at)); ?></td>
            <td>
                <a class="btn btn-sm btn-info" href="<?php echo site_url('admin/activities/view/'.$a->id); ?>">View</a>
                <a class="btn btn-sm btn-warning" href="<?php echo site_url('admin/activities/edit/'.$a->id); ?>">Edit</a>
                <a class="btn btn-sm btn-secondary" href="<?php echo site_url('admin/activities/toggle/'.$a->id); ?>"><?php echo $a->status ? 'Deactivate' : 'Activate'; ?></a>
                <a class="btn btn-sm btn-danger" href="<?php echo site_url('admin/activities/delete/'.$a->id); ?>">Delete</a>
            </td>
        </tr>
    <?php endforeach; else: ?>
        <tr><td colspan="8" class="text-center">No activities found.</td></tr>
    <?php endif; ?>
    </tbody>
</table>




