<?php
/**
 * Lost password reset form.
 *
 * This template can be overridden by copying it to yourtheme/user-registration/myaccount/form-reset-password.php.
 *
 * HOWEVER, on occasion UserRegistration will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.wpeverest.com/user-registration/template-structure/
 * @author  WPEverest
 * @package UserRegistration/Templates
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

ur_print_notices(); ?>
<div class="row justify-content-center mt-4">
    <div class="col-md-8 col-lg-7">
        <div class="card card-reset-password-wrap shadow-lg border-0">
            <div class="card-body py-3 px-5">

<div class="ur-frontend-form login" id="ur-frontend-form">
<form method="post" class="user-registration-ResetPassword lost_reset_password" data-enable-strength-password="<?php echo esc_attr( $enable_strong_password ); ?>" data-minimum-password-strength="<?php echo esc_attr( $minimum_password_strength ); ?>">
		<div class="ur-form-row">
			<div class="ur-form-grid">
				<h5 class="mb-3"><?php echo esc_html( apply_filters( 'user_registration_reset_password_message', esc_html__( 'Enter a new password below.', 'user-registration' ) ) ); ?></h5>

				<p class="user-registration-form-row user-registration-form-row--wide form-row form-row-wide hide_show_password">
					<label for="password_1"><?php esc_html_e( 'New password', 'user-registration' ); ?> <span class="required">*</span></label>
					<span class="password-input-group">
					<input type="password" placeholder="New password" class="user-registration-Input user-registration-Input--text input-text" name="password_1" id="password_1" />
					<?php
					if ( 'yes' === get_option( 'user_registration_login_option_hide_show_password', 'no' ) ) {
						echo '<a href="javaScript:void(0)" class="password_preview dashicons dashicons-hidden" title="' . esc_attr__( 'Show Password', 'user-registration' ) . '"></a>';
					}
					?>
					</span>
				</p>
				<p class="user-registration-form-row user-registration-form-row--wide form-row form-row-wide hide_show_password">
					<label for="password_2"><?php esc_html_e( 'Re-enter new password', 'user-registration' ); ?> <span class="required">*</span></label>
					<span class="password-input-group">
					<input type="password" placeholder="Re-enter new password" class="user-registration-Input user-registration-Input--text input-text" name="password_2" id="password_2" />
					<?php
					if ( 'yes' === get_option( 'user_registration_login_option_hide_show_password', 'no' ) ) {
						echo '<a href="javaScript:void(0)" class="password_preview dashicons dashicons-hidden" title="' . esc_attr__( 'Show Password', 'user-registration' ) . '"></a>';
					}
					?>
					</span>
				</p>

				<input type="hidden" name="reset_key" value="<?php echo esc_attr( $args['key'] ); ?>" />
				<input type="hidden" name="reset_login" value="<?php echo esc_attr( $args['login'] ); ?>" />

				<div class="clear"></div>

				<?php do_action( 'user_registration_resetpassword_form' ); ?>

				<p class="user-registration-form-row form-row">
					<input type="hidden" name="ur_reset_password" value="true" />
					<input type="submit" class="user-registration-Button button" value="<?php esc_attr_e( 'Save', 'user-registration' ); ?>" />
				</p>

				<?php wp_nonce_field( 'reset_password' ); ?>
			</div>
		</div>
	</form>
</div>
            </div>
        </div>
    </div>
</div>