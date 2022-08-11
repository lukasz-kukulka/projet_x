<?php
$pm_sanitizer = new PM_sanitizer;
$post = $pm_sanitizer->sanitize($_POST);

if ( !isset( $post['nonce'] ) || ! wp_verify_nonce($post['nonce'], 'ajax-nonce' ) ) {
    die(esc_html__('Failed security check','profilegrid-user-profiles-groups-and-communities') );
}
$name = $post['name'];
$blogusers = get_users( array( 'search' => $name ) );
// Array of WP_User objects.
foreach ( $blogusers as $user ) {
	echo '<span>' . esc_html( $user->user_email ) . '</span>';
}
?>