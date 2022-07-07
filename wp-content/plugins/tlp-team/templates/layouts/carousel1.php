<?php
/**
 * Template: Carousel 1.
 */

use RT\Team\Helpers\Fns;

$html  = null;
$html .= "<div class='layout3 {$grid} {$class}' data-id='{$mID}'>";

$html .= '<div class="single-team-area">';

if ( $imgHtml ) {
	$lazyLoader = $lazyLoad ? '<div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>' : '';
	if ( $link ) {
		$html .= "<figure><a class='{$anchorClass}' data-id='{$mID}' href='{$pLink}'>{$imgHtml}</a></figure>";
	} else {
		$html .= "<figure>{$imgHtml}</figure>";
	}
}

$html .= '<div class="tlp-overlay1">';

if ( in_array( 'name', $items ) && $title ) {
	if ( $link ) {
		$html .= "<h3><span class='team-name'><a class='{$anchorClass}' data-id='{$mID}' title='{$title}' href='{$pLink}'>{$title}</a></span></h3>";
	} else {
		$html .= "<h3><span class='team-name'>{$title}</span></h3>";
	}
}

if ( in_array( 'designation', $items ) && $designation ) {
	if ( $link ) {
		$html .= '<div class="tlp-position"><a class="' . $anchorClass . '" data-id="' . $mID . '" target="' . $target . '" title="' . $title . '" href="' . $pLink . '">' . $designation . '</a></div>';
	} else {
		$html .= '<div class="tlp-position">' . $designation . '</div>';
	}
}

if ( $short_bio && in_array( 'short_bio', $items ) ) {
	$html .= '<div class="short-bio"><p>' . $short_bio . '</p></div>';
}

$html .= Fns::get_formatted_social_link( $sLink, $items );
$html .= '</div>';
$html .= '</div>';

$html .= '</div>';

echo $html;
