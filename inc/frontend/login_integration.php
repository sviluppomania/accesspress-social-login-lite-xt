<?php
defined( 'ABSPATH' ) or die( "No script kiddies please!" );
$options = get_option( APSL_SETTINGS );
if ( !empty( $_GET['redirect'] ) )
    $current_url = esc_url($_GET['redirect']);
else
$current_url = APSL_Lite_Login_Check_Class::curPageURL();

if( isset( $options['apsl_custom_login_redirect_options'] ) && $options['apsl_custom_login_redirect_options'] != '' ) {
    if( $options['apsl_custom_login_redirect_options'] == 'home' ) {
        $user_login_url = home_url();
    }
    else if( $options['apsl_custom_login_redirect_options'] == 'current_page' ) {
        $user_login_url = $current_url;
    }
    else if( $options['apsl_custom_login_redirect_options'] == 'custom_page' ) {
        if( $options['apsl_custom_login_redirect_link'] != '' ) {
            $login_page = $options['apsl_custom_login_redirect_link'];
            $user_login_url = $login_page;
        }
        else {
            $user_login_url = home_url();
        }
    }
}else {
    $user_login_url = home_url();
}


$encoded_url = urlencode( $user_login_url );
?>
<div class='apsl-login-networks theme-<?php echo esc_attr($options['apsl_icon_theme']); ?> clearfix'>
    <span class='apsl-login-new-text'><?php echo esc_attr($options['apsl_title_text_field']); ?></span>
    <?php
    if(isset($_SESSION['apsl_login_error_flag']) && $_SESSION['apsl_login_error_flag'] == '1'){ ?>
        <div class='apsl-error'><?php _e('You have Access Denied. Please authorize the app to login.', 'accesspress-social-login-lite' ); ?></div>
        <?php
        unset($_SESSION['apsl_login_error_flag']);
    } ?>

    <?php if ( isset( $_REQUEST['error'] ) || isset( $_REQUEST['denied'] ) ) { ?>
        <div class='apsl-error'>
            <?php _e( 'You have Access Denied. Please authorize the app to login.', 'accesspress-social-login-lite' ); ?>
        </div>
    <?php } ?>
    <div class='social-networks'>
        <?php
        foreach ( $options['network_ordering'] as $key => $value ):
            if ( $options["apsl_{$value}_settings"]["apsl_{$value}_enable"] === 'enable' ) { ?>
                <a href="<?php echo wp_login_url(); ?>?apsl_login_id=<?php echo esc_attr($value); ?>_login<?php
                if ( $encoded_url ) {
                    echo "&state=" . base64_encode( "redirect_to=$encoded_url" );
                }
                ?>" title='<?php
                   _e( 'Login with', 'accesspress-social-login-lite' );
                   echo ' ' . esc_attr($value);
                   ?>' >
                    <div class="apsl-icon-block icon-<?php echo esc_attr($value); ?> clearfix">
                        <?php if ($value=='google'){
                        if (isset($options['font_awesome_version']) && $options['font_awesome_version'] == 'apsl-font-awesome-four') {?>
                        <i class="fa fa-google"></i>
                        <?php }
                        else{?>
                        <i class="fab fa-google"></i>
                        <?php }
                        }
                        if ($value=='facebook'){
                        if (isset($options['font_awesome_version']) && $options['font_awesome_version'] == 'apsl-font-awesome-four') {?>
                        <i class="fa fa-facebook"></i>
                        <?php }
                        else{?>
                        <i class="fab fa-facebook-f"></i>
                        <?php }
                        }
                        if ($value=='twitter'){
                        if (isset($options['font_awesome_version']) && $options['font_awesome_version'] == 'apsl-font-awesome-four') {?>
                        <i class="fa fa-twitter"></i>
                        <?php }
                        else{?>
                        <i class="fab fa-twitter"></i>
                        <?php }
                        }?>
                        <span class="apsl-login-text"><?php _e( 'Login', 'accesspress-social-login-lite' ); ?></span>
                        <span class="apsl-long-login-text"><?php _e( 'Login with', 'accesspress-social-login-lite' ); ?><?php echo ' ' . esc_attr($value); ?></span>
                    </div>
                </a>
                <?php
            }
        endforeach;
        ?>
    </div>
</div>