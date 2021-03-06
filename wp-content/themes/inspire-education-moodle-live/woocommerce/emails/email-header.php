<?php
/**
 * Email Header
 *
 * @author  WooThemes
 * @package WooCommerce/Templates/Emails
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Load colours
$bg         = get_option( 'woocommerce_email_background_color' );
$body       = get_option( 'woocommerce_email_body_background_color' );
$base       = get_option( 'woocommerce_email_base_color' );
$base_text  = woocommerce_light_or_dark( $base, '#202020', '#ffffff' );
$text       = get_option( 'woocommerce_email_text_color' );

$bg_darker_10 = woocommerce_hex_darker( $bg, 10 );
$base_lighter_20 = woocommerce_hex_lighter( $base, 20 );
$text_lighter_20 = woocommerce_hex_lighter( $text, 20 );

// For gmail compatibility, including CSS styles in head/body are stripped out therefore styles need to be inline. These variables contain rules which are added to the template inline. !important; is a gmail hack to prevent styles being stripped if it doesn't like something.
$wrapper = "
    background-color: " . esc_attr( $bg ) . ";
    width:100%;
    -webkit-text-size-adjust:none !important;
    margin:0;
    padding: 70px 0 70px 0;
";
$template_container = "
    -webkit-box-shadow:0 0 0 3px rgba(0,0,0,0.025) !important;
    box-shadow:0 0 0 3px rgba(0,0,0,0.025) !important;
    -webkit-border-radius:6px !important;
    border-radius:6px !important;
    background-color: " . esc_attr( $body ) . ";
    border: 1px solid $bg_darker_10;
    -webkit-border-radius:6px !important;
    border-radius:6px !important;
";
$template_header = "
    background: " . esc_attr( $base ) ." url('https://shop.inspireeducation.net.au/wp-content/themes/Inspire-ed/assets/images/email-bg.jpg') no-repeat top center !important;
    color: $base_text;
    -webkit-border-top-left-radius:6px !important;
    -webkit-border-top-right-radius:6px !important;
    border-top-left-radius:6px !important;
    border-top-right-radius:6px !important;
    border-bottom: 0;
    font-family:Arial;
    font-weight:bold;
    line-height:100%;
    vertical-align:middle;
";
$body_content = "
    background-color: " . esc_attr( $body ) . ";
    -webkit-border-radius:6px !important;
    border-radius:6px !important;
";
$body_content_inner = "
    color: $text_lighter_20;
    font-family:Arial;
    font-size:14px;
    line-height:150%;
    text-align:left;
";
$header_content_h1 = "
    color: #46809d;
    margin:0;
    padding: 0px 150px 29px 0px;
    text-shadow: 0 1px 0 $base_lighter_20;
    display:block;
    font-family:Arial;
    font-size:24px;
    font-weight:300;
    text-align:left;
    line-height: 110%;
";
$header_content_h2 = "
    color: #46809d;
";
$header_content_h3 = "
    color: #545757;
    margin:0;
    padding: 32px 24px 0px 24px;
    display:block;
    font-family:Arial;
    font-size:16px;
    font-weight:bold;
    text-align:left;
    line-height: 110%;
";

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?php echo get_bloginfo('name'); ?></title>
	</head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    	<div style="<?php echo $wrapper; ?>">
        	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
            	<tr>
                	<td align="center" valign="top">
                		<?php
                			if ( $img = get_option( 'woocommerce_email_header_image' ) ) {
                				echo '<p style="margin-top:0;"><img src="' . esc_url( $img ) . '" alt="' . get_bloginfo( 'name' ) . '" /></p>';
                			}
                		?>
                    	<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="<?php echo $template_container; ?>">
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- Header -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style="<?php echo $template_header; ?>" bgcolor="<?php echo $base; ?>">
                                        <tr>
                                            <td>
                                            	<p style="margin-top:30px;margin-bottom:30px;margin-left:20px;"><img src="https://shop.inspireeducation.net.au/wp-content/themes/Inspire-ed/assets/images/inspire-education-logo-email.png" width="268" height="120" alt="Inspire Education"/></p>
                                            </td>
                                        </tr>
                                    </table>
                                    <!-- End Header -->
                                </td>
                            </tr>
                        	<tr>
                            	<td align="center" valign="top">
                                    <!-- Body -->
                                	<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                                    	<tr>
                                            <td valign="top" style="<?php echo $body_content; ?>">
                                                <!-- Content -->
                                                <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td valign="top">
                                                            <div style="<?php echo $body_content_inner; ?>">
                                            					<h1 style="<?php echo $header_content_h1; ?>"><?php echo $email_heading; ?></h1>