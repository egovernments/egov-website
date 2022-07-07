<?php
/**
 * Template: Special 01.
 */

$html = null;

if ( $i == 1 ) {
	$class = $class . ' selected';
}

$html .= "<div class='{$grid} {$class}' data-id='{$mID}'>";
$html .= '<div class="single-team-item image-wrapper" data-id="' . $mID . '">' . $imgHtml . '</div>';
$html .= '</div>';

echo $html;
