<?php
/**
 * Template: Isotope 1.
 */

use RT\Team\Helpers\Fns;

$html = null;

$html .= "<div class='team-member {$grid} {$class} {$isoFilter}' data-id='{$mID}'>";
$html .= '<figure>';

if ( $imgHtml ) {
	if ( $link ) {
		$html .= "<a class='{$anchorClass}' data-id='{$mID}' target='{$target}' href='{$pLink}'>{$imgHtml}</a>";
	} else {
		$html .= $imgHtml;
	}
}

$html .= '<div class="overlay">';
$html .= '<div class="overlay-element">';

if ( in_array( 'name', $items ) && $title ) {
	if ( $link ) {
		$html .= '<h3><span class="team-name"><a class="' . $anchorClass . '" data-id="' . $mID . '" target="' . $target . '" title="' . esc_html( $title ) . '" href="' . esc_url( $pLink ) . '">' . esc_html( $title ) . '</a></span></h3>';
	} else {
		$html .= '<h3><span class="team-name">' . $title . '</span></h3>';
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

$html .= FNs::get_formatted_social_link( $sLink, $items );
$html .= '</div>';
$html .= '</div>';
$html .= '</figure>';
$html .= '</div>';

echo $html;
