<?php
/**
 * Scripts Class.
 *
 * @package RT_Team
 */

namespace RT\Team\Controllers;

/**
 * Scripts Class.
 */
class ScriptsController {
	use \RT\Team\Traits\SingletonTrait;

	/**
	 * Styles.
	 *
	 * @var array
	 */
	private $styles = array();

	/**
	 * Scripts.
	 *
	 * @var array
	 */
	private $scripts = array();

	/**
	 * Class Init.
	 *
	 * @return void
	 */
	protected function init() {
		$this->get_assets();

		if ( empty( $this->styles ) ) {
			return;
		}

		if ( empty( $this->scripts ) ) {
			return;
		}

		$version    = rttlp_team()->version;
		$upload_dir = wp_upload_dir();
		$css_file   = $upload_dir['basedir'] . '/tlp-team/team-sc.css';

		foreach ( $this->styles as $style ) {
			wp_register_style( $style['handle'], $style['src'], '', $version );
		}

		foreach ( $this->scripts as $script ) {
			wp_register_script( $script['handle'], $script['src'], $script['deps'], $version, $script['footer'] );
		}

		if ( file_exists( $css_file ) ) {
			$version = filemtime( $css_file );
			wp_enqueue_style( 'rt-team-sc', set_url_scheme( $upload_dir['baseurl'] ) . '/tlp-team/team-sc.css', array( 'rt-team-css' ), $version );
		}

		wp_localize_script(
			'tlp-team-admin-js',
			'rttm',
			array(
				'is_pro' => rttlp_team()->has_pro(),
			)
		);

		add_action( 'wp_enqueue_scripts', array( $this, 'tlp_script' ) );
	}

	/**
	 * Frontend scripts scripts.
	 *
	 * @return void
	 */
	public function tlp_script() {
		wp_enqueue_style( 'rt-team-css' );
		wp_enqueue_style( 'rt-team-sc' );
	}

	/**
	 * Get all scripts.
	 *
	 * @return void
	 */
	private function get_assets() {
		$this->get_styles()->get_scripts();
	}

	/**
	 * Get styles.
	 *
	 * @return object
	 */
	private function get_styles() {
		$this->styles[] = array(
			'handle' => 'tlp-fontawsome',
			'src'    => rttlp_team()->assets_url() . 'vendor/font-awesome/css/all.min.css',
		);

		$this->styles[] = array(
			'handle' => 'rt-pagination',
			'src'    => rttlp_team()->assets_url() . 'vendor/pagination/pagination.css',
		);

		$this->styles[] = array(
			'handle' => 'tlp-scrollbar',
			'src'    => rttlp_team()->assets_url() . 'vendor/scrollbar/jquery.mCustomScrollbar.min.css',
		);

		$this->styles[] = array(
			'handle' => 'tlp-swiper',
			'src'    => rttlp_team()->assets_url() . 'vendor/swiper/swiper.min.css',
		);

		$this->styles[] = array(
			'handle' => 'rt-team-css',
			'src'    => rttlp_team()->assets_url() . 'css/tlpteam.css',
		);

		/**
		 * Admin Styles.
		 */
		if ( is_admin() ) {
			$this->styles[] = array(
				'handle' => 'tlp-team-admin-css',
				'src'    => rttlp_team()->assets_url() . 'css/settings.css',
			);

			$this->styles[] = array(
				'handle' => 'select2',
				'src'    => rttlp_team()->assets_url() . 'vendor/select2/select2.min.css',
			);
		}

		return $this;
	}

