<h2>Manage Blogs</h2>
<a href="<?= base_url('admin/blog/add'); ?>" class="btn btn-primary mb-3">Add New Blog</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#ID</th>
            <th>Blog Name</th>
            <th>Category</th>
            <th>Blog Heading</th>
            <th>Status</th>
            <th>Banner</th>
            <th>Home Image</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($blogs)): ?>
            <?php foreach($blogs as $blog): ?>
            <tr>
                <td><?= $blog->id; ?></td>
                <td><?= $blog->blog_name; ?></td>
                <td><?= ucfirst($blog->category); ?></td>
                <td><?= $blog->blog_heading; ?></td>
                <td>
                    <?php if($blog->status): ?>
                        <span class="badge bg-success">Active</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Inactive</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($blog->banner_image): ?>
                        <img src="<?= base_url('uploads/blogs/'.$blog->banner_image); ?>" width="100">
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($blog->home_image): ?>
                        <img src="<?= base_url('uploads/blogs/'.$blog->home_image); ?>" width="80">
                    <?php endif; ?>
                </td>
                <td><?= date('d M Y', strtotime($blog->created_at)); ?></td>
                <td>
                    <a href="<?= base_url('admin/blog/edit/'.$blog->id); ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="<?= base_url('admin/blog/delete/'.$blog->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this blog?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="9" class="text-center">No blogs found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
