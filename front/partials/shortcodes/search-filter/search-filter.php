<?php
$user_id = get_current_user_id();
$user_id = $user_id !== 0 ? $user_id : 1;
?>
<input type="hidden" name = "user_id" value="<?php echo $user_id; ?>" />
<div class="lds-dual-ring"></div>
<div class="container">
    <div class="row">
        <div id="filter" class="col-lg-3 col-md-3 col-sm-12">
            <?php include_once $shortcode_dir . '/filter/search.php'; ?>
            <?php include_once $shortcode_dir . '/filter/filter.php'; ?>
        </div>
        <div id="results" class="col-lg-9 col-md-9 col-sm-12 d-flex flex-column">
	        <?php include_once $shortcode_dir . '/results/header.php'; ?>
	        <?php include_once $shortcode_dir . '/results/wrapper.php'; ?>
        </div>
    </div>
</div>