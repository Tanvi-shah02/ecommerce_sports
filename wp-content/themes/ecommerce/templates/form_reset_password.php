<?php

/**

 * Template Name: Reset Password

 */

?>

<?php get_header(); ?>

<div class="container-xl">
        <?php $obj = new UR_Shortcode_My_Account();
        echo $obj->lost_password();
        ?>
</div>

<?php get_footer(); ?>
