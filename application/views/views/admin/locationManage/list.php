<a href="<?php echo base_url('admin/location/add'); ?>" class="btn btn-primary mb-3">Add Location</a>

<?php  if($this->session->flashdata('success')): ?>
<?php endif; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Image</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
       <?php if (!empty($locations)): $i=1; foreach ($locations as $loc): ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $loc->name; ?></td>
            <td><?php echo $loc->description; ?></td>
            <td>
                <?php if($loc->image): ?>
                    <a href="<?php echo base_url($loc->image); ?>" target="_blank" rel="noopener noreferrer">
                        <img src="<?php echo base_url($loc->image); ?>" height="50">
                    </a>
                <?php endif; ?>
            </td>
            <td><?php echo $loc->status ? 'Active' : 'Inactive'; ?></td>
            <td>
                <a href="<?php echo base_url('admin/location/edit/'.$loc->id); ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?php echo base_url('admin/location/delete/'.$loc->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                <a href="<?php echo base_url('admin/location/toggle/'.$loc->id); ?>" class="btn btn-sm btn-info">Change Status</a>
            </td>
        </tr>
           <?php endforeach; else: ?>
        <tr><td colspan="8" class="text-center">No location found.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