	/**
	 * Get scripts.
	 *
	 * @return object
	 */
	private function get_scripts() {
		$this->scripts[] = array(
			'handle' => 'tlp-scrollbar',
			'src'    => rttlp_team()->assets_url() . 'vendor/scrollbar/jquery.mCustomScrollbar.min.js',
			'deps'   => array( 'jquery' ),
			'footer' => true,
		);

		$this->scripts[] = array(
			'handle' => 'tlp-swiper',
			'src'    => rttlp_team()->assets_url() . 'vendor/swiper/swiper.min.js',
			'deps'   => array( 'jquery' ),
			'footer' => true,
		);

		$this->scripts[] = array(
			'handle' => 'tlp-image-load-js',
			'src'    => rttlp_team()->assets_url() . 'vendor/isotope/imagesloaded.pkgd.min.js',
			'deps'   => array( 'jquery' ),
			'footer' => true,
		);

		$this->scripts[] = array(
			'handle' => 'rt-pagination',
			'src'    => rttlp_team()->assets_url() . 'vendor/pagination/pagination.min.js',
			'deps'   => array( 'jquery' ),
			'footer' => true,
		);

		$this->scripts[] = array(
			'handle' => 'tlp-isotope-js',
			'src'    => rttlp_team()->assets_url() . 'vendor/isotope/isotope.pkgd.min.js',
			'deps'   => array( 'jquery', 'tlp-image-load-js' ),
			'footer' => true,
		);

		$this->scripts[] = array(
			'handle' => 'rt-tooltip',
			'src'    => rttlp_team()->assets_url() . 'js/rt-tooltip.js',
			'deps'   => array( 'jquery' ),
			'footer' => true,
		);

		$this->scripts[] = array(
			'handle' => 'tlp-actual-height-js',
			'src'    => rttlp_team()->assets_url() . 'vendor/actual-height/jquery.actual.min.js',
			'deps'   => array( 'jquery' ),
			'footer' => true,
		);

		$this->scripts[] = array(
			'handle' => 'tlp-team-js',
			'src'    => rttlp_team()->assets_url() . 'js/tlpteam.js',
			'deps'   => array( 'jquery' ),
			'footer' => true,
		);

		/**
		 * Admin Scripts.
		 */
		if ( is_admin() ) {
			$this->scripts[] = array(
				'handle' => 'ace-code-highlighter-js',
				'src'    => rttlp_team()->assets_url() . 'vendor/ace/ace.js',
				'deps'   => null,
				'footer' => true,
			);
			$this->scripts[] = array(
				'handle' => 'ace-mode-js',
				'src'    => rttlp_team()->assets_url() . 'vendor/ace/mode-css.js',
				'deps'   => array( 'ace-code-highlighter-js' ),
				'footer' => true,
			);

			$this->scripts[] = array(
				'handle' => 'tlp-xml2json',
				'src'    => rttlp_team()->assets_url() . 'js/xml2json.min.js',
				'deps'   => array( 'jquery' ),
				'footer' => true,
			);
			$this->scripts[] = array(
				'handle' => 'tlp-xlsx2Json',
				'src'    => rttlp_team()->assets_url() . 'js/xlsx.full.min.js',
				'deps'   => array( 'jquery' ),
				'footer' => true,
			);
			$this->scripts[] = array(
				'handle' => 'tlp-team-export-import',
				'src'    => rttlp_team()->assets_url() . 'js/export-import.js',
				'deps'   => array( 'jquery' ),
				'footer' => true,
			);
			$this->scripts[] = array(
				'handle' => 'tlp-admin-taxonomy',
				'src'    => rttlp_team()->assets_url() . 'js/admin-taxonomy.js',
				'deps'   => array( 'jquery' ),
				'footer' => true,
			);
			$this->scripts[] = array(
				'handle' => 'select2',
				'src'    => rttlp_team()->assets_url() . 'vendor/select2/select2.min.js',
				'deps'   => array( 'jquery' ),
				'footer' => true,
			);
			$this->scripts[] = array(
				'handle' => 'tlp-team-admin-js',
				'src'    => rttlp_team()->assets_url() . 'js/settings.js',
				'deps'   => array( 'jquery' ),
				'footer' => true,
			);
			$this->scripts[] = array(
				'handle' => 'tlp-sc-preview',
				'src'    => rttlp_team()->assets_url() . 'js/sc-preview.js',
				'deps'   => array( 'jquery' ),
				'footer' => true,
			);
		}

		return $this;
	}
}
