<?php
/**
 * Template: Layout 3.
 */

use RT\Team\Helpers\Fns;

$html  = null;
$html .= "<div class='{$grid} {$class}' data-id='{$mID}'>";
$html .= '<div class="single-team-area">';

if ( $imgHtml ) {
	if ( $link ) {
		$html .= "<figure><a class='{$anchorClass}' data-id='{$mID}' target='{$target}' href='{$pLink}'>{$imgHtml}</a></figure>";
	} else {
		$html .= "<figure>{$imgHtml}</figure>";
	}
}

$c2 = null;

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

$html .= Fns::get_formatted_contact_info(
	array(
		'email'     => $email,
		'telephone' => $telephone,
		'mobile'    => $mobile,
		'fax'       => $fax,
		'location'  => $location,
		'web_url'   => $web_url,
	),
	$items
);

$html .= Fns::get_formatted_skill( $tlp_skill, $items );
$html .= Fns::get_formatted_social_link( $sLink, $items );
$html .= '</div>';
$html .= '</div>';

echo $html;
