<?php
/**
 * Widget Class.
 *
 * @author     ThemeFusion
 * @copyright  (c) Copyright by ThemeFusion
 * @link       https://theme-fusion.com
 * @package    Avada Core
 * @subpackage Core
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Widget class.
 */
class Fusion_Widget_Flickr extends WP_Widget {

	/**
	 * Constructor.
	 *
	 * @access public
	 */
	public function __construct() {

		$widget_ops  = [
			'classname'   => 'flickr',
			'description' => __( 'The most recent photos from flickr.', 'Avada' ),
		];
		$control_ops = [
			'id_base' => 'flickr-widget',
		];

		parent::__construct( 'flickr-widget', __( 'Avada: Flickr', 'Avada' ), $widget_ops, $control_ops );

	}

	/**
	 * Echoes the widget content.
	 *
	 * @access public
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {

		extract( $args ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract

		$title       = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '', $instance, $this->id_base );
		$screen_name = $instance['screen_name'];
		$number      = $instance['number'];
		$api         = $instance['api'];

		if ( empty( $api ) ) {
			$api = 'c9d2c2fda03a2ff487cb4769dc0781ea';
		}

		echo $before_widget; // phpcs:ignore WordPress.Security.EscapeOutput

		if ( $title ) {
			echo $before_title . $title . $after_title; // phpcs:ignore WordPress.Security.EscapeOutput
		}
		?>
		<div id="fusion-<?php echo esc_attr( $args['widget_id'] ); ?>-images"></div>

		<?php $consent_needed = class_exists( 'Avada_Privacy_Embeds' ) && Avada()->settings->get( 'privacy_embeds' ) && ! Avada()->privacy_embeds->get_consent( 'flickr' ); ?>
		<?php if ( $screen_name && $number && $api ) : ?>

			<script type="text/javascript">
			function jsonFlickrApi( rsp ) {
				if ( rsp.stat != "ok" ) {
					// If this executes, something broke!
					return;
				}

				//variable "s" is going to contain
				//all the markup that is generated by the loop below
				var s = "";

				//this loop runs through every item and creates HTML
				for ( var i = 0; i < rsp.photos.photo.length; i++ ) {
					photo = rsp.photos.photo[ i ];

					//notice that "t.jpg" is where you change the
					//size of the image
					t_url = "//farm" + photo.farm +
					".static.flickr.com/" + photo.server + "/" +
					photo.id + "_" + photo.secret + "_" + "s.jpg";

					p_url = "//www.flickr.com/photos/" +
					photo.owner + "/" + photo.id;

					s +=  '<div class="flickr_badge_image"><a href="' + p_url + '">' + '<img alt="'+
					photo.title + '"src="' + t_url + '"/>' + '</a></div>';
				}

				$container = document.getElementById( 'fusion-<?php echo esc_attr( $args['widget_id'] ); ?>-images' );
				$container.innerHTML = s;
			}
			</script>

			<?php if ( $consent_needed ) : ?>
				<?php // phpcs:disable WordPress.Security.EscapeOutput, WordPress.WP.EnqueuedResources ?>
				<?php echo Avada()->privacy_embeds->script_placeholder( 'flickr' ); ?>
				<span data-privacy-script="true" data-privacy-type="flickr" class="fusion-hidden" data-privacy-src="https://api.flickr.com/services/rest/?format=json&amp;method=flickr.photos.search&amp;user_id=<?php echo $screen_name; ?>&amp;api_key=<?php echo $api; ?>&amp;media=photos&amp;per_page=<?php echo $number; ?>&amp;privacy_filter=1"></span>
				<span data-privacy-script="true" data-privacy-type="flickr" class="fusion-hidden" data-privacy-src="https://api.flickr.com/services/rest/?format=json&amp;method=flickr.photos.search&amp;group_id=<?php echo $screen_name; ?>&amp;api_key=<?php echo $api; ?>&amp;media=photos&amp;per_page=<?php echo $number; ?>&amp;privacy_filter=1"></span>
			<?php else : ?>
				<script type="text/javascript" src="https://api.flickr.com/services/rest/?format=json&amp;method=flickr.photos.search&amp;user_id=<?php echo $screen_name; ?>&amp;api_key=<?php echo $api; ?>&amp;media=photos&amp;per_page=<?php echo $number; ?>&amp;privacy_filter=1"></script>
				<script type="text/javascript" src="https://api.flickr.com/services/rest/?format=json&amp;method=flickr.photos.search&amp;group_id=<?php echo $screen_name; ?>&amp;api_key=<?php echo $api; ?>&amp;media=photos&amp;per_page=<?php echo $number; ?>&amp;privacy_filter=1"></script>
			<?php endif; ?>
			<?php // phpcs:enable WordPress.Security.EscapeOutput, WordPress.WP.EnqueuedResources ?>

			<?php
		endif;

		echo $after_widget; // phpcs:ignore WordPress.Security.EscapeOutput

	}

	/**
	 * Updates a particular instance of a widget.
	 *
	 * This function should check that `$new_instance` is set correctly. The newly-calculated
	 * value of `$instance` should be returned. If false is returned, the instance won't be
	 * saved/updated.
	 *
	 * @access public
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title']       = isset( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : ''; // phpcs:ignore WordPress.WP.AlternativeFunctions
		$instance['screen_name'] = isset( $new_instance['screen_name'] ) ? $new_instance['screen_name'] : '';
		$instance['number']      = isset( $new_instance['number'] ) ? $new_instance['number'] : '';
		$instance['api']         = isset( $new_instance['api'] ) ? $new_instance['api'] : '';

		return $instance;

	}

	/**
	 * Outputs the settings update form.
	 *
	 * @access public
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {

		$defaults = [
			'title'       => __( 'Photos from Flickr', 'Avada' ),
			'screen_name' => '',
			'number'      => 6,
			'api'         => 'c9d2c2fda03a2ff487cb4769dc0781ea',
		];

		$instance         = wp_parse_args( (array) $instance, $defaults );
		$flickr_getid_url = 'http://idgettr.com/';
		$flickr_apply_url = 'http://www.flickr.com/services/apps/create/apply';
		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'Avada' ); ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<?php /* translators: URL. */ ?>
			<label for="<?php echo esc_attr( $this->get_field_id( 'screen_name' ) ); ?>"><?php printf( __( 'Flickr ID (<a href="%s">Get your flickr ID</a>):', 'Avada' ), esc_url_raw( $flickr_getid_url ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'screen_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'screen_name' ) ); ?>" value="<?php echo esc_attr( $instance['screen_name'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of photos to show:', 'Avada' ); ?></label>
			<input class="widefat" type="text" style="width: 30px;" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" value="<?php echo esc_attr( $instance['number'] ); ?>" />
		</p>

		<p>
			<?php /* translators: URL. */ ?>
			<label for="<?php echo esc_attr( $this->get_field_id( 'api' ) ); ?>"><?php printf( __( 'API key (Use default or get your own from <a href="%s">Flickr APP Garden</a>):', 'Avada' ), esc_url_raw( $flickr_apply_url ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'api' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'api' ) ); ?>" value="<?php echo esc_attr( $instance['api'] ); ?>" />
			<?php /* translators: the default key. */ ?>
			<small><?php printf( esc_html__( 'Default key is: %s', 'Avada' ), 'c9d2c2fda03a2ff487cb4769dc0781ea' ); ?></small>
		</p>

		<?php
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
