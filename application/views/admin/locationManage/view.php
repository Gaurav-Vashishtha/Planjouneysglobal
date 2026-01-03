<h3><?php echo $location->name; ?></h3>

<p><strong>Category:</strong> <?php echo $location->category; ?></p>
<p><strong>Language:</strong> <?php echo $location->language; ?></p>
<p><strong>Capital:</strong> <?php echo $location->capital; ?></p>
<p><strong>Currency:</strong> <?php echo $location->currency; ?></p>
<p><strong>Description:</strong> <?php echo $location->description; ?></p>

<h4>Main Image</h4>
<?php if ($location->image): ?>
    <img src="<?php echo base_url('uploads/location/'.$location->image); ?>" width="250">
<?php endif; ?>

<h4>Gallery Images</h4>
<?php 
$gallery = json_decode($location->gallery, true);
if ($gallery):
    foreach ($gallery as $img):
?>
    <img src="<?php echo base_url('uploads/location/gallery/'.$img); ?>" 
         width="120" class="m-2">
<?php 
    endforeach;
endif;
?>

<h4>Video</h4>
<?php if ($location->video): ?>
    <video width="300" controls>
        <source src="<?php echo base_url('uploads/location/video/'.$location->video); ?>">
    </video>
<?php endif; ?>
