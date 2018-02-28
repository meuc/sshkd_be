<?php
/**
 * WPML Configuration Class
 *
 */

if ( ! class_exists( 'Yogax_WPML_Config' ) ) {

	class Yogax_WPML_Config {

		/**
		 * Start things up
		 *
		 */
		public function __construct() {

			// Add Actions
			add_action( 'admin_init', array( $this, 'yogax_register_strings' ) );
			
			// Add dropdown to widgets
			add_action( 'in_widget_form', array( $this, 'yogax_widget_dropdown' ), 10, 3 );

			// Update dropdown value on widget update
			add_filter( 'widget_update_callback', array( $this, 'yogax_widget_update' ), 10, 4 );
	
			// Filter widgets by language
			add_filter( 'widget_display_callback', array( $this, 'yogax_display_widget' ), 10, 3 );

			// Add Filters
			add_filter( 'upload_dir', array( $this, 'yogax_convert_base_url' ) );
		}

		/**
		 * Registers theme_mod strings into WPML
		 *
		 */
		public function yogax_register_strings() {
			if ( function_exists( 'icl_register_string' ) && $strings = yogax_register_theme_mod_strings() ) {
				foreach( $strings as $string => $default ) {
					icl_register_string( 'Theme Mod', $string, get_theme_mod( $string, $default ) );
				}
			}
		}

		/**
		 * Fix for when users have the Language URL Option on "different domains"
		 * which causes cropped images to fail.
		 * Runs if 'WPML_SUNRISE_MULTISITE_DOMAINS' constant is defined
		 *
		 */
		public function yogax_convert_base_url( $param ) {

			// Check if WPML is set to multisite domains
			if ( defined( 'WPML_SUNRISE_MULTISITE_DOMAINS' ) ) {
				global $sitepress;
				if ( $sitepress ) {
					// Convert upload directory base URL to correct language 
					$param['baseurl'] = $sitepress->convert_url( $param['baseurl'] );
				}
			}

			// Return param
			return $param;

		}
		
		/**
		 * Widget dropdown.
		 *
		 * Add a dropdown to every widget.
		 *
		 * @param	array 	$widget		Widget instance.
		 * @param 	null	$form		Return null if new fields are added.
		 * @param	array	$instance	An array of the widget's settings.
		 */
		public function yogax_widget_dropdown( $widget, $form, $instance ) {
	
			$languages = icl_get_languages();
	
			?><p>
				<label for='wpml_language'><?php esc_html_e( 'Display on language:', 'yogax' ); ?> </label>
				<select id='wpml_language' name='wpml_language'><?php
				foreach ( $languages as $language ) :
	
					$wpml_language = isset( $instance['wpml_language'] ) ? $instance['wpml_language'] : null;
					?><option <?php selected( $language['language_code'], $wpml_language ); ?> value='<?php echo esc_attr($language['language_code']); ?>'><?php
						echo esc_html($language['native_name']);
					?></option><?php
	
				endforeach;
	
				$selected = ( ! isset( $instance['wpml_language'] ) || 'all' == $instance['wpml_language'] ) ? true : false;
				?><option <?php selected( $selected ); ?> value='all'><?php esc_attr_e( 'All Languages', 'yogax' ); ?></option>
	
				</select>
			</p><?php
		}
		
		/**
		 * Update widget.
		 *
		 * Update the value of the dropdown on widget update.
		 *
		 * @param	array 	$instance 		List of data.
		 * @param	array	$new_instance	New instance data.
		 * @param 	array	$old_instance	List of old isntance data.
		 * @param 	array	$this2			Class of ..?.
		 * @return	array					List of modified instance.
		 */
		public function yogax_widget_update( $instance, $new_instance, $old_instance, $this2 ) {
	
			$instance['wpml_language'] = $_POST['wpml_language'];
	
			return $instance;
	
		}
		
		/**
		 * Display widget.
		 *
		 * Filter the widgets.
		 * 
		 * @param	array 	$instance 	List of widget data.
		 * @param	array	$widget		Widget data.
		 * @param 	array	$args		List of args.
		 * @return	array				List of modified widget instance.
		 */
		public function yogax_display_widget( $instance, $widget, $args ) {
	
			if ( isset( $instance['wpml_language'] ) && $instance['wpml_language'] != ICL_LANGUAGE_CODE && $instance['wpml_language'] != 'all' ) :
				return false;
			endif;
	
			return $instance;
	
		}

	}
	
}
new Yogax_WPML_Config();