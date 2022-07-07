<?php
/**
 * Template: Layout 4.
 */

use RT\Team\Helpers\Fns;

$html  = null;
$html .= "<div class='{$grid} {$class}' data-id='{$mID}'>";

if ( $imgHtml ) {
	$html .= '<div class="single-team-area">';
	$html .= '<div class="single-team">';

	if ( $link ) {
		$html .= "<figure><a class='{$anchorClass}' data-id='{$mID}' target='{$target}' href='{$pLink}'>{$imgHtml}</a></figure>";
	} else {
		$html .= "<figure>{$imgHtml}</figure>";
	}

	$html .= '<div class="overlay">';
	$html .= '<div class="overlay-element">';
	$c2    = null;

	if ( in_array( 'name', $items ) && $title ) {
		if ( $link ) {
			$c2 .= '<h3><span class="team-name"><a class="' . $anchorClass . '" data-id="' . $mID . '" target="' . $target . '" title="' . esc_html( $title ) . '" href="' . esc_url( $pLink ) . '">' . esc_html( $title ) . '</a></span></h3>';
		} else {
			$c2 .= '<h3><span class="team-name">' . $title . '</span></h3>';
		}
	}

	if ( in_array( 'designation', $items ) && $designation ) {
		if ( $link ) {
			$c2 .= '<div class="tlp-position"><a class="' . $anchorClass . '" data-id="' . $mID . '" target="' . $target . '" title="' . $title . '" href="' . $pLink . '">' . $designation . '</a></div>';
		} else {
			$c2 .= '<div class="tlp-position">' . $designation . '</div>';
		}
	}

	if ( $short_bio && in_array( 'short_bio', $items ) ) {
		$c2 .= '<div class="short-bio"><p>' . $short_bio . '</p></div>';
	}

	$html .= $c2 ? "<div class='tlp-content2'>{$c2}</div>" : null;
	$html .= Fns::get_formatted_social_link( $sLink, $items );
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</div>'; // END single-team
	$html .= '</div>'; // End single-team-area
}

$html .= '</div>'; // END grid

echo $html;
