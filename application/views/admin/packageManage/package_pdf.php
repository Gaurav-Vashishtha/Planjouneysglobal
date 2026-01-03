<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $package->title ?></title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        h2, h3 { margin-bottom: 5px; }
        .section { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #444; }
        th, td { padding: 6px; text-align: left; }
        img { margin-top: 10px; }
        .title { font-size: 22px; font-weight: bold; }
    </style>
</head>

<body>

<!-- Title -->
<div class="section">
    <div class="title"><?= htmlspecialchars($package->title) ?></div>
    <strong>Category:</strong> <?= ucfirst($package->category) ?><br>
    <strong>Duration:</strong> <?= $package->duration ?><br>
    <strong>Price:</strong> <?= number_format($package->price, 2) ?><br>
    <strong>Package Code:</strong> <?= $package->package_code ?><br>
</div>

<!-- Image -->
<?php if (!empty($package->image)): ?>
<div class="section">
    <img src="<?= base_url($package->image) ?>" width="300">
</div>
<?php endif; ?>

<hr>

<!-- Description -->
<div class="section">
    <h3>Description</h3>
    <div><?= nl2br(htmlspecialchars($package->description)) ?></div>
</div>

<!-- Day-wise Itinerary -->
<?php if (!empty($package->day_details)): ?>
<div class="section">
    <h3>Day-wise Itinerary</h3>
    <div><?= nl2br(htmlspecialchars($package->day_details)) ?></div>
</div>
<?php endif; ?>

<!-- Inclusion -->
<?php if (!empty($package->inclusion)): ?>
<div class="section">
    <h3>Inclusion</h3>
    <div><?= nl2br(htmlspecialchars($package->inclusion)) ?></div>
</div>
<?php endif; ?>

<!-- Exclusion -->
<?php if (!empty($package->exclusion)): ?>
<div class="section">
    <h3>Exclusion</h3>
    <div><?= nl2br(htmlspecialchars($package->exclusion)) ?></div>
</div>
<?php endif; ?>

<!-- Additional Charges -->
<?php if (!empty($package->addtional_charge)): ?>
<div class="section">
    <h3>Additional Charges</h3>
    <div><?= nl2br(htmlspecialchars($package->addtional_charge)) ?></div>
</div>
<?php endif; ?>

<!-- NOTE -->
<?php if (!empty($package->note)): ?>
<div class="section">
    <h3>Note</h3>
    <div><?= nl2br(htmlspecialchars($package->note)) ?></div>
</div>
<?php endif; ?>

<!-- Extra Services -->
<?php 
$extra_services = json_decode($package->extra_services, true);
if (!empty($extra_services)):
?>
<div class="section">
    <h3>Extra Services</h3>
    <table>
        <tr>
            <th>Meal</th>
            <td><?= $extra_services['meal'] ?></td>
        </tr>
        <tr>
            <th>Hotel</th>
            <td><?= $extra_services['hotel'] ?></td>
        </tr>
        <tr>
            <th>Transport</th>
            <td><?= $extra_services['transport'] ?></td>
        </tr>
        <tr>
            <th>Sightseeing</th>
            <td><?= $extra_services['sightseeing'] ?></td>
        </tr>
    </table>
</div>
<?php endif; ?>

<!-- Booking Policies -->
<div class="section">
    <?php if (!empty($package->booking_payment_policy)): ?>
        <h3>Booking Payment Policy</h3>
        <div><?= nl2br(htmlspecialchars($package->booking_payment_policy)) ?></div>
    <?php endif; ?>

    <?php if (!empty($package->booking_cancellation_policy)): ?>
        <h3 class="mt-2">Cancellation Policy</h3>
        <div><?= nl2br(htmlspecialchars($package->booking_cancellation_policy)) ?></div>
    <?php endif; ?>
</div>

<?php if (!empty($manage_stays)): ?>
<div class="section">
    <h3>Hotel / Stay Details</h3>

    <table>
        <tr>
            <th>Country</th>
            <th>State</th>
            <th>City</th>
            <th>Hotel Name</th>
            <th>Room Type</th>
            <th>Nights</th>
            <th>Meal Plan</th>
            <th>Rating</th>
        </tr>

        <?php foreach ($manage_stays as $ms): ?>
        <tr>
            <td><?= $ms->country_name ?></td>
            <td><?= $ms->state_name ?></td>
            <td><?= $ms->city_name ?></td>
            <td><?= $ms->hotel_name ?></td>
            <td><?= $ms->room_type ?></td>
            <td><?= $ms->nights ?></td>
            <td><?= $ms->meal_plan ?></td>
            <td><?= $ms->rating ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php endif; ?>

</body>
</html>

