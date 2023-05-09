<footer class="footer">
    <div class="container-xl">

        <div class="copyright text-center">
            <p>Copyright &copy; <?php echo date('Y');?>
                <?php echo get_bloginfo( 'name' ); ?>. All rights reserved. </p>
        </div>
        <?php /*get_template_part( 'template-parts/footer/about', 'footer' ); */?>
        <?php /*get_template_part( 'template-parts/footer/navigation', 'footer' ); */?>
        <?php /*get_template_part( 'template-parts/footer/bottom', 'footer' ); */?>
    </div>
</footer>


<?php wp_footer(); ?>

<script>
    //new WOW().init();

    jQuery(function () {

        jQuery(".toggle-password").click(function (e) {
            jQuery(this).toggleClass("la-eye la-eye-slash");
            var type = jQuery(this).hasClass("la-eye-slash") ? "text" : "password";
            jQuery(this).prev(".form-control").attr("type", type);
        });

    });

    jQuery(document).ready(function(){
        jQuery(".form-parent").find("label").removeClass("ur-label");
        //jQuery(".form-parent").find("input").addClass("form-control");
        jQuery(".button-parent").find("button").addClass("user-registration-Button button mt-3");
    });

</script>

</body>
</html>
