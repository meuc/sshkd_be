<?php
/**
 * Customizer controls
 */

/**
 * Alpha Color Picker Customizer Control
 *
 * This control adds a second slider for opacity to the stock WordPress color picker,
 * and it includes logic to seamlessly convert between RGBa and Hex color values as
 * opacity is added to or removed from a color.
 */
class Yogax_Customize_Alpha_Color_Control extends WP_Customize_Control {
	/**
	 * Official control name.
	 */
	public $type = 'alpha-color';
	/**
	 * Add support for palettes to be passed in.
	 *
	 * Supported palette values are true, false, or an array of RGBa and Hex colors.
	 */
	public $palette;
	/**
	 * Add support for showing the opacity value on the slider handle.
	 */
	public $show_opacity;
	/**
	 * Enqueue scripts and styles.
	 *
	 * Ideally these would get registered and given proper paths before this control object
	 * gets initialized, then we could simply enqueue them here, but for completeness as a
	 * stand alone class we'll register and enqueue them here.
	 */
	public function enqueue() {
		wp_enqueue_script(
				'alpha-color-picker',
				get_template_directory_uri() . '/framework/customizer/assets/alpha-color-picker.js',
				array( 'jquery', 'wp-color-picker' ),
				'1.0.0',
				true
		);
		wp_enqueue_style(
				'alpha-color-picker',
				get_template_directory_uri() . '/framework/customizer/assets/alpha-color-picker.css',
				array( 'wp-color-picker' ),
				'1.0.0'
		);
	}
	/**
	 * Render the control.
	 */
	public function render_content() {
		// Process the palette
		if ( is_array( $this->palette ) ) {
			$palette = implode( '|', $this->palette );
		} else {
			// Default to true.
			$palette = ( false === $this->palette || 'false' === $this->palette ) ? 'false' : 'true';
		}
		// Support passing show_opacity as string or boolean. Default to true.
		$show_opacity = ( false === $this->show_opacity || 'false' === $this->show_opacity ) ? 'false' : 'true';
		// Begin the output. ?>
		<label>
			<?php // Output the label and description if they were passed in.
			if ( isset( $this->label ) && '' !== $this->label ) {
				echo '<span class="customize-control-title">' . sanitize_text_field( $this->label ) . '</span>';
			}
			if ( isset( $this->description ) && '' !== $this->description ) {
				echo '<span class="description customize-control-description">' . sanitize_text_field( $this->description ) . '</span>';
			} ?>
			<input class="alpha-color-control" type="text" data-show-opacity="<?php echo esc_attr($show_opacity); ?>" data-palette="<?php echo esc_attr( $palette ); ?>" data-default-color="<?php echo esc_attr( $this->settings['default']->default ); ?>" <?php $this->link(); ?>  />
		</label>
		<?php
	}
}

 /**
 * Slider UI control
 */
class Yogax_Customize_Sliderui_Control extends WP_Customize_Control {
	/**
	 * Official control name.
	 */
	public $type = 'yogax_slider_ui';
	
	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-core', array( 'jquery' ) );
		wp_enqueue_script( 'jquery-ui-slider',array( 'jquery' ) );
	}
	public function render_content() {
		$this_val = $this->value() ? $this->value() : '0'; 
		$this_val = intval($this_val,10); ?>
		<label>
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
			</span>
			<?php if ( '' != $this->description ) { ?>
				<span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
			<?php } ?>
			 <input type="text" id="input_<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr($this_val); ?>" <?php $this->link(); ?>/>
		</label>
		<div id="slider_<?php echo esc_attr($this->id); ?>" class="ttbase-slider-ui"></div>
		<script>
			jQuery(document).ready(function($) {
				$( "#slider_<?php echo esc_js($this->id); ?>" ).slider({
					value : <?php echo esc_js($this_val); ?>,
					min   : <?php echo esc_js($this->choices['min']); ?>,
					max   : <?php echo esc_js($this->choices['max']); ?>,
					step  : <?php echo esc_js($this->choices['step']); ?>,
					slide : function( event, ui ) { $( "#input_<?php echo esc_js($this->id); ?>" ).val(ui.value).keyup(); }
				});
				$( "#input_<?php echo esc_js($this->id); ?>" ).val( $( "#slider_<?php echo esc_js($this->id); ?>" ).slider( "value" ) );
				$( "#input_<?php echo esc_js($this->id); ?>" ).keyup(function() {
					$( "#slider_<?php echo esc_js($this->id); ?>" ).slider( "value", $(this).val() );
				});
			});
		</script>
		<?php
	}
}

/**
 * Adds textarea support to the theme customizer
 */
class Yogax_Customize_Textarea_Control extends WP_Customize_Control {
	public $type = 'textarea';

	public function render_content() {
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		</label>
		<?php
	}
}

/**
 * Google Fonts Control
 *
 */
