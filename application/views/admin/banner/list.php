<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>
        Manage Banners - 
        <?php
        $sections = [
            'home' => 'Home Page', 
            'activity' => 'Activity Page', 
            'destination' => 'Destination Page', 
            'package' => 'Package Page', 
            'blog' => 'Blog Page',
            'contact' => 'Contact Page',
            'about' => 'About Page',
            'visa' => 'Visa Page'
        ];
        echo isset($sections[$section]) ? $sections[$section] : 'All Pages';
        ?>
    </h3>

    <select id="banner-section" class="form-control w-25">
        <?php foreach ($sections as $slug => $label): ?>
            <option value="<?= $slug ?>" <?= ($section == $slug) ? 'selected' : '' ?>><?= $label ?></option>
        <?php endforeach; ?>
    </select>
</div>

<a href="<?= base_url('admin/banner/add?section=' . $section); ?>" class="btn btn-primary mb-3">
    Add New Banner
</a>

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

<script>
    document.getElementById('banner-section').addEventListener('change', function() {
        const selected = this.value;
        window.location.href = '<?= base_url("admin/banner") ?>?section=' + selected;
    });
</script>
