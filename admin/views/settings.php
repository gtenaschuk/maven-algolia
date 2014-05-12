<?php 
use MavenAlgolia\Admin\Controllers\Settings; 
use MavenAlgolia\Core; 
$registry = Core\Registry::instance();
$langDomain =   $registry->getPluginShortName();
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2>Maven Algolia Settings</h2>	
	<form action="" method="post">
		<input type="hidden" value="<?php echo Settings::updateAction; ?>" name="mvnAlg_action">
		<?php wp_nonce_field( Settings::updateAction ); ?>
		<table class="widefat" style="width: 75%">
			<thead>
				<tr>
					<th class="row-title" colspan="2"><strong><?php esc_html_e( 'Configure your App Credentials', $langDomain ); ?></strong></th>
				</tr>
			</thead>
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="mvnAlg_appId"><?php esc_html_e( 'APP ID', $langDomain ); ?></label></th>
					<td><input type="text" class="regular-text" value="<?php echo esc_attr(  $registry->getAppId() ); ?>" id="mvnAlg_appId" name="<?php echo Settings::settingsField; ?>[appId]"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="mvnAlg_apiKey"><?php esc_html_e( 'API Key', $langDomain ); ?></label></th>
					<td><input type="text" class="regular-text" value="<?php echo esc_attr(  $registry->getApiKey() ); ?>" id="mvnAlg_apiKey" name="<?php echo Settings::settingsField; ?>[apiKey]"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="mvnAlg_apiKeySearch"><?php esc_html_e( 'API Key for Search Only', $langDomain ); ?></label></th>
					<td><input type="text" class="regular-text" value="<?php echo esc_attr(  $registry->getApiKeySearch() ); ?>" id="mvnAlg_apiKeySearch" name="<?php echo Settings::settingsField; ?>[apiKeySearch]"></td>
				</tr>
				<tr>
					<td>
						<p class="submit"><input type="submit" value="<?php esc_attr_e( 'Save Changes', $langDomain ); ?>" class="button button-primary" id="submit" name="submit"></p>
					</td>
				</tr>
			</tbody>
		</table>
		
		<?php if ( Core\UtilsAlgolia::readyToIndex() ): ?>
		<table class="widefat" style="width: 75%; margin-top: 30px; ">
			<thead>
				<tr>
					<th class="row-title" colspan="2"><strong><?php esc_html_e( 'Index Content', $langDomain ); ?></strong></th>
				</tr>
			</thead>
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="mvnAlg_defaultIndex"><?php esc_html_e( 'Index Name', $langDomain ); ?></label></th>
					<td><input type="text" class="regular-text" value="<?php echo esc_attr(  $registry->getDefaultIndex() ); ?>" id="mvnAlg_defaultIndex" name="<?php echo Settings::settingsField; ?>[defaultIndex]"></td>
				</tr>
				<?php if ( $registry->getDefaultIndex() ): ?>

					<tr valign="top" class="index-action-row index-action-button">
						<th scope="row"><label for="mvnAlg_index"><?php esc_html_e( 'Click to index content', $langDomain ); ?></label></th>
						<td>
							<div class="algolia-action-button" style="width:50%;">
								<button type="button" class="button button-secondary"  id="mvnAlg_index" name="mvnAlg_index"><?php esc_html_e( 'Index Content', $langDomain ); ?></button>
								<span class="spinner algolia-index-spinner"></span>
							</div>
						</td>
					</tr>
					<tr class="index-action-row index-messages">
						<th>&nbsp;</th>
						<td>
							<div class="success"><ul id="mvn-alg-index-result"></ul></div>
							<div class="error error-message" style="display: none;"><p id="mvn-alg-index-error" ></p></div>
						</td>
					</tr>
				<?php else: ?>
					<tr>
						<td colspan="2">
							<p><?php _e( 'Please set an "Index Name" and then update the settings to start indexing content.', $langDomain ) ?></p>
						</td>
					</tr>
				<?php endif; ?>
					<tr>
						<td>
							<p class="submit"><input type="submit" value="<?php esc_attr_e( 'Save Changes', $langDomain ); ?>" class="button button-primary" id="submit" name="submit"></p>
						</td>
					</tr>
			</tbody>
		</table>
		<?php endif; ?>
		</form>
</div>