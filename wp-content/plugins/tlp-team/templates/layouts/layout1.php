<?php
/**
 * Template: Layout 1.
 */

use RT\Team\Helpers\Fns;

$html  = null;
$html .= "<div class='{$grid} {$class}' data-id='{$mID}'>";
$html .= '<div class="single-team-area">';
$html .= '<div class="single-team">';

if ( $imgHtml ) {
	if ( $link ) {
		$html .= '<figure><a class="' . $anchorClass . '" data-id="' . $mID . '" target="' . $target . '" href="' . $pLink . '">' . $imgHtml . '</a></figure>';
	} else {
		$html .= '<figure>' . $imgHtml . '</figure>';
	}
}

$html   .= '</div>';
$content = null;

if ( in_array( 'name', $items ) && $title ) {
	if ( $link ) {
		$content .= '<h3><span class="team-name"><a class="' . $anchorClass . '" data-id="' . $mID . '" target="' . $target . '" title="' . $title . '" href="' . $pLink . '">' . $title . '</a></span></h3>';
	} else {
		$content .= '<h3><span class="team-name">' . $title . '</span></h3>';
	}
}

if ( in_array( 'designation', $items ) && $designation ) {
	if ( $link ) {
		$content .= '<div class="tlp-position"><a class="' . $anchorClass . '" data-id="' . $mID . '" target="' . $target . '" title="' . $title . '" href="' . $pLink . '">' . $designation . '</a></div>';
	} else {
		$content .= '<div class="tlp-position">' . $designation . '</div>';
	}
}

$html .= ( $content ? "<div class='tlp-content'>{$content}</div>" : null );

if ( $short_bio && in_array( 'short_bio', $items ) ) {
	$html .= '<div class="short-bio"><p>' . $short_bio . '</p></div>';
}

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
