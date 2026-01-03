

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Visa Packages</h3>
       
    </div>


    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="15%">Heading</th>
                <th width="15%">Agency Heading</th>
             
                <th width="10%">Image 2</th>
                <th width="15%">Link</th>
                
                <th width="5%">Action</th>
            </tr>
        </thead>

        <tbody>
                    <?php if(!empty($packages)):  
                $i = 1;  
            ?>
                <?php foreach($packages as $p): ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $p->heading ?></td>
                        <td><?= $p->agency_heading ?></td>

                        <td>
                            <?php if(!empty($p->image_2)): ?>
                                <img src="<?= base_url($p->image_2) ?>" width="70">
                            <?php endif; ?>
                        </td>

                        <td><?= $p->link ?></td>
                     

                        <td>
                            <a href="<?= base_url('admin/visa_package/edit/'.$p->id) ?>" class="btn btn-warning btn-sm">Edit</a>
                          
                        </td>
                    </tr>
                <?php endforeach; ?>

            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No visa packages found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>



