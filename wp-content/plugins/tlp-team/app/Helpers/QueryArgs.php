<?php
/**
 * Class to build up query args.
 *
 * @package RT_Team
 */

namespace RT\Team\Helpers;

/**
 * Query Args Class
 */
class QueryArgs {

	/**
	 * Query Args.
	 *
	 * @var array
	 */
	private static $args = array();

	/**
	 * Meta values.
	 *
	 * @var array
	 */
	private static $meta = array();

	/**
	 * Method to build args
	 *
	 * @param array $meta Meta values.
	 * @param bool  $isCarousel Layout type.
	 * @return array
	 */
	public static function buildArgs( array $meta, bool $isCarousel ) {
		self::$meta = $meta;

		// Post Type.
		self::getPostType();

		// Building Args.
		self::postParams()->orderParams()->paginationParams( $isCarousel )->taxParams();

		return self::$args;
	}

	/**
	 * Post type.
	 *
	 * @return void
	 */
	private static function getPostType() {
		self::$args['post_type']   = array( rttlp_team()->post_type );
		self::$args['post_status'] = 'publish';
	}

	/**
	 * Post parameters.
	 *
	 * @return class
	 */
	private static function postParams() {
		$post_in     = ( isset( self::$meta['postIn'] ) ? sanitize_text_field( implode( ', ', self::$meta['postIn'] ) ) : null );
		$post_not_in = ( isset( self::$meta['postNotIn'] ) ? sanitize_text_field( implode( ', ', self::$meta['postNotIn'] ) ) : null );
		$limit       = ( ( empty( self::$meta['limit'] ) || self::$meta['limit'] === '-1' ) ? 10000000 : (int) self::$meta['limit'] );

		if ( $post_in ) {
			$post_in                = explode( ',', $post_in );
			self::$args['post__in'] = $post_in;
		}

		if ( $post_not_in ) {
			$post_not_in                = explode( ',', $post_not_in );
			self::$args['post__not_in'] = $post_not_in;
		}

		self::$args['posts_per_page'] = $limit;

		return new static();
	}

	/**
	 * Order & Orderby parameters.
	 *
	 * @return class
	 */
	private static function orderParams() {
		$order_by = ( isset( self::$meta['order_by'] ) ? esc_html( self::$meta['order_by'] ) : null );
		$order    = ( isset( self::$meta['order'] ) ? esc_html( self::$meta['order'] ) : null );

		if ( $order ) {
			self::$args['order'] = $order;
		}

		if ( $order_by ) {
			self::$args['orderby'] = $order_by;
		}

		return new static();
	}

	/**
	 * Pagination parameters.
	 *
	 * @param bool $isCarousel Layout type.
	 * @return array
	 */
	private static function paginationParams( $isCarousel ) {
		$pagination = ( ! empty( self::$meta['pagination'] ) ? true : false );
		$limit      = ( ( empty( self::$meta['limit'] ) || self::$meta['limit'] === '-1' ) ? 10000000 : (int) self::$meta['limit'] );

		if ( $pagination ) {
			$posts_per_page = ( ! empty( self::$meta['postsPerPage'] ) ? intval( self::$meta['postsPerPage'] ) : $limit );

			if ( $posts_per_page > $limit ) {
				$posts_per_page = $limit;
			}

			self::$args['posts_per_page'] = $posts_per_page;

			if ( is_front_page() ) {
				$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
			} else {
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			}

			$offset              = $posts_per_page * ( (int) $paged - 1 );
			self::$args['paged'] = $paged;

			if ( intval( self::$args['posts_per_page'] ) > $limit - $offset ) {
				self::$args['posts_per_page'] = $limit - $offset;
				self::$args['offset']         = $offset;
			}
		}

		if ( $isCarousel ) {
			self::$args['posts_per_page'] = $limit;
		}

		return new static();
	}

	/**
	 * Taxonomy parameters.
	 *
	 * @return class
	 */
	private static function taxParams() {
		$departmentId   = ( isset( self::$meta['department_ids'] ) ? array_filter( self::$meta['department_ids'] ) : array() );
		$designationId  = ( isset( self::$meta['designation_ids'] ) ? array_filter( self::$meta['designation_ids'] ) : array() );
		$taxQ           = array();
		$taxFilterTerms = array();

		if ( is_array( $departmentId ) && ! empty( $departmentId ) ) {
			$taxFilterTerms = array_merge( $taxFilterTerms, $departmentId );

			$taxQ[] = array(
				'taxonomy' => rttlp_team()->taxonomies['department'],
				'field'    => 'term_id',
				'terms'    => $departmentId,
				'operator' => 'IN',
			);
		}

		if ( ! empty( $designationId ) && is_array( $designationId ) ) {
			$taxFilterTerms = array_merge( $taxFilterTerms, $designationId );
			$taxQ[]         = array(
				'taxonomy' => rttlp_team()->taxonomies['designation'],
				'field'    => 'term_id',
				'terms'    => $designationId,
				'operator' => 'IN',
			);
		}

		if ( count( $taxQ ) >= 2 ) {
			$taxQ['relation'] = self::$meta['relation'];
		}

		if ( ! empty( $taxQ ) ) {
			self::$args['tax_query'] = $taxQ;
		}

		if ( in_array( '_taxonomy_filter', self::$meta['filters'] ) && self::$meta['taxFilter'] && self::$meta['action_term'] ) {
			self::$args['tax_query'] = array(
				array(
					'taxonomy' => self::$meta['taxFilter'],
					'field'    => 'term_id',
					'terms'    => array( self::$meta['action_term'] ),
				),
			);
		}

		return new static();
	}

}
