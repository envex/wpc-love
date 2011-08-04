<div class="wrap">

	<h2>WP Coder Love</h2>
	
	<p>Everyone loves stats!</p>
	
	<h3>10 Most Loved Posts</h3>
	
	<?php
	$most_loved = get_most_loved(10);
	
	if($most_loved): ?>
	
		<ol>

		<?php
		foreach($most_loved as $loved): ?>
			<li><a href="<?php echo get_permalink($loved->post_id); ?>"><?php echo get_the_title($loved->post_id); ?></a></li>
		<?php
		endforeach; ?>	
			
		</ol>
	
	<?php
	endif; ?>
	
<!--
	<form method="post" action="options.php">
	
	    <?php settings_fields( 'jpc_settings_groups' ); ?>
	    
	    <table class="form-table">
	        <tr valign="top">
		        <th scope="row">Twitter Thumbnail Size</th>
		        <td>
		        	<select name="jpc_twitter_thumbnail_size">
		        		<option value="m">24 x 24</option>
		        		<option value="n">48 x 48</option>
		        		<option value="b">73 x 74</option>
		        	</select>
		        	<p><em>Based on the service by: <a href="http://twitter.com/joestump" target="_blank">Joestump</a>'s <a href="http://tweetimag.es/" target="_blank">tweetimag.es</a></em></p>
		        </td>
	        </tr>
	
	    </table>
	    
	    <p class="submit">
	    	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	    </p>
	
	</form>
-->

</div> <!-- wrap -->