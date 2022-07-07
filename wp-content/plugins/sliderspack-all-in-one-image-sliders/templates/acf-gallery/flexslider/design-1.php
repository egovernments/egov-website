<?php
/**
 * Template for Flex Slider ACF Gallery Design 1
 *
 * @package SlidersPack - All In One Image Sliders
 * @since 1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="flex-slide">
	<?php if( $fancy_box ) { ?>
		<a class="wp-spaios-img-link" href="<?php echo esc_url( $image ); ?>" data-fancybox="acf-gallery" data-options="<?php echo htmlspecialchars(json_encode( $fancy_conf )); ?>">
			<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo wp_spaios_esc_attr( $alt_text ); ?>" title="<?php echo wp_spaios_esc_attr( $caption ); ?>" />
		</a>
	<?php } else { ?>
		<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo wp_spaios_esc_attr( $alt_text ); ?>" title="<?php echo wp_spaios_esc_attr( $caption ); ?>" />
	<?php } ?>

	<?php if( $show_caption && $captions ) { ?>
		<div class="flex-caption"><?php echo $captions; ?></div>
	<?php } ?>
</div>