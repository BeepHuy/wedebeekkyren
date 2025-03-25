<div style = 'font-size: 16px'>
 <?php
$isPending = ($rq->status == 'Pending');
$isApproved = ($rq->status == 'Approved');
$isDenied = ($rq->status == 'Deny');
$textClass = $isPending ? 'text-primary' : ($isApproved ? 'text-success' : 'text-warning');

// Format the deny message with black text for the reason
if ($isDenied && !empty($rq->denyreason)) {
    $denyMessage = ' because reason: <span class="text-dark">' . $rq->denyreason . '.</span>';
} else {
    $denyMessage = '';
}

$message = $isPending
 ? 'Ticket already exists. You can know status at menu Offers -> Pending.'
 : ($isApproved
 ? 'Your campaign has been approved. Good luck!'
 : 'Your apply has been rejected' . $denyMessage . '<br>You can apply again with another traffic type');
?>
<p class="<?php echo $textClass; ?>">
<?php echo $isPending ? 'Pending!' : ($isApproved ? 'Approved!' : ''); ?> <br>
<strong><?php echo $message; ?></strong>
</p>
</div>