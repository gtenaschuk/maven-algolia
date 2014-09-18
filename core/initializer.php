<?php

namespace MavenAlgolia\Core;

use \MavenAlgolia\Core\Registry;

class Initializer {

	private static $instance;

	// Register the algolia search js
	public static function init() {

		if ( !self::$instance ) {
			self::$instance = new self();
		}

		add_action( 'wp_enqueue_scripts', array( self::$instance, 'registerScripts' ) );
	}

	public function registerScripts() {
		wp_register_script( 'mvnAlgoliaSearch', Registry::instance()->getPluginUrl() . 'lib/algoliasearch.min.js', array( 'jquery' ), Registry::instance()->getPluginVersion() );

		if ( !is_admin() && Registry::instance()->isEnabled() ) {
			// Front css styles
			wp_register_style( 'mvnAlgoliaPrediction', Registry::instance()->getPluginUrl() . 'front/assets/styles/predictions.css', array(), Registry::instance()->getPluginVersion() );
			wp_enqueue_style( 'mvnAlgoliaPrediction' );

			$adminUrl = admin_url();
			$homeUrl = set_url_scheme( home_url() );
			$uploadDir = wp_upload_dir();
		
			// Front js script
			$settings = array(
				'siteUrl' => $homeUrl,
				'ajaxUrl' => $adminUrl . "admin-ajax.php",
				'uploadDirUrl' => sprintf( '%s/', rtrim($uploadDir['baseurl'], '/') ),
				'appId' => Registry::instance()->getAppId(),
				'apiKeySearch' => Registry::instance()->getApiKeySearch(),
				'indexName' => Registry::instance()->getDefaultIndex(),
				'showPostCategoriesInPopup' => Registry::instance()->showPostCategoriesInPopup(),
				'showExcerptInPopup' => Registry::instance()->showExcerptInPopup(),
				'excerptMaxChars' => Registry::instance()->getExcerptMaxChars(),
				'indexTaxonomies' => Registry::instance()->indexTaxonomies(),
				'postTypesToIndex' => Registry::instance()->getPostTypesToIndex() ? Registry::instance()->getPostTypesToIndex() : array( ),
				'showThumbInPopup' => Registry::instance()->showThumbInPopup(),
				'popupThumbnailArgs' => (Registry::instance()->showThumbInPopup()) ? Registry::instance()->getPopupThumbnailArgs() : array(),
				'defaultThumbSrc' => (Registry::instance()->getDefaultThumbSrc()) ? Registry::instance()->getDefaultThumbSrc() : '',
				'taxonomiesToIndex' => (Registry::instance()->indexTaxonomies()) ? FieldsHelper::getTaxonomiesToIndex() : array(),
				'labels' => array( 'taxonomies' => FieldsHelper::getTaxonomyLabels(), 'posts' => __( 'Posts' ) )
			);
			wp_localize_script( 'mvnAlgoliaSearch', 'mvnAlgSettings', $settings, Registry::instance()->getPluginVersion() );


			wp_register_script( 'mvnAlgoliaPrediction', Registry::instance()->getPluginUrl() . 'front/assets/scripts/predictions.js', array( 'jquery', 'jquery-ui-autocomplete', 'mvnAlgoliaSearch' ), Registry::instance()->getPluginVersion() );
			wp_enqueue_script( 'mvnAlgoliaPrediction' );

			$templates = \MavenAlgolia\Core\Utils::getAlgoliaTemplates();

			$vars = array(
				'inputSearchName' => Registry::instance()->getValue( 'searchInputName' ),
				'containerId' => 'mvn-alg-predictions',
				'postsPerPage' => 5,
//					'labels' => array( 
//										),
			);
			wp_localize_script( 'mvnAlgoliaPrediction', 'mvnAlgSearchVars', $vars, Registry::instance()->getPluginVersion() );
			wp_localize_script( 'mvnAlgoliaPrediction', 'mvnAlgTemplates', $templates, Registry::instance()->getPluginVersion() );
		}
	}

}