class Yogax_Fonts_Dropdown_Custom_Control extends WP_Customize_Control {
	public function render_content() {
		$this_val = $this->value(); ?>
	<label>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<select <?php $this->link(); ?>>
			<option value="" <?php if( ! $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Default', 'yogax' ); ?></option>

			<option value="Arial, Helvetica, sans-serif" <?php if( "Arial, Helvetica, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Arial, Helvetica, sans-serif', 'yogax' ); ?></option>
			<option value="Arial Black, Gadget, sans-serif" <?php if( "Arial Black, Gadget, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Arial Black, Gadget, sans-seri', 'yogax' ); ?>f</option>
			<option value="Bookman Old Style, serif" <?php if( "Bookman Old Style, serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bookman Old Style, serif', 'yogax' ); ?></option>
			<option value="Comic Sans MS, cursive" <?php if( "Comic Sans MS, cursive" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Comic Sans MS, cursive', 'yogax' ); ?></option>
			<option value="Courier, monospace" <?php if( "Courier, monospace" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Courier, monospace', 'yogax' ); ?></option>
			<option value="Garamond, serif" <?php if( "Garamond, serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Garamond, serif', 'yogax' ); ?></option>
			<option value="Georgia, serif" <?php if( "Georgia, serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Georgia, serif', 'yogax' ); ?></option>
			<option value="Impact, Charcoal, sans-serif" <?php if( "Impact, Charcoal, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Impact, Charcoal, sans-serif', 'yogax' ); ?></option>
			<option value="Lucida Console, Monaco, monospace" <?php if( "Lucida Console, Monaco, monospace" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lucida Console, Monaco, monospace', 'yogax' ); ?></option>
			<option value="Lucida Sans Unicode, Lucida Grande, sans-serif" <?php if( "Lucida Sans Unicode, Lucida Grande, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lucida Sans Unicode, Lucida Grande, sans-serif', 'yogax' ); ?></option>
			<option value="MS Sans Serif, Geneva, sans-serif" <?php if( "MS Sans Serif, Geneva, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'MS Sans Serif, Geneva, sans-serif', 'yogax' ); ?></option>
			<option value="MS Serif, New York, sans-serif" <?php if( "MS Serif, New York, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'MS Serif, New York, sans-serif', 'yogax' ); ?></option>
			<option value="Palatino Linotype, 'Book Antiqua, Palatino, serif" <?php if( "Palatino Linotype, 'Book Antiqua, Palatino, serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Palatino Linotype, Book Antiqua, Palatino, serif', 'yogax' ); ?></option>
			<option value="Tahoma, Geneva, sans-serif" <?php if( "Tahoma, Geneva, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Tahoma, Geneva, sans-serif', 'yogax' ); ?></option>
			<option value="Times New Roman, Times, serif" <?php if( "Times New Roman, Times, serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Times New Roman, Times, serif', 'yogax' ); ?></option>
			<option value="Trebuchet MS, Helvetica, sans-serif" <?php if( "Trebuchet MS, Helvetica, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Trebuchet MS, Helvetica, sans-serif', 'yogax' ); ?></option>
			<option value="Verdana, Geneva, sans-serif" <?php if( "Verdana, Geneva, sans-serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Verdana, Geneva, sans-serif', 'yogax' ); ?></option>
			<option value="ABeeZee" <?php if( "ABeeZee" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'ABeeZee', 'yogax' ); ?></option>
			<option value="Abel" <?php if( "Abel" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Courier, monospace', 'yogax' ); ?>Abel</option>
			<option value="Abril Fatface" <?php if( "Abril Fatface" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Abril Fatface', 'yogax' ); ?></option>
			<option value="Aclonica" <?php if( "Aclonica" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Aclonica', 'yogax' ); ?></option>
			<option value="Acme" <?php if( "Acme" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Acmee', 'yogax' ); ?></option>
			<option value="Actor" <?php if( "Actor" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Actor', 'yogax' ); ?>Actor</option>
			<option value="Adamina" <?php if( "Adamina" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Adamina', 'yogax' ); ?></option>
			<option value="Advent Pro" <?php if( "Advent Pro" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Advent Pro', 'yogax' ); ?></option>
			<option value="Aguafina Script" <?php if( "Aguafina Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Aguafina Script', 'yogax' ); ?></option>
			<option value="Akronim" <?php if( "Akronim" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Akronim', 'yogax' ); ?></option>
			<option value="Aladin" <?php if( "Aladin" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Aladin', 'yogax' ); ?></option>
			<option value="Aldrich" <?php if( "Aldrich" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Aldrich', 'yogax' ); ?></option>
			<option value="Alef" <?php if( "Alef" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alef', 'yogax' ); ?></option>
			<option value="Alegreya" <?php if( "Alegreya" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alegreya', 'yogax' ); ?></option>
			<option value="Alegreya SC" <?php if( "Alegreya SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alegreya SC', 'yogax' ); ?></option>
			<option value="Alegreya Sans" <?php if( "Alegreya Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alegreya Sans', 'yogax' ); ?></option>
			<option value="Alegreya Sans SC" <?php if( "Alegreya Sans SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alegreya Sans SC', 'yogax' ); ?></option>
			<option value="Alex Brush" <?php if( "Alex Brush" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alex Brush', 'yogax' ); ?></option>
			<option value="Alfa Slab One" <?php if( "Alfa Slab One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alfa Slab One', 'yogax' ); ?></option>
			<option value="Alice" <?php if( "Alice" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alice', 'yogax' ); ?></option>
			<option value="Alike" <?php if( "Alike" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alike', 'yogax' ); ?></option>
			<option value="Alike Angular" <?php if( "Alike Angular" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Alike Angular', 'yogax' ); ?></option>
			<option value="Allan" <?php if( "Allan" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Allan', 'yogax' ); ?></option>
			<option value="Allerta" <?php if( "Allerta" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Allerta', 'yogax' ); ?></option>
			<option value="Allerta Stencil" <?php if( "Allerta Stencil" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Allerta Stencil', 'yogax' ); ?></option>
			<option value="Allura" <?php if( "Allura" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Allura', 'yogax' ); ?></option>
			<option value="Almendra" <?php if( "Almendra" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Almendra', 'yogax' ); ?></option>
			<option value="Almendra Display" <?php if( "Almendra Display" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Almendra Display', 'yogax' ); ?></option>
			<option value="Almendra SC" <?php if( "Almendra SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Almendra SC', 'yogax' ); ?></option>
			<option value="Amarante" <?php if( "Amarante" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Amarante', 'yogax' ); ?></option>
			<option value="Amaranth" <?php if( "Amaranth" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Amaranth', 'yogax' ); ?></option>
			<option value="Amatic SC" <?php if( "Amatic SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Amatic SC', 'yogax' ); ?></option>
			<option value="Amethysta" <?php if( "Amethysta" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Amethysta', 'yogax' ); ?></option>
			<option value="Anaheim" <?php if( "Anaheim" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Anaheim', 'yogax' ); ?></option>
			<option value="Andada" <?php if( "Andada" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Andada', 'yogax' ); ?></option>
			<option value="Andika" <?php if( "Andika" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Andika', 'yogax' ); ?></option>
			<option value="Angkor" <?php if( "Angkor" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Angkor', 'yogax' ); ?></option>
			<option value="Annie Use Your Telescope" <?php if( "Annie Use Your Telescope" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Annie Use Your Telescope', 'yogax' ); ?></option>
			<option value="Anonymous Pro" <?php if( "Anonymous Pro" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Anonymous Pro', 'yogax' ); ?></option>
			<option value="Antic" <?php if( "Antic" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Antic', 'yogax' ); ?></option>
			<option value="Antic Didone" <?php if( "Antic Didone" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Antic Didone', 'yogax' ); ?></option>
			<option value="Antic Slab" <?php if( "Antic Slab" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Antic Slab', 'yogax' ); ?></option>
			<option value="Anton" <?php if( "Anton" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Anton', 'yogax' ); ?></option>
			<option value="Arapey" <?php if( "Arapey" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Arapey', 'yogax' ); ?></option>
			<option value="Arbutus" <?php if( "Arbutus" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Arbutus', 'yogax' ); ?></option>
			<option value="Arbutus Slab" <?php if( "Arbutus Slab" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Arbutus Slab', 'yogax' ); ?></option>
			<option value="Architects Daughter" <?php if( "Architects Daughter" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Architects Daughter', 'yogax' ); ?></option>
			<option value="Archivo Black" <?php if( "Archivo Black" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Archivo Black', 'yogax' ); ?></option>
			<option value="Archivo Narrow" <?php if( "Archivo Narrow" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Archivo Narrow', 'yogax' ); ?></option>
			<option value="Arimo" <?php if( "Arimo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Arimo', 'yogax' ); ?></option>
			<option value="Arizonia" <?php if( "Arizonia" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Arizonia', 'yogax' ); ?></option>
			<option value="Armata" <?php if( "Armata" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Armata', 'yogax' ); ?></option>
			<option value="Artifika" <?php if( "Artifika" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Artifika', 'yogax' ); ?></option>
			<option value="Arvo" <?php if( "Arvo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Arvo', 'yogax' ); ?></option>
			<option value="Asap" <?php if( "Asap" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Asap', 'yogax' ); ?></option>
			<option value="Asset" <?php if( "Asset" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Asset', 'yogax' ); ?></option>
			<option value="Astloch" <?php if( "Astloch" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Astloch', 'yogax' ); ?></option>
			<option value="Asul" <?php if( "Asul" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Asul', 'yogax' ); ?></option>
			<option value="Atomic Age" <?php if( "Atomic Age" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Atomic Age', 'yogax' ); ?></option>
			<option value="Aubrey" <?php if( "Aubrey" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Aubrey', 'yogax' ); ?></option>
			<option value="Audiowide" <?php if( "Audiowide" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Audiowide', 'yogax' ); ?></option>
			<option value="Autour One" <?php if( "Autour One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Autour One', 'yogax' ); ?></option>
			<option value="Average" <?php if( "Average" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Average', 'yogax' ); ?></option>
			<option value="Average Sans" <?php if( "Average Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Average Sans', 'yogax' ); ?></option>
			<option value="Averia Gruesa Libre" <?php if( "Averia Gruesa Libre" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Averia Gruesa Libre', 'yogax' ); ?></option>
			<option value="Averia Libre" <?php if( "Averia Libre" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Averia Libre', 'yogax' ); ?></option>
			<option value="Averia Sans Libre" <?php if( "Averia Sans Libre" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Averia Sans Libre', 'yogax' ); ?></option>
			<option value="Averia Serif Libre" <?php if( "Averia Serif Libre" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Averia Serif Libre', 'yogax' ); ?></option>
			<option value="Bad Script" <?php if( "Bad Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bad Script', 'yogax' ); ?></option>
			<option value="Balthazar" <?php if( "Balthazar" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Balthazar', 'yogax' ); ?></option>
			<option value="Bangers" <?php if( "Bangers" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bangers', 'yogax' ); ?></option>
			<option value="Basic" <?php if( "Basic" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Basic', 'yogax' ); ?></option>
			<option value="Battambang" <?php if( "Battambang" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Battambang', 'yogax' ); ?></option>
			<option value="Baumans" <?php if( "Baumans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Baumans', 'yogax' ); ?></option>
			<option value="Bayon" <?php if( "Bayon" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bayon', 'yogax' ); ?></option>
			<option value="Belgrano" <?php if( "Belgrano" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Belgrano', 'yogax' ); ?></option>
			<option value="Belleza" <?php if( "Belleza" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Belleza', 'yogax' ); ?></option>
			<option value="BenchNine" <?php if( "BenchNine" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'BenchNine', 'yogax' ); ?></option>
			<option value="Bentham" <?php if( "Bentham" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bentham', 'yogax' ); ?></option>
			<option value="Berkshire Swash" <?php if( "Berkshire Swash" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Berkshire Swash', 'yogax' ); ?></option>
			<option value="Bevan" <?php if( "Bevan" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bevan', 'yogax' ); ?></option>
			<option value="Bigelow Rules" <?php if( "Bigelow Rules" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bigelow Rules', 'yogax' ); ?></option>
			<option value="Bigshot One" <?php if( "Bigshot One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bigshot One', 'yogax' ); ?></option>
			<option value="Bilbo" <?php if( "Bilbo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bilbo', 'yogax' ); ?></option>
			<option value="Bilbo Swash Caps" <?php if( "Bilbo Swash Caps" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bilbo Swash Caps', 'yogax' ); ?></option>
			<option value="Bitter" <?php if( "Bitter" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bitter', 'yogax' ); ?></option>
			<option value="Black Ops One" <?php if( "Black Ops One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Black Ops One', 'yogax' ); ?></option>
			<option value="Bokor" <?php if( "Bokor" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bokor', 'yogax' ); ?></option>
			<option value="Bonbon" <?php if( "Bonbon" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bonbon', 'yogax' ); ?></option>
			<option value="Boogaloo" <?php if( "Boogaloo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Boogaloo', 'yogax' ); ?></option>
			<option value="Bowlby One" <?php if( "Bowlby One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bowlby One', 'yogax' ); ?></option>
			<option value="Bowlby One SC" <?php if( "Bowlby One SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bowlby One SC', 'yogax' ); ?></option>
			<option value="Brawler" <?php if( "Brawler" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Brawler', 'yogax' ); ?></option>
			<option value="Bree Serif" <?php if( "Bree Serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bree Serif', 'yogax' ); ?></option>
			<option value="Bubblegum Sans" <?php if( "Bubblegum Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bubblegum Sans', 'yogax' ); ?></option>
			<option value="Bubbler One" <?php if( "Bubbler One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Bubbler One', 'yogax' ); ?></option>
			<option value="Buda" <?php if( "Buda" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Buda', 'yogax' ); ?></option>
			<option value="Buenard" <?php if( "Buenard" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Buenard', 'yogax' ); ?></option>
			<option value="Butcherman" <?php if( "Butcherman" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Butcherman', 'yogax' ); ?></option>
			<option value="Butterfly Kids" <?php if( "Butterfly Kids" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Butterfly Kids', 'yogax' ); ?></option>
			<option value="Cabin" <?php if( "Cabin" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cabin', 'yogax' ); ?></option>
			<option value="Cabin Condensed" <?php if( "Cabin Condensed" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cabin Condensed', 'yogax' ); ?></option>
			<option value="Cabin Sketch" <?php if( "Cabin Sketch" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cabin Sketch', 'yogax' ); ?></option>
			<option value="Caesar Dressing" <?php if( "Caesar Dressing" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Caesar Dressing', 'yogax' ); ?></option>
			<option value="Cagliostro" <?php if( "Cagliostro" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cagliostro', 'yogax' ); ?></option>
			<option value="Calligraffitti" <?php if( "Calligraffitti" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Calligraffitti', 'yogax' ); ?></option>
			<option value="Cambo" <?php if( "Cambo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cambo', 'yogax' ); ?></option>
			<option value="Candal" <?php if( "Candal" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Candal', 'yogax' ); ?></option>
			<option value="Cantarell" <?php if( "Cantarell" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cantarell', 'yogax' ); ?></option>
			<option value="Cantata One" <?php if( "Cantata One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cantata One', 'yogax' ); ?></option>
			<option value="Cantora One" <?php if( "Cantora One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cantora One', 'yogax' ); ?></option>
			<option value="Capriola" <?php if( "Capriola" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Capriola', 'yogax' ); ?></option>
			<option value="Cardo" <?php if( "Cardo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cardo', 'yogax' ); ?></option>
			<option value="Carme" <?php if( "Carme" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Carme', 'yogax' ); ?></option>
			<option value="Carrois Gothic" <?php if( "Carrois Gothic" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Carrois Gothic', 'yogax' ); ?></option>
			<option value="Carrois Gothic SC" <?php if( "Carrois Gothic SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Carrois Gothic SC', 'yogax' ); ?></option>
			<option value="Carter One" <?php if( "Carter One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Carter One', 'yogax' ); ?></option>
			<option value="Caudex" <?php if( "Caudex" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Caudex', 'yogax' ); ?></option>
			<option value="Cedarville Cursive" <?php if( "Cedarville Cursive" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cedarville Cursive', 'yogax' ); ?></option>
			<option value="Ceviche One" <?php if( "Ceviche One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ceviche One', 'yogax' ); ?></option>
			<option value="Changa One" <?php if( "Changa One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Changa One', 'yogax' ); ?></option>
			<option value="Chango" <?php if( "Chango" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Chango', 'yogax' ); ?></option>
			<option value="Chau Philomene One" <?php if( "Chau Philomene One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Chau Philomene One', 'yogax' ); ?></option>
			<option value="Chela One" <?php if( "Chela One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Chela One', 'yogax' ); ?></option>
			<option value="Chelsea Market" <?php if( "Chelsea Market" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Chelsea Market', 'yogax' ); ?></option>
			<option value="Chenla" <?php if( "Chenla" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Chenla', 'yogax' ); ?></option>
			<option value="Cherry Cream Soda" <?php if( "Cherry Cream Soda" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cherry Cream Soda', 'yogax' ); ?></option>
			<option value="Cherry Swash" <?php if( "Cherry Swash" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cherry Swash', 'yogax' ); ?></option>
			<option value="Chewy" <?php if( "Chewy" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Chewy', 'yogax' ); ?></option>
			<option value="Chicle" <?php if( "Chicle" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Chicle', 'yogax' ); ?></option>
			<option value="Chivo" <?php if( "Chivo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Chivo', 'yogax' ); ?></option>
			<option value="Cinzel" <?php if( "Cinzel" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cinzel', 'yogax' ); ?></option>
			<option value="Cinzel Decorative" <?php if( "Cinzel Decorative" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cinzel Decorative', 'yogax' ); ?></option>
			<option value="Clicker Script" <?php if( "Clicker Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Clicker Script', 'yogax' ); ?></option>
			<option value="Coda" <?php if( "Coda" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Coda', 'yogax' ); ?></option>
			<option value="Coda Caption" <?php if( "Coda Caption" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Coda Caption', 'yogax' ); ?></option>
			<option value="Codystar" <?php if( "Codystar" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Codystar', 'yogax' ); ?></option>
			<option value="Combo" <?php if( "Combo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Combo', 'yogax' ); ?></option>
			<option value="Comfortaa" <?php if( "Comfortaa" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Comfortaa', 'yogax' ); ?></option>
			<option value="Coming Soon" <?php if( "Coming Soon" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Coming Soon', 'yogax' ); ?></option>
			<option value="Concert One" <?php if( "Concert One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Concert One', 'yogax' ); ?></option>
			<option value="Condiment" <?php if( "Condiment" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Condiment', 'yogax' ); ?></option>
			<option value="Content" <?php if( "Content" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Content', 'yogax' ); ?></option>
			<option value="Contrail One" <?php if( "Contrail One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Contrail One', 'yogax' ); ?></option>
			<option value="Convergence" <?php if( "Convergence" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Convergence', 'yogax' ); ?></option>
			<option value="Cookie" <?php if( "Cookie" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cookie', 'yogax' ); ?></option>
			<option value="Copse" <?php if( "Copse" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Copse', 'yogax' ); ?></option>
			<option value="Corben" <?php if( "Corben" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Corben', 'yogax' ); ?></option>
			<option value="Courgette" <?php if( "Courgette" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Courgette', 'yogax' ); ?></option>
			<option value="Cousine" <?php if( "Cousine" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cousine', 'yogax' ); ?></option>
			<option value="Coustard" <?php if( "Coustard" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Coustard', 'yogax' ); ?></option>
			<option value="Covered By Your Grace" <?php if( "Covered By Your Grace" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Covered By Your Grace', 'yogax' ); ?></option>
			<option value="Crafty Girls" <?php if( "Crafty Girls" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Crafty Girls', 'yogax' ); ?></option>
			<option value="Creepster" <?php if( "Creepster" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Creepster', 'yogax' ); ?></option>
			<option value="Crete Round" <?php if( "Crete Round" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Crete Round', 'yogax' ); ?></option>
			<option value="Crimson Text" <?php if( "Crimson Text" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Crimson Text', 'yogax' ); ?></option>
			<option value="Croissant One" <?php if( "Croissant One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Croissant One', 'yogax' ); ?></option>
			<option value="Crushed" <?php if( "Crushed" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Crushed', 'yogax' ); ?></option>
			<option value="Cuprum" <?php if( "Cuprum" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cuprum', 'yogax' ); ?></option>
			<option value="Cutive" <?php if( "Cutive" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cutive', 'yogax' ); ?></option>
			<option value="Cutive Mono" <?php if( "Cutive Mono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Cutive Mono', 'yogax' ); ?></option>
			<option value="Damion" <?php if( "Damion" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Damion', 'yogax' ); ?></option>
			<option value="Dancing Script" <?php if( "Dancing Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Dancing Script', 'yogax' ); ?></option>
			<option value="Dangrek" <?php if( "Dangrek" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Dangrek', 'yogax' ); ?></option>
			<option value="Dawning of a New Day" <?php if( "Dawning of a New Day" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Dawning of a New Day', 'yogax' ); ?></option>
			<option value="Days One" <?php if( "Days One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Days One', 'yogax' ); ?></option>
			<option value="Delius" <?php if( "Delius" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Delius', 'yogax' ); ?></option>
			<option value="Delius Swash Caps" <?php if( "Delius Swash Caps" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Delius Swash Caps', 'yogax' ); ?></option>
			<option value="Delius Unicase" <?php if( "Delius Unicase" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Delius Unicase', 'yogax' ); ?></option>
			<option value="Della Respira" <?php if( "Della Respira" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Della Respira', 'yogax' ); ?></option>
			<option value="Denk One" <?php if( "Denk One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Denk One', 'yogax' ); ?></option>
			<option value="Devonshire" <?php if( "Devonshire" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Devonshire', 'yogax' ); ?></option>
			<option value="Didact Gothic" <?php if( "Didact Gothic" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Didact Gothic', 'yogax' ); ?></option>
			<option value="Diplomata" <?php if( "Diplomata" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Diplomata', 'yogax' ); ?></option>
			<option value="Diplomata SC" <?php if( "Diplomata SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Diplomata SC', 'yogax' ); ?></option>
			<option value="Domine" <?php if( "Domine" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Domine', 'yogax' ); ?></option>
			<option value="Donegal One" <?php if( "Donegal One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Donegal One', 'yogax' ); ?></option>
			<option value="Doppio One" <?php if( "Doppio One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Doppio One', 'yogax' ); ?></option>
			<option value="Dorsa" <?php if( "Dorsa" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Dorsa', 'yogax' ); ?></option>
			<option value="Dosis" <?php if( "Dosis" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Dosis', 'yogax' ); ?></option>
			<option value="Dr Sugiyama" <?php if( "Dr Sugiyama" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Dr Sugiyama', 'yogax' ); ?></option>
			<option value="Droid Sans" <?php if( "Droid Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Droid Sans', 'yogax' ); ?></option>
			<option value="Droid Sans Mono" <?php if( "Droid Sans Mono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Droid Sans Mono', 'yogax' ); ?></option>
			<option value="Droid Serif" <?php if( "Droid Serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Droid Serif', 'yogax' ); ?></option>
			<option value="Duru Sans" <?php if( "Duru Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Duru Sans', 'yogax' ); ?></option>
			<option value="Dynalight" <?php if( "Dynalight" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Dynalight', 'yogax' ); ?></option>
			<option value="EB Garamond" <?php if( "EB Garamond" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'EB Garamond', 'yogax' ); ?></option>
			<option value="Eagle Lake" <?php if( "Eagle Lake" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Eagle Lake', 'yogax' ); ?></option>
			<option value="Eater" <?php if( "Eater" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Eater', 'yogax' ); ?></option>
			<option value="Economica" <?php if( "Economica" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Economica', 'yogax' ); ?></option>
			<option value="Ek Mukta" <?php if( "Ek Mukta" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ek Mukta', 'yogax' ); ?></option>
			<option value="Electrolize" <?php if( "Electrolize" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Electrolize', 'yogax' ); ?></option>
			<option value="Elsie" <?php if( "Elsie" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Elsie', 'yogax' ); ?></option>
			<option value="Elsie Swash Caps" <?php if( "Elsie Swash Caps" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Elsie Swash Caps', 'yogax' ); ?></option>
			<option value="Emblema One" <?php if( "Emblema One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Emblema One', 'yogax' ); ?></option>
			<option value="Emilys Candy" <?php if( "Emilys Candy" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Emilys Candy', 'yogax' ); ?></option>
			<option value="Engagement" <?php if( "Engagement" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Engagement', 'yogax' ); ?></option>
			<option value="Englebert" <?php if( "Englebert" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Englebert', 'yogax' ); ?></option>
			<option value="Enriqueta" <?php if( "Enriqueta" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Enriqueta', 'yogax' ); ?></option>
			<option value="Erica One" <?php if( "Erica One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Erica One', 'yogax' ); ?></option>
			<option value="Esteban" <?php if( "Esteban" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Esteban', 'yogax' ); ?></option>
			<option value="Euphoria Script" <?php if( "Euphoria Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Euphoria Script', 'yogax' ); ?></option>
			<option value="Ewert" <?php if( "Ewert" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ewert', 'yogax' ); ?></option>
			<option value="Exo" <?php if( "Exo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Exo', 'yogax' ); ?></option>
			<option value="Exo 2" <?php if( "Exo 2" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Exo 2', 'yogax' ); ?></option>
			<option value="Expletus Sans" <?php if( "Expletus Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Expletus Sans', 'yogax' ); ?></option>
			<option value="Fanwood Text" <?php if( "Fanwood Text" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fanwood Text', 'yogax' ); ?></option>
			<option value="Fascinate" <?php if( "Fascinate" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fascinate', 'yogax' ); ?></option>
			<option value="Fascinate Inline" <?php if( "Fascinate Inline" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fascinate Inline', 'yogax' ); ?></option>
			<option value="Faster One" <?php if( "Faster One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Faster One', 'yogax' ); ?></option>
			<option value="Fasthand" <?php if( "Fasthand" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fasthand', 'yogax' ); ?></option>
			<option value="Fauna One" <?php if( "Fauna One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fauna One', 'yogax' ); ?></option>
			<option value="Federant" <?php if( "Federant" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Federant', 'yogax' ); ?></option>
			<option value="Federo" <?php if( "Federo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Federo', 'yogax' ); ?></option>
			<option value="Felipa" <?php if( "Felipa" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Felipa', 'yogax' ); ?></option>
			<option value="Fenix" <?php if( "Fenix" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fenix', 'yogax' ); ?></option>
			<option value="Finger Paint" <?php if( "Finger Paint" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Finger Paint', 'yogax' ); ?></option>
			<option value="Fira Mono" <?php if( "Fira Mono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fira Mono', 'yogax' ); ?></option>
			<option value="Fira Sans" <?php if( "Fira Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fira Sans', 'yogax' ); ?></option>
			<option value="Fjalla One" <?php if( "Fjalla One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fjalla One', 'yogax' ); ?></option>
			<option value="Fjord One" <?php if( "Fjord One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fjord One', 'yogax' ); ?></option>
			<option value="Flamenco" <?php if( "Flamenco" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Flamenco', 'yogax' ); ?></option>
			<option value="Flavors" <?php if( "Flavors" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Flavors', 'yogax' ); ?></option>
			<option value="Fondamento" <?php if( "Fondamento" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fondamento', 'yogax' ); ?></option>
			<option value="Fontdiner Swanky" <?php if( "Fontdiner Swanky" == $this_val ) echo 'selected="selected"'; ?>>Fontdiner Swanky</option>
			<option value="Forum" <?php if( "Forum" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Forum', 'yogax' ); ?></option>
			<option value="Francois One" <?php if( "Francois One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Francois One', 'yogax' ); ?></option>
			<option value="Freckle Face" <?php if( "Freckle Face" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Freckle Face', 'yogax' ); ?></option>
			<option value="Fredericka the Great" <?php if( "Fredericka the Great" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fredericka the Great', 'yogax' ); ?></option>
			<option value="Fredoka One" <?php if( "Fredoka One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fredoka One', 'yogax' ); ?></option>
			<option value="Freehand" <?php if( "Freehand" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Freehand', 'yogax' ); ?></option>
			<option value="Fresca" <?php if( "Fresca" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fresca', 'yogax' ); ?></option>
			<option value="Frijole" <?php if( "Frijole" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Frijole', 'yogax' ); ?></option>
			<option value="Fruktur" <?php if( "Fruktur" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fruktur', 'yogax' ); ?></option>
			<option value="Fugaz One" <?php if( "Fugaz One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Fugaz One', 'yogax' ); ?></option>
			<option value="GFS Didot" <?php if( "GFS Didot" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'GFS Didot', 'yogax' ); ?></option>
			<option value="GFS Neohellenic" <?php if( "GFS Neohellenic" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'GFS Neohellenic', 'yogax' ); ?></option>
			<option value="Gabriela" <?php if( "Gabriela" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gabriela', 'yogax' ); ?></option>
			<option value="Gafata" <?php if( "Gafata" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gafata', 'yogax' ); ?></option>
			<option value="Galdeano" <?php if( "Galdeano" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Galdeano', 'yogax' ); ?></option>
			<option value="Galindo" <?php if( "Galindo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Galindo', 'yogax' ); ?></option>
			<option value="Gentium Basic" <?php if( "Gentium Basic" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gentium Basic', 'yogax' ); ?></option>
			<option value="Gentium Book Basic" <?php if( "Gentium Book Basic" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gentium Book Basic', 'yogax' ); ?></option>
			<option value="Geo" <?php if( "Geo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Geo', 'yogax' ); ?></option>
			<option value="Geostar" <?php if( "Geostar" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Geostar', 'yogax' ); ?></option>
			<option value="Geostar Fill" <?php if( "Geostar Fill" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Geostar Fill', 'yogax' ); ?></option>
			<option value="Germania One" <?php if( "Germania One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Germania One', 'yogax' ); ?></option>
			<option value="Gilda Display" <?php if( "Gilda Display" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gilda Display', 'yogax' ); ?></option>
			<option value="Give You Glory" <?php if( "Give You Glory" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Give You Glory', 'yogax' ); ?></option>
			<option value="Glass Antiqua" <?php if( "Glass Antiqua" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Glass Antiqua', 'yogax' ); ?></option>
			<option value="Glegoo" <?php if( "Glegoo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Glegoo', 'yogax' ); ?></option>
			<option value="Gloria Hallelujah" <?php if( "Gloria Hallelujah" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gloria Hallelujah', 'yogax' ); ?></option>
			<option value="Goblin One" <?php if( "Goblin One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Goblin One', 'yogax' ); ?></option>
			<option value="Gochi Hand" <?php if( "Gochi Hand" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gochi Hand', 'yogax' ); ?></option>
			<option value="Gorditas" <?php if( "Gorditas" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gorditas', 'yogax' ); ?></option>
			<option value="Goudy Bookletter 1911" <?php if( "Goudy Bookletter 1911" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Goudy Bookletter 1911', 'yogax' ); ?></option>
			<option value="Graduate" <?php if( "Graduate" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Graduate', 'yogax' ); ?></option>
			<option value="Grand Hotel" <?php if( "Grand Hotel" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Grand Hotel', 'yogax' ); ?></option>
			<option value="Gravitas One" <?php if( "Gravitas One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gravitas One', 'yogax' ); ?></option>
			<option value="Great Vibes" <?php if( "Great Vibes" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Great Vibes', 'yogax' ); ?></option>
			<option value="Griffy" <?php if( "Griffy" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Griffy', 'yogax' ); ?></option>
			<option value="Gruppo" <?php if( "Gruppo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gruppo', 'yogax' ); ?></option>
			<option value="Gudea" <?php if( "Gudea" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Gudea', 'yogax' ); ?></option>
			<option value="Habibi" <?php if( "Habibi" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Habibi', 'yogax' ); ?></option>
			<option value="Halant" <?php if( "Halant" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Halant', 'yogax' ); ?></option>
			<option value="Hammersmith One" <?php if( "Hammersmith One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Hammersmith One', 'yogax' ); ?></option>
			<option value="Hanalei" <?php if( "Hanalei" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Hanalei', 'yogax' ); ?></option>
			<option value="Hanalei Fill" <?php if( "Hanalei Fill" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Hanalei Fill', 'yogax' ); ?></option>
			<option value="Handlee" <?php if( "Handlee" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Handlee', 'yogax' ); ?></option>
			<option value="Hanuman" <?php if( "Hanuman" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Hanuman', 'yogax' ); ?></option>
			<option value="Happy Monkey" <?php if( "Happy Monkey" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Happy Monkey', 'yogax' ); ?></option>
			<option value="Headland One" <?php if( "Headland One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Headland One', 'yogax' ); ?></option>
			<option value="Henny Penny" <?php if( "Henny Penny" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Henny Penny', 'yogax' ); ?></option>
			<option value="Herr Von Muellerhoff" <?php if( "Herr Von Muellerhoff" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Herr Von Muellerhoff', 'yogax' ); ?></option>
			<option value="Hind" <?php if( "Hind" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Hind', 'yogax' ); ?></option>
			<option value="Holtwood One SC" <?php if( "Holtwood One SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Holtwood One SC', 'yogax' ); ?></option>
			<option value="Homemade Apple" <?php if( "Homemade Apple" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Homemade Apple', 'yogax' ); ?></option>
			<option value="Homenaje" <?php if( "Homenaje" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Homenaje', 'yogax' ); ?></option>
			<option value="IM Fell DW Pica" <?php if( "IM Fell DW Pica" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell DW Pica', 'yogax' ); ?></option>
			<option value="IM Fell DW Pica SC" <?php if( "IM Fell DW Pica SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell DW Pica SC', 'yogax' ); ?></option>
			<option value="IM Fell Double Pica" <?php if( "IM Fell Double Pica" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell Double Pica', 'yogax' ); ?></option>
			<option value="IM Fell Double Pica SC" <?php if( "IM Fell Double Pica SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell Double Pica SC', 'yogax' ); ?></option>
			<option value="IM Fell English" <?php if( "IM Fell English" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell English', 'yogax' ); ?></option>
			<option value="IM Fell English SC" <?php if( "IM Fell English SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell English SC', 'yogax' ); ?></option>
			<option value="IM Fell French Canon" <?php if( "IM Fell French Canon" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell French Canon', 'yogax' ); ?></option>
			<option value="IM Fell French Canon SC" <?php if( "IM Fell French Canon SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell French Canon SC', 'yogax' ); ?></option>
			<option value="IM Fell Great Primer" <?php if( "IM Fell Great Primer" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell Great Primer', 'yogax' ); ?></option>
			<option value="IM Fell Great Primer SC" <?php if( "IM Fell Great Primer SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'IM Fell Great Primer SC', 'yogax' ); ?></option>
			<option value="Iceberg" <?php if( "Iceberg" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Iceberg', 'yogax' ); ?></option>
			<option value="Iceland" <?php if( "Iceland" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Iceland', 'yogax' ); ?></option>
			<option value="Imprima" <?php if( "Imprima" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Imprima', 'yogax' ); ?></option>
			<option value="Inconsolata" <?php if( "Inconsolata" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Inconsolata', 'yogax' ); ?></option>
			<option value="Inder" <?php if( "Inder" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Inder', 'yogax' ); ?></option>
			<option value="Indie Flower" <?php if( "Indie Flower" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Indie Flower', 'yogax' ); ?></option>
			<option value="Inika" <?php if( "Inika" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Inika', 'yogax' ); ?></option>
			<option value="Irish Grover" <?php if( "Irish Grover" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Irish Grover', 'yogax' ); ?></option>
			<option value="Istok Web" <?php if( "Istok Web" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Istok Web', 'yogax' ); ?></option>
			<option value="Italiana" <?php if( "Italiana" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Italiana', 'yogax' ); ?></option>
			<option value="Italianno" <?php if( "Italianno" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Italianno', 'yogax' ); ?></option>
			<option value="Jacques Francois" <?php if( "Jacques Francois" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Jacques Francois', 'yogax' ); ?></option>
			<option value="Jacques Francois Shadow" <?php if( "Jacques Francois Shadow" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Jacques Francois Shadow', 'yogax' ); ?></option>
			<option value="Jim Nightshade" <?php if( "Jim Nightshade" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Jim Nightshade', 'yogax' ); ?></option>
			<option value="Jockey One" <?php if( "Jockey One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( '>Jockey One', 'yogax' ); ?></option>
			<option value="Jolly Lodger" <?php if( "Jolly Lodger" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( '>Jolly Lodger', 'yogax' ); ?></option>
			<option value="Josefin Sans" <?php if( "Josefin Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( '>Josefin Sans', 'yogax' ); ?></option>
			<option value="Josefin Slab" <?php if( "Josefin Slab" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Josefin Slab', 'yogax' ); ?></option>
			<option value="Joti One" <?php if( "Joti One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Joti One', 'yogax' ); ?></option>
			<option value="Judson" <?php if( "Judson" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Judson', 'yogax' ); ?></option>
			<option value="Julee" <?php if( "Julee" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Julee', 'yogax' ); ?></option>
			<option value="Julius Sans One" <?php if( "Julius Sans One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Julius Sans One', 'yogax' ); ?></option>
			<option value="Junge" <?php if( "Junge" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Junge', 'yogax' ); ?></option>
			<option value="Jura" <?php if( "Jura" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Jura', 'yogax' ); ?></option>
			<option value="Just Another Hand" <?php if( "Just Another Hand" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Just Another Hand', 'yogax' ); ?></option>
			<option value="Just Me Again Down Here" <?php if( "Just Me Again Down Here" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Just Me Again Down Here', 'yogax' ); ?></option>
			<option value="Kalam" <?php if( "Kalam" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kalam', 'yogax' ); ?></option>
			<option value="Kameron" <?php if( "Kameron" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kameron', 'yogax' ); ?></option>
			<option value="Kantumruy" <?php if( "Kantumruy" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kantumruy', 'yogax' ); ?></option>
			<option value="Karla" <?php if( "Karla" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Karla', 'yogax' ); ?></option>
			<option value="Karma" <?php if( "Karma" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Karma', 'yogax' ); ?></option>
			<option value="Kaushan Script" <?php if( "Kaushan Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kaushan Script', 'yogax' ); ?></option>
			<option value="Kavoon" <?php if( "Kavoon" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kavoon', 'yogax' ); ?></option>
			<option value="Kdam Thmor" <?php if( "Kdam Thmor" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kdam Thmor', 'yogax' ); ?></option>
			<option value="Keania One" <?php if( "Keania One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Keania One', 'yogax' ); ?></option>
			<option value="Kelly Slab" <?php if( "Kelly Slab" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kelly Slab', 'yogax' ); ?></option>
			<option value="Kenia" <?php if( "Kenia" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kenia', 'yogax' ); ?></option>
			<option value="Khand" <?php if( "Khand" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Khand', 'yogax' ); ?></option>
			<option value="Khmer" <?php if( "Khmer" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Khmer', 'yogax' ); ?></option>
			<option value="Kite One" <?php if( "Kite One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kite One', 'yogax' ); ?></option>
			<option value="Knewave" <?php if( "Knewave" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Knewave', 'yogax' ); ?></option>
			<option value="Kotta One" <?php if( "Kotta One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kotta One', 'yogax' ); ?></option>
			<option value="Koulen" <?php if( "Koulen" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Koulen', 'yogax' ); ?></option>
			<option value="Kranky" <?php if( "Kranky" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kranky', 'yogax' ); ?></option>
			<option value="Kreon" <?php if( "Kreon" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kreon', 'yogax' ); ?></option>
			<option value="Kristi" <?php if( "Kristi" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Kristi', 'yogax' ); ?></option>
			<option value="Krona One" <?php if( "Krona One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Krona One', 'yogax' ); ?></option>
			<option value="La Belle Aurore" <?php if( "La Belle Aurore" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'La Belle Aurore', 'yogax' ); ?></option>
			<option value="Laila" <?php if( "Laila" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Laila', 'yogax' ); ?></option>
			<option value="Lancelot" <?php if( "Lancelot" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lancelot', 'yogax' ); ?></option>
			<option value="Lato" <?php if( "Lato" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lato', 'yogax' ); ?></option>
			<option value="League Script" <?php if( "League Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'League Script', 'yogax' ); ?></option>
			<option value="Leckerli One" <?php if( "Leckerli One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Leckerli One', 'yogax' ); ?></option>
			<option value="Ledger" <?php if( "Ledger" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ledger', 'yogax' ); ?></option>
			<option value="Lekton" <?php if( "Lekton" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lekton', 'yogax' ); ?></option>
			<option value="Lemon" <?php if( "Lemon" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lemon', 'yogax' ); ?></option>
			<option value="Libre Baskerville" <?php if( "Libre Baskerville" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Libre Baskerville', 'yogax' ); ?></option>
			<option value="Life Savers" <?php if( "Life Savers" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Life Savers', 'yogax' ); ?></option>
			<option value="Lilita One" <?php if( "Lilita One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lilita One', 'yogax' ); ?></option>
			<option value="Lily Script One" <?php if( "Lily Script One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lily Script One', 'yogax' ); ?></option>
			<option value="Limelight" <?php if( "Limelight" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Limelight', 'yogax' ); ?></option>
			<option value="Linden Hill" <?php if( "Linden Hill" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Linden Hill', 'yogax' ); ?></option>
			<option value="Lobster" <?php if( "Lobster" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lobster', 'yogax' ); ?></option>
			<option value="Lobster Two" <?php if( "Lobster Two" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lobster Two', 'yogax' ); ?></option>
			<option value="Londrina Outline" <?php if( "Londrina Outline" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Londrina Outline', 'yogax' ); ?></option>
			<option value="Londrina Shadow" <?php if( "Londrina Shadow" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Londrina Shadow', 'yogax' ); ?></option>
			<option value="Londrina Sketch" <?php if( "Londrina Sketch" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Londrina Sketch', 'yogax' ); ?></option>
			<option value="Londrina Solid" <?php if( "Londrina Solid" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Londrina Solid', 'yogax' ); ?></option>
			<option value="Lora" <?php if( "Lora" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lora', 'yogax' ); ?></option>
			<option value="Love Ya Like A Sister" <?php if( "Love Ya Like A Sister" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Love Ya Like A Sister', 'yogax' ); ?></option>
			<option value="Loved by the King" <?php if( "Loved by the King" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Loved by the King', 'yogax' ); ?></option>
			<option value="Lovers Quarrel" <?php if( "Lovers Quarrel" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lovers Quarrel', 'yogax' ); ?></option>
			<option value="Luckiest Guy" <?php if( "Luckiest Guy" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Luckiest Guy', 'yogax' ); ?></option>
			<option value="Lusitana" <?php if( "Lusitana" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lusitana', 'yogax' ); ?></option>
			<option value="Lustria" <?php if( "Lustria" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Lustria', 'yogax' ); ?></option>
			<option value="Macondo" <?php if( "Macondo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Macondo', 'yogax' ); ?></option>
			<option value="Macondo Swash Caps" <?php if( "Macondo Swash Caps" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Macondo Swash Caps', 'yogax' ); ?></option>
			<option value="Magra" <?php if( "Magra" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Magra', 'yogax' ); ?></option>
			<option value="Maiden Orange" <?php if( "Maiden Orange" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Maiden Orange', 'yogax' ); ?></option>
			<option value="Mako" <?php if( "Mako" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mako', 'yogax' ); ?></option>
			<option value="Marcellus" <?php if( "Marcellus" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Marcellus', 'yogax' ); ?></option>
			<option value="Marcellus SC" <?php if( "Marcellus SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Marcellus SC', 'yogax' ); ?></option>
			<option value="Marck Script" <?php if( "Marck Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Marck Script', 'yogax' ); ?></option>
			<option value="Margarine" <?php if( "Margarine" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Margarine', 'yogax' ); ?></option>
			<option value="Marko One" <?php if( "Marko One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Marko One', 'yogax' ); ?></option>
			<option value="Marmelad" <?php if( "Marmelad" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Marmelad', 'yogax' ); ?></option>
			<option value="Marvel" <?php if( "Marvel" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Marvel', 'yogax' ); ?></option>
			<option value="Mate" <?php if( "Mate" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mate', 'yogax' ); ?></option>
			<option value="Mate SC" <?php if( "Mate SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mate SC', 'yogax' ); ?></option>
			<option value="Maven Pro" <?php if( "Maven Pro" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Maven Pro', 'yogax' ); ?></option>
			<option value="McLaren" <?php if( "McLaren" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'McLaren', 'yogax' ); ?></option>
			<option value="Meddon" <?php if( "Meddon" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Meddon', 'yogax' ); ?></option>
			<option value="MedievalSharp" <?php if( "MedievalSharp" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'MedievalSharp', 'yogax' ); ?></option>
			<option value="Medula One" <?php if( "Medula One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Medula One', 'yogax' ); ?></option>
			<option value="Megrim" <?php if( "Megrim" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Megrim', 'yogax' ); ?></option>
			<option value="Meie Script" <?php if( "Meie Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Meie Script', 'yogax' ); ?></option>
			<option value="Merienda" <?php if( "Merienda" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Merienda', 'yogax' ); ?></option>
			<option value="Merienda One" <?php if( "Merienda One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Merienda One', 'yogax' ); ?></option>
			<option value="Merriweather" <?php if( "Merriweather" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Merriweather', 'yogax' ); ?></option>
			<option value="Merriweather Sans" <?php if( "Merriweather Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Merriweather Sans', 'yogax' ); ?></option>
			<option value="Metal" <?php if( "Metal" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Metal', 'yogax' ); ?></option>
			<option value="Metal Mania" <?php if( "Metal Mania" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Metal Mania', 'yogax' ); ?></option>
			<option value="Metamorphous" <?php if( "Metamorphous" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Metamorphous', 'yogax' ); ?></option>
			<option value="Metrophobic" <?php if( "Metrophobic" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Metrophobic', 'yogax' ); ?></option>
			<option value="Michroma" <?php if( "Michroma" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Michroma', 'yogax' ); ?></option>
			<option value="Milonga" <?php if( "Milonga" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Milonga', 'yogax' ); ?></option>
			<option value="Miltonian" <?php if( "Miltonian" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Miltonian', 'yogax' ); ?></option>
			<option value="Miltonian Tattoo" <?php if( "Miltonian Tattoo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Miltonian Tattoo', 'yogax' ); ?></option>
			<option value="Miniver" <?php if( "Miniver" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Miniver', 'yogax' ); ?></option>
			<option value="Miss Fajardose" <?php if( "Miss Fajardose" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Miss Fajardose', 'yogax' ); ?></option>
			<option value="Modern Antiqua" <?php if( "Modern Antiqua" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Modern Antiqua', 'yogax' ); ?></option>
			<option value="Molengo" <?php if( "Molengo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Molengo', 'yogax' ); ?></option>
			<option value="Molle" <?php if( "Molle" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Molle', 'yogax' ); ?></option>
			<option value="Monda" <?php if( "Monda" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Monda', 'yogax' ); ?></option>
			<option value="Monofett" <?php if( "Monofett" == $this_val ) echo 'selected="selected"'; ?>>Monofett</option>
			<option value="Monoton" <?php if( "Monoton" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Monoton', 'yogax' ); ?></option>
			<option value="Monsieur La Doulaise" <?php if( "Monsieur La Doulaise" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Monsieur La Doulaise', 'yogax' ); ?></option>
			<option value="Montaga" <?php if( "Montaga" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Montaga', 'yogax' ); ?></option>
			<option value="Montez" <?php if( "Montez" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Montez', 'yogax' ); ?></option>
			<option value="Montserrat" <?php if( "Montserrat" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Montserrat', 'yogax' ); ?></option>
			<option value="Montserrat Alternates" <?php if( "Montserrat Alternates" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Montserrat Alternates', 'yogax' ); ?></option>
			<option value="Montserrat Subrayada" <?php if( "Montserrat Subrayada" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Montserrat Subrayada', 'yogax' ); ?></option>
			<option value="Moul" <?php if( "Moul" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Moul', 'yogax' ); ?></option>
			<option value="Moulpali" <?php if( "Moulpali" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Moulpali', 'yogax' ); ?></option>
			<option value="Mountains of Christmas" <?php if( "Mountains of Christmas" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mountains of Christmas', 'yogax' ); ?></option>
			<option value="Mouse Memoirs" <?php if( "Mouse Memoirs" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mouse Memoirs', 'yogax' ); ?></option>
			<option value="Mr Bedfort" <?php if( "Mr Bedfort" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mr Bedfort', 'yogax' ); ?></option>
			<option value="Mr Dafoe" <?php if( "Mr Dafoe" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mr Dafoe', 'yogax' ); ?></option>
			<option value="Mr De Haviland" <?php if( "Mr De Haviland" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mr De Haviland', 'yogax' ); ?></option>
			<option value="Mrs Saint Delafield" <?php if( "Mrs Saint Delafield" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mrs Saint Delafield', 'yogax' ); ?></option>
			<option value="Mrs Sheppards" <?php if( "Mrs Sheppards" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mrs Sheppards', 'yogax' ); ?></option>
			<option value="Muli" <?php if( "Muli" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Muli', 'yogax' ); ?></option>
			<option value="Mystery Quest" <?php if( "Mystery Quest" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Mystery Quest', 'yogax' ); ?></option>
			<option value="Neucha" <?php if( "Neucha" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Neucha', 'yogax' ); ?></option>
			<option value="Neuton" <?php if( "Neuton" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Neuton', 'yogax' ); ?></option>
			<option value="New Rocker" <?php if( "New Rocker" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'New Rocker', 'yogax' ); ?></option>
			<option value="News Cycle" <?php if( "News Cycle" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'News Cycle', 'yogax' ); ?></option>
			<option value="Niconne" <?php if( "Niconne" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Niconne', 'yogax' ); ?></option>
			<option value="Nixie One" <?php if( "Nixie One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nixie One', 'yogax' ); ?></option>
			<option value="Nobile" <?php if( "Nobile" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nobile', 'yogax' ); ?></option>
			<option value="Nokora" <?php if( "Nokora" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nokora', 'yogax' ); ?></option>
			<option value="Norican" <?php if( "Norican" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Norican', 'yogax' ); ?></option>
			<option value="Nosifer" <?php if( "Nosifer" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nosifer', 'yogax' ); ?></option>
			<option value="Nothing You Could Do" <?php if( "Nothing You Could Do" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nothing You Could Do', 'yogax' ); ?></option>
			<option value="Noticia Text" <?php if( "Noticia Text" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Noticia Text', 'yogax' ); ?></option>
			<option value="Noto Sans" <?php if( "Noto Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Noto Sans', 'yogax' ); ?></option>
			<option value="Noto Serif" <?php if( "Noto Serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( '>Noto Serif', 'yogax' ); ?></option>
			<option value="Nova Cut" <?php if( "Nova Cut" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nova Cut', 'yogax' ); ?></option>
			<option value="Nova Flat" <?php if( "Nova Flat" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nova Flat', 'yogax' ); ?></option>
			<option value="Nova Mono" <?php if( "Nova Mono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nova Mono', 'yogax' ); ?></option>
			<option value="Nova Oval" <?php if( "Nova Oval" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nova Oval', 'yogax' ); ?></option>
			<option value="Nova Round" <?php if( "Nova Round" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nova Round', 'yogax' ); ?></option>
			<option value="Nova Script" <?php if( "Nova Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nova Script', 'yogax' ); ?></option>
			<option value="Nova Slim" <?php if( "Nova Slim" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nova Slim', 'yogax' ); ?></option>
			<option value="Nova Square" <?php if( "Nova Square" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nova Square', 'yogax' ); ?></option>
			<option value="Numans" <?php if( "Numans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Numans', 'yogax' ); ?></option>
			<option value="Nunito" <?php if( "Nunito" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Nunito', 'yogax' ); ?></option>
			<option value="Odor Mean Chey" <?php if( "Odor Mean Chey" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Odor Mean Chey', 'yogax' ); ?></option>
			<option value="Offside" <?php if( "Offside" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Offside', 'yogax' ); ?></option>
			<option value="Old Standard TT" <?php if( "Old Standard TT" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Old Standard TT', 'yogax' ); ?></option>
			<option value="Oldenburg" <?php if( "Oldenburg" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Oldenburg', 'yogax' ); ?></option>
			<option value="Oleo Script" <?php if( "Oleo Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Oleo Script', 'yogax' ); ?></option>
			<option value="Oleo Script Swash Caps" <?php if( "Oleo Script Swash Caps" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Oleo Script Swash Caps', 'yogax' ); ?></option>
			<option value="Open Sans" <?php if( "Open Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Open Sans', 'yogax' ); ?></option>
			<option value="Open Sans Condensed" <?php if( "Open Sans Condensed" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Open Sans Condensed', 'yogax' ); ?></option>
			<option value="Oranienbaum" <?php if( "Oranienbaum" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Oranienbaum', 'yogax' ); ?></option>
			<option value="Orbitron" <?php if( "Orbitron" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Orbitron', 'yogax' ); ?></option>
			<option value="Oregano" <?php if( "Oregano" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Oregano', 'yogax' ); ?></option>
			<option value="Orienta" <?php if( "Orienta" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Orienta', 'yogax' ); ?></option>
			<option value="Original Surfer" <?php if( "Original Surfer" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Original Surfer', 'yogax' ); ?></option>
			<option value="Oswald" <?php if( "Oswald" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Oswald', 'yogax' ); ?></option>
			<option value="Over the Rainbow" <?php if( "Over the Rainbow" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Over the Rainbow', 'yogax' ); ?></option>
			<option value="Overlock" <?php if( "Overlock" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Overlock', 'yogax' ); ?></option>
			<option value="Overlock SC" <?php if( "Overlock SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Overlock SC', 'yogax' ); ?></option>
			<option value="Ovo" <?php if( "Ovo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ovo', 'yogax' ); ?></option>
			<option value="Oxygen" <?php if( "Oxygen" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Oxygen', 'yogax' ); ?></option>
			<option value="Oxygen Mono" <?php if( "Oxygen Mono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Oxygen Mono', 'yogax' ); ?></option>
			<option value="PT Mono" <?php if( "PT Mono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'PT Mono', 'yogax' ); ?></option>
			<option value="PT Sans" <?php if( "PT Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'PT Sans', 'yogax' ); ?></option>
			<option value="PT Sans Caption" <?php if( "PT Sans Caption" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'PT Sans Caption', 'yogax' ); ?></option>
			<option value="PT Sans Narrow" <?php if( "PT Sans Narrow" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'PT Sans Narrow', 'yogax' ); ?></option>
			<option value="PT Serif" <?php if( "PT Serif" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'PT Serif', 'yogax' ); ?></option>
			<option value="PT Serif Caption" <?php if( "PT Serif Caption" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'PT Serif Caption', 'yogax' ); ?></option>
			<option value="Pacifico" <?php if( "Pacifico" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Pacifico', 'yogax' ); ?></option>
			<option value="Paprika" <?php if( "Paprika" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Paprika', 'yogax' ); ?></option>
			<option value="Parisienne" <?php if( "Parisienne" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Parisienne', 'yogax' ); ?></option>
			<option value="Passero One" <?php if( "Passero One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Passero One', 'yogax' ); ?></option>
			<option value="Passion One" <?php if( "Passion One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Passion One', 'yogax' ); ?></option>
			<option value="Pathway Gothic One" <?php if( "Pathway Gothic One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Pathway Gothic One', 'yogax' ); ?></option>
			<option value="Patrick Hand" <?php if( "Patrick Hand" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Patrick Hand', 'yogax' ); ?></option>
			<option value="Patrick Hand SC" <?php if( "Patrick Hand SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Patrick Hand SC', 'yogax' ); ?></option>
			<option value="Patua One" <?php if( "Patua One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Patua One', 'yogax' ); ?></option>
			<option value="Paytone One" <?php if( "Paytone One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Paytone One', 'yogax' ); ?></option>
			<option value="Peralta" <?php if( "Peralta" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Peralta', 'yogax' ); ?></option>
			<option value="Permanent Marker" <?php if( "Permanent Marker" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Permanent Marker', 'yogax' ); ?></option>
			<option value="Petit Formal Script" <?php if( "Petit Formal Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Petit Formal Script', 'yogax' ); ?></option>
			<option value="Petrona" <?php if( "Petrona" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Petrona', 'yogax' ); ?></option>
			<option value="Philosopher" <?php if( "Philosopher" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Philosopher', 'yogax' ); ?></option>
			<option value="Piedra" <?php if( "Piedra" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Piedra', 'yogax' ); ?></option>
			<option value="Pinyon Script" <?php if( "Pinyon Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Pinyon Script', 'yogax' ); ?></option>
			<option value="Pirata One" <?php if( "Pirata One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Pirata One', 'yogax' ); ?></option>
			<option value="Plaster" <?php if( "Plaster" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Plaster', 'yogax' ); ?></option>
			<option value="Play" <?php if( "Play" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Play', 'yogax' ); ?></option>
			<option value="Playball" <?php if( "Playball" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Playball', 'yogax' ); ?></option>
			<option value="Playfair Display" <?php if( "Playfair Display" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Playfair Display', 'yogax' ); ?></option>
			<option value="Playfair Display SC" <?php if( "Playfair Display SC" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Playfair Display SC', 'yogax' ); ?></option>
			<option value="Podkova" <?php if( "Podkova" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Podkova', 'yogax' ); ?></option>
			<option value="Poiret One" <?php if( "Poiret One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Poiret One', 'yogax' ); ?></option>
			<option value="Poller One" <?php if( "Poller One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Poller One', 'yogax' ); ?></option>
			<option value="Poly" <?php if( "Poly" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Poly', 'yogax' ); ?></option>
			<option value="Pompiere" <?php if( "Pompiere" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Pompiere', 'yogax' ); ?></option>
			<option value="Pontano Sans" <?php if( "Pontano Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Pontano Sans', 'yogax' ); ?></option>
			<option value="Port Lligat Sans" <?php if( "Port Lligat Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Port Lligat Sans', 'yogax' ); ?></option>
			<option value="Port Lligat Slab" <?php if( "Port Lligat Slab" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Port Lligat Slab', 'yogax' ); ?></option>
			<option value="Prata" <?php if( "Prata" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Prata', 'yogax' ); ?></option>
			<option value="Preahvihear" <?php if( "Preahvihear" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Preahvihear', 'yogax' ); ?></option>
			<option value="Press Start 2P" <?php if( "Press Start 2P" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Press Start 2P', 'yogax' ); ?></option>
			<option value="Princess Sofia" <?php if( "Princess Sofia" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Princess Sofia', 'yogax' ); ?></option>
			<option value="Prociono" <?php if( "Prociono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Prociono', 'yogax' ); ?></option>
			<option value="Prosto One" <?php if( "Prosto One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Prosto One', 'yogax' ); ?></option>
			<option value="Puritan" <?php if( "Puritan" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Puritan', 'yogax' ); ?></option>
			<option value="Purple Purse" <?php if( "Purple Purse" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Purple Purse', 'yogax' ); ?></option>
			<option value="Quando" <?php if( "Quando" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Quando', 'yogax' ); ?></option>
			<option value="Quantico" <?php if( "Quantico" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Quantico', 'yogax' ); ?></option>
			<option value="Quattrocento" <?php if( "Quattrocento" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Quattrocento', 'yogax' ); ?></option>
			<option value="Quattrocento Sans" <?php if( "Quattrocento Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Quattrocento Sans', 'yogax' ); ?></option>
			<option value="Questrial" <?php if( "Questrial" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Questrial', 'yogax' ); ?></option>
			<option value="Quicksand" <?php if( "Quicksand" == $this_val ) echo 'selected="selected"'; ?>>Quicksand</option>
			<option value="Quintessential" <?php if( "Quintessential" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Quintessential', 'yogax' ); ?></option>
			<option value="Qwigley" <?php if( "Qwigley" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Qwigley', 'yogax' ); ?></option>
			<option value="Racing Sans One" <?php if( "Racing Sans One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Racing Sans One', 'yogax' ); ?></option>
			<option value="Radley" <?php if( "Radley" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Radley', 'yogax' ); ?></option>
			<option value="Rajdhani" <?php if( "Rajdhani" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rajdhani', 'yogax' ); ?></option>
			<option value="Raleway" <?php if( "Raleway" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Raleway', 'yogax' ); ?></option>
			<option value="Raleway Dots" <?php if( "Raleway Dots" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Raleway Dots', 'yogax' ); ?></option>
			<option value="Rambla" <?php if( "Rambla" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rambla', 'yogax' ); ?></option>
			<option value="Rammetto One" <?php if( "Rammetto One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rammetto One', 'yogax' ); ?></option>
			<option value="Ranchers" <?php if( "Ranchers" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ranchers', 'yogax' ); ?></option>
			<option value="Rancho" <?php if( "Rancho" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rancho', 'yogax' ); ?></option>
			<option value="Rationale" <?php if( "Rationale" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rationale', 'yogax' ); ?></option>
			<option value="Redressed" <?php if( "Redressed" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Redressed', 'yogax' ); ?></option>
			<option value="Reenie Beanie" <?php if( "Reenie Beanie" == $this_val ) echo 'selected="selected"'; ?>>Reenie Beanie</option>
			<option value="Revalia" <?php if( "Revalia" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Revalia', 'yogax' ); ?></option>
			<option value="Ribeye" <?php if( "Ribeye" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ribeye', 'yogax' ); ?></option>
			<option value="Ribeye Marrow" <?php if( "Ribeye Marrow" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ribeye Marrow', 'yogax' ); ?></option>
			<option value="Righteous" <?php if( "Righteous" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Righteous', 'yogax' ); ?></option>
			<option value="Risque" <?php if( "Risque" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Risque', 'yogax' ); ?></option>
			<option value="Roboto" <?php if( "Roboto" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Roboto', 'yogax' ); ?></option>
			<option value="Roboto Condensed" <?php if( "Roboto Condensed" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Roboto Condensed', 'yogax' ); ?></option>
			<option value="Roboto Slab" <?php if( "Roboto Slab" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Roboto Slab', 'yogax' ); ?></option>
			<option value="Rochester" <?php if( "Rochester" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rochester', 'yogax' ); ?></option>
			<option value="Rock Salt" <?php if( "Rock Salt" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rock Salt', 'yogax' ); ?></option>
			<option value="Rokkitt" <?php if( "Rokkitt" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rokkitt', 'yogax' ); ?></option>
			<option value="Romanesco" <?php if( "Romanesco" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Romanesco', 'yogax' ); ?></option>
			<option value="Ropa Sans" <?php if( "Ropa Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ropa Sans', 'yogax' ); ?></option>
			<option value="Rosario" <?php if( "Rosario" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rosario', 'yogax' ); ?></option>
			<option value="Rosarivo" <?php if( "Rosarivo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rosarivo', 'yogax' ); ?></option>
			<option value="Rouge Script" <?php if( "Rouge Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rouge Script', 'yogax' ); ?></option>
			<option value="Rozha One" <?php if( "Rozha One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rozha One', 'yogax' ); ?></option>
			<option value="Rubik Mono One" <?php if( "Rubik Mono One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rubik Mono One', 'yogax' ); ?></option>
			<option value="Rubik One" <?php if( "Rubik One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rubik One', 'yogax' ); ?></option>
			<option value="Ruda" <?php if( "Ruda" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ruda', 'yogax' ); ?></option>
			<option value="Rufina" <?php if( "Rufina" == $this_val ) echo 'selected="selected"'; ?>>Rufina</option>
			<option value="Ruge Boogie" <?php if( "Ruge Boogie" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ruge Boogie', 'yogax' ); ?></option>
			<option value="Ruluko" <?php if( "Ruluko" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ruluko', 'yogax' ); ?></option>
			<option value="Rum Raisin" <?php if( "Rum Raisin" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rum Raisin', 'yogax' ); ?></option>
			<option value="Ruslan Display" <?php if( "Ruslan Display" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ruslan Display', 'yogax' ); ?></option>
			<option value="Russo One" <?php if( "Russo One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Russo One', 'yogax' ); ?></option>
			<option value="Ruthie" <?php if( "Ruthie" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ruthie', 'yogax' ); ?></option>
			<option value="Rye" <?php if( "Rye" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Rye', 'yogax' ); ?></option>
			<option value="Sacramento" <?php if( "Sacramento" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sacramento', 'yogax' ); ?></option>
			<option value="Sail" <?php if( "Sail" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sail', 'yogax' ); ?></option>
			<option value="Salsa" <?php if( "Salsa" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Salsa', 'yogax' ); ?></option>
			<option value="Sanchez" <?php if( "Sanchez" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sanchez', 'yogax' ); ?></option>
			<option value="Sancreek" <?php if( "Sancreek" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sancreek', 'yogax' ); ?></option>
			<option value="Sansita One" <?php if( "Sansita One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sansita One', 'yogax' ); ?></option>
			<option value="Sarina" <?php if( "Sarina" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sarina', 'yogax' ); ?></option>
			<option value="Sarpanch" <?php if( "Sarpanch" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sarpanch', 'yogax' ); ?></option>
			<option value="Satisfy" <?php if( "Satisfy" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Satisfy', 'yogax' ); ?></option>
			<option value="Scada" <?php if( "Scada" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Scada', 'yogax' ); ?></option>
			<option value="Schoolbell" <?php if( "Schoolbell" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Schoolbell', 'yogax' ); ?></option>
			<option value="Seaweed Script" <?php if( "Seaweed Script" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Seaweed Script', 'yogax' ); ?></option>
			<option value="Sevillana" <?php if( "Sevillana" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sevillana', 'yogax' ); ?></option>
			<option value="Seymour One" <?php if( "Seymour One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Seymour One', 'yogax' ); ?></option>
			<option value="Shadows Into Light" <?php if( "Shadows Into Light" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Shadows Into Light', 'yogax' ); ?></option>
			<option value="Shadows Into Light Two" <?php if( "Shadows Into Light Two" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Shadows Into Light Two', 'yogax' ); ?></option>
			<option value="Shanti" <?php if( "Shanti" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Shanti', 'yogax' ); ?></option>
			<option value="Share" <?php if( "Share" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Share', 'yogax' ); ?></option>
			<option value="Share Tech" <?php if( "Share Tech" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Share Tech', 'yogax' ); ?></option>
			<option value="Share Tech Mono" <?php if( "Share Tech Mono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Share Tech Mono', 'yogax' ); ?></option>
			<option value="Shojumaru" <?php if( "Shojumaru" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Shojumaru', 'yogax' ); ?></option>
			<option value="Short Stack" <?php if( "Short Stack" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Short Stack', 'yogax' ); ?></option>
			<option value="Siemreap" <?php if( "Siemreap" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Siemreap', 'yogax' ); ?></option>
			<option value="Sigmar One" <?php if( "Sigmar One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sigmar One', 'yogax' ); ?></option>
			<option value="Signika" <?php if( "Signika" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Signika', 'yogax' ); ?></option>
			<option value="Signika Negative" <?php if( "Signika Negative" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Signika Negative', 'yogax' ); ?></option>
			<option value="Simonetta" <?php if( "Simonetta" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Simonetta', 'yogax' ); ?></option>
			<option value="Sintony" <?php if( "Sintony" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sintony', 'yogax' ); ?></option>
			<option value="Sirin Stencil" <?php if( "Sirin Stencil" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sirin Stencil', 'yogax' ); ?></option>
			<option value="Six Caps" <?php if( "Six Caps" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Six Caps', 'yogax' ); ?></option>
			<option value="Skranji" <?php if( "Skranji" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Skranji', 'yogax' ); ?></option>
			<option value="Slabo 13px" <?php if( "Slabo 13px" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Slabo 13px', 'yogax' ); ?></option>
			<option value="Slabo 27px" <?php if( "Slabo 27px" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Slabo 27px', 'yogax' ); ?></option>
			<option value="Slackey" <?php if( "Slackey" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Slackey', 'yogax' ); ?></option>
			<option value="Smokum" <?php if( "Smokum" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Smokum', 'yogax' ); ?></option>
			<option value="Smythe" <?php if( "Smythe" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Smythe', 'yogax' ); ?></option>
			<option value="Sniglet" <?php if( "Sniglet" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sniglet', 'yogax' ); ?></option>
			<option value="Snippet" <?php if( "Snippet" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Snippet', 'yogax' ); ?></option>
			<option value="Snowburst One" <?php if( "Snowburst One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Snowburst One', 'yogax' ); ?></option>
			<option value="Sofadi One" <?php if( "Sofadi One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sofadi One', 'yogax' ); ?></option>
			<option value="Sofia" <?php if( "Sofia" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sofia', 'yogax' ); ?></option>
			<option value="Sonsie One" <?php if( "Sonsie One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sonsie One', 'yogax' ); ?></option>
			<option value="Sorts Mill Goudy" <?php if( "Sorts Mill Goudy" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sorts Mill Goudy', 'yogax' ); ?></option>
			<option value="Source Code Pro" <?php if( "Source Code Pro" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Source Code Pro', 'yogax' ); ?></option>
			<option value="Source Sans Pro" <?php if( "Source Sans Pro" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Source Sans Pro', 'yogax' ); ?></option>
			<option value="Source Serif Pro" <?php if( "Source Serif Pro" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Source Serif Pro', 'yogax' ); ?></option>
			<option value="Special Elite" <?php if( "Special Elite" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Special Elite', 'yogax' ); ?></option>
			<option value="Spicy Rice" <?php if( "Spicy Rice" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Spicy Rice', 'yogax' ); ?></option>
			<option value="Spinnaker" <?php if( "Spinnaker" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Spinnaker', 'yogax' ); ?></option>
			<option value="Spirax" <?php if( "Spirax" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Spirax', 'yogax' ); ?></option>
			<option value="Squada One" <?php if( "Squada One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Squada One', 'yogax' ); ?></option>
			<option value="Stalemate" <?php if( "Stalemate" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Stalemate', 'yogax' ); ?></option>
			<option value="Stalinist One" <?php if( "Stalinist One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Stalinist One', 'yogax' ); ?></option>
			<option value="Stardos Stencil" <?php if( "Stardos Stencil" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Stardos Stencil', 'yogax' ); ?></option>
			<option value="Stint Ultra Condensed" <?php if( "Stint Ultra Condensed" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Stint Ultra Condensed', 'yogax' ); ?></option>
			<option value="Stint Ultra Expanded" <?php if( "Stint Ultra Expanded" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Stint Ultra Expanded', 'yogax' ); ?></option>
			<option value="Stoke" <?php if( "Stoke" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Stoke', 'yogax' ); ?></option>
			<option value="Strait" <?php if( "Strait" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Strait', 'yogax' ); ?></option>
			<option value="Sue Ellen Francisco" <?php if( "Sue Ellen Francisco" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sue Ellen Francisco', 'yogax' ); ?></option>
			<option value="Sunshiney" <?php if( "Sunshiney" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Sunshiney', 'yogax' ); ?></option>
			<option value="Supermercado One" <?php if( "Supermercado One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Supermercado One', 'yogax' ); ?></option>
			<option value="Suwannaphum" <?php if( "Suwannaphum" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Suwannaphum', 'yogax' ); ?></option>
			<option value="Swanky and Moo Moo" <?php if( "Swanky and Moo Moo" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Swanky and Moo Moo', 'yogax' ); ?></option>
			<option value="Syncopate" <?php if( "Syncopate" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Syncopate', 'yogax' ); ?></option>
			<option value="Tangerine" <?php if( "Tangerine" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Tangerine', 'yogax' ); ?></option>
			<option value="Taprom" <?php if( "Taprom" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Taprom', 'yogax' ); ?></option>
			<option value="Tauri" <?php if( "Tauri" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Tauri', 'yogax' ); ?></option>
			<option value="Teko" <?php if( "Teko" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Teko', 'yogax' ); ?></option>
			<option value="Telex" <?php if( "Telex" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Telex', 'yogax' ); ?></option>
			<option value="Tenor Sans" <?php if( "Tenor Sans" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Tenor Sans', 'yogax' ); ?></option>
			<option value="Text Me One" <?php if( "Text Me One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Text Me One', 'yogax' ); ?></option>
			<option value="The Girl Next Door" <?php if( "The Girl Next Door" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'The Girl Next Door', 'yogax' ); ?></option>
			<option value="Tienne" <?php if( "Tienne" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Tienne', 'yogax' ); ?></option>
			<option value="Tinos" <?php if( "Tinos" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Tinos', 'yogax' ); ?></option>
			<option value="Titan One" <?php if( "Titan One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Titan One', 'yogax' ); ?></option>
			<option value="Titillium Web" <?php if( "Titillium Web" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Titillium Web', 'yogax' ); ?></option>
			<option value="Trade Winds" <?php if( "Trade Winds" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Trade Winds', 'yogax' ); ?></option>
			<option value="Trocchi" <?php if( "Trocchi" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Trocchi', 'yogax' ); ?></option>
			<option value="Trochut" <?php if( "Trochut" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Trochut', 'yogax' ); ?></option>
			<option value="Trykker" <?php if( "Trykker" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Trykker', 'yogax' ); ?></option>
			<option value="Tulpen One" <?php if( "Tulpen One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Tulpen One', 'yogax' ); ?></option>
			<option value="Ubuntu" <?php if( "Ubuntu" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ubuntu', 'yogax' ); ?></option>
			<option value="Ubuntu Condensed" <?php if( "Ubuntu Condensed" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ubuntu Condensed', 'yogax' ); ?></option>
			<option value="Ubuntu Mono" <?php if( "Ubuntu Mono" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ubuntu Mono', 'yogax' ); ?></option>
			<option value="Ultra" <?php if( "Ultra" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Ultra', 'yogax' ); ?></option>
			<option value="Uncial Antiqua" <?php if( "Uncial Antiqua" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Uncial Antiqua', 'yogax' ); ?></option>
			<option value="Underdog" <?php if( "Underdog" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Underdog', 'yogax' ); ?></option>
			<option value="Unica One" <?php if( "Unica One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Unica One', 'yogax' ); ?></option>
			<option value="UnifrakturCook" <?php if( "UnifrakturCook" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'UnifrakturCook', 'yogax' ); ?></option>
			<option value="UnifrakturMaguntia" <?php if( "UnifrakturMaguntia" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'UnifrakturMaguntia', 'yogax' ); ?></option>
			<option value="Unkempt" <?php if( "Unkempt" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Unkempt', 'yogax' ); ?></option>
			<option value="Unlock" <?php if( "Unlock" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Unlock', 'yogax' ); ?></option>
			<option value="Unna" <?php if( "Unna" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Unna', 'yogax' ); ?></option>
			<option value="VT323" <?php if( "VT323" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'VT323', 'yogax' ); ?></option>
			<option value="Vampiro One" <?php if( "Vampiro One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Vampiro One', 'yogax' ); ?></option>
			<option value="Varela" <?php if( "Varela" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Varela', 'yogax' ); ?></option>
			<option value="Varela Round" <?php if( "Varela Round" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Varela Round', 'yogax' ); ?></option>
			<option value="Vast Shadow" <?php if( "Vast Shadow" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Vast Shadow', 'yogax' ); ?></option>
			<option value="Vesper Libre" <?php if( "Vesper Libre" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Vesper Libre', 'yogax' ); ?></option>
			<option value="Vibur" <?php if( "Vibur" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Vibur', 'yogax' ); ?></option>
			<option value="Vidaloka" <?php if( "Vidaloka" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Vidaloka', 'yogax' ); ?></option>
			<option value="Viga" <?php if( "Viga" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Viga', 'yogax' ); ?></option>
			<option value="Voces" <?php if( "Voces" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Voces', 'yogax' ); ?></option>
			<option value="Volkhov" <?php if( "Volkhov" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Volkhov', 'yogax' ); ?></option>
			<option value="Vollkorn" <?php if( "Vollkorn" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Vollkorn', 'yogax' ); ?></option>
			<option value="Voltaire" <?php if( "Voltaire" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Voltaire', 'yogax' ); ?></option>
			<option value="Waiting for the Sunrise" <?php if( "Waiting for the Sunrise" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Waiting for the Sunrise', 'yogax' ); ?></option>
			<option value="Wallpoet" <?php if( "Wallpoet" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Wallpoet', 'yogax' ); ?></option>
			<option value="Walter Turncoat" <?php if( "Walter Turncoat" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Walter Turncoat', 'yogax' ); ?></option>
			<option value="Warnes" <?php if( "Warnes" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Warnes', 'yogax' ); ?></option>
			<option value="Wellfleet" <?php if( "Wellfleet" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Wellfleet', 'yogax' ); ?></option>
			<option value="Wendy One" <?php if( "Wendy One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Wendy One', 'yogax' ); ?></option>
			<option value="Wire One" <?php if( "Wire One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Wire One', 'yogax' ); ?></option>
			<option value="Yanone Kaffeesatz" <?php if( "Yanone Kaffeesatz" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Yanone Kaffeesatz', 'yogax' ); ?></option>
			<option value="Yellowtail" <?php if( "Yellowtail" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Yellowtail', 'yogax' ); ?></option>
			<option value="Yeseva One" <?php if( "Yeseva One" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Yeseva One', 'yogax' ); ?></option>
			<option value="Yesteryear" <?php if( "Yesteryear" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Yesteryear', 'yogax' ); ?></option>
			<option value="Zeyada" <?php if( "Zeyada" == $this_val ) echo 'selected="selected"'; ?>><?php esc_html_e( 'Zeyada', 'yogax' ); ?></option>
		</select>
	</label>
	<?php }
}