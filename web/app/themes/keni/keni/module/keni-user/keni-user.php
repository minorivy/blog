<?php

// ユーザープロフィールの項目のカスタマイズ
/**
 * Add user profile
 * @param  array $wb
 * @return array
 */
function keni_user_contactmethods( $wb )
{
	//項目の追加
	$wb['keni_twitter'] = 'Twitter';
	$wb['keni_facebook'] = 'Facebook';
	$wb['keni_instagram'] = 'Instagram';

	return $wb;
}
add_filter('user_contactmethods', 'keni_user_contactmethods', 10, 1);

/**
 * Add user profile
 * @param  object $user
 */
function keni_show_user_profile( $user ) {
	keni_the_media_upload_script();

	$str_get_profile_thumb = get_user_meta( $user->ID, 'keni_profile_thumb', true );
	?>
	<table class="form-table">
	<tr>
	<th><label for="keni_profile_thumb">プロフィールサムネイル</label></th>
	<td>
		<?php echo keni_format_upload( 'keni_profile_thumb', $str_get_profile_thumb, 'image' ); ?>
	</td>
	</tr>

	</table>
<?php }
add_action( 'show_user_profile', 'keni_show_user_profile' );
add_action( 'edit_user_profile', 'keni_show_user_profile' );

/**
 * Save user profile
 * @param  integer $user_id
 */
function keni_save_user_profile( $user_id ) {
	if( isset( $_POST['keni_profile_thumb'] ) ) {
		if ( $_POST[ 'keni_profile_thumb' ] ) {
			if ( is_numeric( $_POST[ 'keni_profile_thumb' ] ) ) {
				update_user_meta( $user_id, 'keni_profile_thumb', $_POST[ 'keni_profile_thumb' ] );
			}
		} else {
			delete_user_meta( $user_id, 'keni_profile_thumb' );
		}
	}
}
add_action( 'profile_update', 'keni_save_user_profile' );