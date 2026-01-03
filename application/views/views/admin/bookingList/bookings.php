<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Booking List</h4>
    <a href="<?php echo site_url('admin/bookings/download'); ?>" class="btn btn-primary">
        <i class="fa fa-download"></i> Export CSV
    </a>
</div>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Package Code</th>
            <th>Name</th>
            <th>Total Person</th>
            <th>Check-In-date</th>
            <th>Check-Out-date</th>  
            <!-- <th>Extra Bed</th>
            <th>Child Without Bed</th>
            <th>Meal Plan</th> -->
            <th>Mobile No.</th>
            <!-- <th>Additional Info</th> -->
            <th>Created_at</th>
        </tr>
    </thead>
    <tbody>
  <?php if (!empty($bookings)): $i=1; foreach ($bookings as $book): ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $book->package_code; ?></td>
            <td><?php echo $book->first_guest_name; ?></td>
            <td><?php echo $book->total_persons; ?></td>
            <td><?php echo $book->check_in_date; ?></td>
            <td><?php echo $book->check_out_date; ?></td>
            <!-- <td><?php // echo $book->extra_bed; ?></td>
            <td><?php  // echo $book->child_without_bed; ?></td>
            <td><?php // echo $book->meal_plan; ?></td> -->
            <td><?php echo $book->mobile_no; ?></td>
            <!-- <td><?php // echo $book->additional_info; ?></td> -->
            <td><?php echo $book->created_at; ?></td>
            <!-- <td>
                <a href="<?php // echo base_url('admin/bookation/edit/'.$book->id); ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?php // echo base_url('admin/bookation/delete/'.$book->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                <a href="<?php // echo base_url('admin/bookation/toggle/'.$book->id); ?>" class="btn btn-sm btn-info">Change Status</a>
            </td> -->
        </tr>
         <?php endforeach; else: ?>
        <tr><td colspan="8" class="text-center">No booking found.</td></tr>
    <?php endif; ?>
        
    </tbody>
</table>
