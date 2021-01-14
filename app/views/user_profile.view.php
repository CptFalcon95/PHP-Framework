<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        

<?php 
    requireTemplate('partials/head'); 
    requireTemplate('partials/navigation'); 
?>

<div class="container-fluid gedf-wrapper">
    <div class="row">
        <div class="col-md-3">
            <?php requireTemplate('partials/profile/user_card'); ?>
        </div>
        <div class="col-md-6 gedf-main">
            <?php requireTemplate('partials/profile/create_post'); ?>
        </div>
        <div class="col-md-3">
            <?php requireTemplate('partials/profile/sidebar_card'); ?>
        </div>
    </div>
</div>

<?php requireTemplate('partials/footer'); ?>