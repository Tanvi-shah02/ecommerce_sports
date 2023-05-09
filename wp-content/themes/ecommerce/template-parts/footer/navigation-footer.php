<?php
if( has_nav_menu('footer_menu1') ){ ?>
<div class="col-md-auto">
    <div class="footer-widget">
        <h6 class="footer-widget-title">Products</h6>
        <?php
            wp_nav_menu( array('theme_location'=>'footer_menu1', 'menu_class'=> 'footer-widget-links list-inline', 'container'=> '') );
        ?>
    </div>
</div>
<?php } ?>
<?php
if( has_nav_menu('footer_menu2') ){ ?>
<div class="col-md-auto">
    <div class="footer-widget">
        <h6 class="footer-widget-title">Products</h6>
        <?php
            wp_nav_menu( array('theme_location'=>'footer_menu2', 'menu_class'=> 'footer-widget-links list-inline', 'container'=> '') );
        ?>
    </div>
</div>
<?php } ?>