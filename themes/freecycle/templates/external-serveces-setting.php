    <?php wp_nonce_field('update-options'); ?>
    <h2>Amazon API</h2>
    <table class="form-table">
		<tr valign="top">
		<th scope="row">アクセスキーID</th>
		<td>
		<input type="text" name="amazon_accesss_key_id" value="<?php echo get_option('amazon_accesss_key_id'); ?>"> 
		</td>
		</tr>
		<tr valign="top">
		<th scope="row">シークレットアクセスキー</th>
		<td>
		<input type="text" name="amazon_secret_access_key" value="<?php echo get_option('amazon_secret_access_key'); ?>"> 
		</td>
		</tr>
		<tr valign="top">
		<th scope="row">アソシエイトタグ</th>
		<td>
		<input type="text" name="amazon_associate_tag" value="<?php echo get_option('amazon_associate_tag'); ?>"> 
		</td>
		</tr>
    </table>
    <h2>Twitter</h2>
    <table class="form-table">
		<tr valign="top">
		<th scope="row">アカウント作成時ツイート本文</th>
		<td>
		<input type="text" name="twitter_signin_tweet" style="width:700px" maxlength="100"
value="<?php echo get_option('twitter_signin_tweet'); ?>" />
		</td>
		</tr>
    </table>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options"
    	value="amazon_accesss_key_id, amazon_secret_access_key, amazon_associate_tag, twitter_signin_tweet" />
    <p class="submit">
	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>