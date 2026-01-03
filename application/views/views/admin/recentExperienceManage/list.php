<h1><?= $title ?></h1>


<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php endif; ?>

<a href="<?= base_url('admin/recent_experience/save') ?>" class="btn btn-primary mb-3">Add New</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Images</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($experiences)): ?>
            <?php foreach($experiences as $exp): ?>
                <tr>
                    <td><?= $exp->id ?></td>
                    <td>
                        <?php $imgs = json_decode($exp->images,true);
                        if($imgs) {
                            foreach($imgs as $img): ?>
                                <div style="display:inline-block;position:relative;margin:5px;">
                                    <img src="<?= base_url('uploads/recent_experience/'.$img) ?>" width="80">
                                    <a href="<?= base_url('admin/recent_experience/delete_image/'.$exp->id.'/'.$img) ?>" style="position:absolute;top:0;right:0;color:red;font-weight:bold;">X</a>
                                </div>
                            <?php endforeach; 
                        } ?>
                    </td>
                    <td>
                        <a href="<?= base_url('admin/recent_experience/save/'.$exp->id) ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="<?= base_url('admin/recent_experience/delete/'.$exp->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3" class="text-center">No records found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>


<?php if(isset($record)): ?>
<form method="post" action="<?= base_url('admin/recent_experience/save/'.$record->id) ?>" enctype="multipart/form-data">
<?php else: ?>
<form method="post" action="<?= base_url('admin/recent_experience/save') ?>" enctype="multipart/form-data">
<?php endif; ?>
    <div class="form-group">
        <label>Upload Images <small>(Max size: 2 MB)</small></label>
        <input type="file" name="images[]" multiple class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Save</button>
</form>
