<h3><?= $title ?></h3>
<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
<?php endif; ?>

<a href="<?= base_url('admin/video/add') ?>" class="btn btn-primary mb-3">Add Video</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Video Name</th>
            <th>Video</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($videos as $v): ?>
        <tr>
            <td><?= $v->id ?></td>
            <td><?= $v->video_name ?></td>
            <td>
                <?php if($v->video): ?>
                    <video width="150" controls>
                        <source src="<?= base_url('uploads/videos/'.$v->video) ?>" type="video/mp4">
                    </video>
                <?php endif; ?>
            </td>
            <td><?= $v->status ? 'Active' : 'Inactive' ?></td>
            <td>
                <a href="<?= base_url('admin/video/edit/'.$v->id) ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?= base_url('admin/video/delete/'.$v->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
