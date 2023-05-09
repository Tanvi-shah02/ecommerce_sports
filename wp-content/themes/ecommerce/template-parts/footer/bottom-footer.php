<div class="copyright text-center text-md-left py-3 mt-5">
    <div class="row mt-3">
        <div class="col-md-6">
            <p>&copy; Copyright <?php echo get_bloginfo( 'name' ); ?>  <?php echo date('Y');?>. All Rights Reserved</p>
        </div>
        <?php
        if( has_nav_menu('bottom_menu') ){ ?>
        <div class="col-md">
            <div class="footer-widget">
                <!--<ul class="navbar-nav flex-row justify-content-center justify-content-md-end">
                    <li class="nav-item"><a class="nav-link" href="#">Privacy Policy </a></li>
                    <li class="nav-item"><a class="nav-link" href="#"> Terms &amp; Conditions</a></li>
                </ul>-->
                <?php
                wp_nav_menu( array('theme_location'=>'bottom_menu', 'menu_class'=> 'navbar-nav flex-row justify-content-center justify-content-md-end', 'container'=> '') );
                ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>