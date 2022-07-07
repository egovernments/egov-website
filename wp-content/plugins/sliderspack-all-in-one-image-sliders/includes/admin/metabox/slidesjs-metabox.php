<?php
/**
 * Handles SlidesJS Slider Setting metabox HTML
 *
 * @package SlidersPack - All In One Image Sliders
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Taking some variable
$start_js			= get_post_meta( $post->ID, $prefix.'start_js', true );
$effect_js			= get_post_meta( $post->ID, $prefix.'effect_js', true );
$pauseon_over_js	= get_post_meta( $post->ID, $prefix.'pauseon_over_js', true );
$effect_js			= ! empty( $effect_js )				? $effect_js	: 'slide';
$pauseon_over_js	= ( $pauseon_over_js == 'true' )	? 'true'		: 'false';
?>

<table class="form-table wp-spaios-tbl">			
	<tbody>
		<tr>
			<th colspan="2">
				<div class="wp-spaios-title-sett"><?php _e('SlidesJS Slider Parameters', 'sliderspack-all-in-one-image-sliders') ?></div>
			</th>
		</tr>
		<tr>
			<th>
				<label for="wp-spaios-slide-start"><?php _e('Start Slide', 'sliderspack-all-in-one-image-sliders'); ?></label>
			</th>
			<td>
				<input type="text" name="<?php echo wp_spaios_esc_attr( $prefix ); ?>start_js" value="<?php echo wp_spaios_esc_attr( $start_js ); ?>" class="wp-spaios-slide-start" id="wp-spaios-slide-start" /><br/>
				<span class="description"><?php _e('Set the first slide in the slideshow. eg. 5','sliderspack-all-in-one-image-sliders'); ?></span>
			</td>
		</tr>
		<tr>
			<th>
				<label for="wp-spaios-effect"><?php _e('Effect', 'sliderspack-all-in-one-image-sliders'); ?></label>
			</th>
			<td>
				<label for="wp-spaios-effect-slide">
					<input type="radio" name="<?php echo wp_spaios_esc_attr( $prefix ); ?>effect_js" value="slide" <?php checked('slide', $effect_js); ?> class="wp-spaios-effect-slide" id="wp-spaios-effect-slide" /><?php esc_html_e('Slide', 'sliderspack-all-in-one-image-sliders'); ?>
				</label>
				<label for="wp-spaios-effect-fade">
					<input type="radio" name="<?php echo wp_spaios_esc_attr( $prefix ); ?>effect_js" value="fade" <?php checked('fade', $effect_js); ?> class="wp-spaios-effect-fade" id="wp-spaios-effect-fade" /><?php esc_html_e('Fade', 'sliderspack-all-in-one-image-sliders'); ?>
				</label><br/>
				<span class="description"><?php _e('Select slide effect. Can be either slide or fade','sliderspack-all-in-one-image-sliders'); ?></span>
			</td>
		</tr>
		<tr>
			<th>
				<label><?php _e('Autoplay Pause on Hover', 'sliderspack-all-in-one-image-sliders'); ?></label>
			</th>
			<td>
				<label for="wp-spaios-hover-true">
					<input type="radio" name="<?php echo wp_spaios_esc_attr( $prefix ); ?>pauseon_over_js" value="true" <?php checked('true', $pauseon_over_js); ?> class="wp-spaios-hover-true" id="wp-spaios-hover-true" /><?php esc_html_e('True', 'sliderspack-all-in-one-image-sliders'); ?>
				</label>
				<label for="wp-spaios-hover-false">
					<input type="radio" name="<?php echo wp_spaios_esc_attr( $prefix ); ?>pauseon_over_js" value="false" <?php checked('false', $pauseon_over_js); ?> class="wp-spaios-hover-false" id="wp-spaios-hover-false" /><?php esc_html_e('False', 'sliderspack-all-in-one-image-sliders'); ?>
				</label><br/>
				<span class="description"><?php _e('Pause slider on mouse hover','sliderspack-all-in-one-image-sliders'); ?></span>
			</td>
		</tr>				
	</tbody>
</table>