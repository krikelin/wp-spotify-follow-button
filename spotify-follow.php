<?php
/**
 * Plugin Name: Spotify Follow Widget
 * Plugin URI: http://www.dr-sounds.com
 * Description: Easy add follow buttons on Wordpress
 * Version: 1.0
 * Author: Alexander Forselius
 * Author URI: http://www.aleros.se
 * Text Domain: ac_spotify_follow
 * License: GPL2
 */
/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : PLUGIN AUTHOR EMAIL)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Creating the widget 
class AC_Spotify_Follow_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'AC_Spotify_Follow_Widget', 

			// Widget name will appear in UI
			__('Spotify Follow Widget', 'ac_spotify_follow'), 

			// Widget description
			array( 'description' => __( 'Follow button on Spotify', 'ac_spotify_follow' ), ) 
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		$spotify_uri = apply_filters( 'widget_spotify_uri', $instance['spotify_uri'] );
		$theme = apply_filters( 'widget_theme', $instance['theme'] );
		$size = apply_filters( 'widget_size', $instance['size'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		// This is where you run the code and display the output
		?><iframe src="https://embed.spotify.com/follow/1/?size=<?php echo $size?>&uri=<?php echo $spotify_uri?>&theme=<?php echo $theme?>" width="300" height="56" scrolling="no" frameborder="0" style="border:none; overflow:hidden;" allowtransparency="true"></iframe><?php

			echo $args['after_widget'];
	}
				
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'size' ] ) ) {
			$size = $instance[ 'size' ];
		}
		else {
			$size = __( 'detailed', 'ac_spotify_follow' );
		}
		
		if ( isset( $instance[ 'spotify_uri' ] ) ) {
			$spotify_uri = $instance[ 'spotify_uri' ];
		}
		else {
			$spotify_uri = __( 'spotify:user:drsounds', 'ac_spotify_follow' );
		}
		if ( isset( $instance[ 'theme' ] ) ) {
			$theme = $instance[ 'theme' ];
		}
		else {
			$theme = __( 'spotify:user:drsounds', 'ac_spotify_follow' );
		}
		// Widget admin form
		$sizes = array('detailed' => __('Detailed', 'ac_spotify_follow' ), 'basic' => __('Basic', 'ac_spotify_follow' ));
		$themes = array('dark' => __('Dark', 'ac_spotify_follow' ), 'light' => __('Light', 'ac_spotify_follow' ));
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Layout', 'ac_spotify_follow' ); ?></label> <br />
		<select id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>">
			<?php foreach($sizes as $k => $v): ?>
			<option <?php if($k == $size): echo "selected"; endif;?> value="<?php echo $k?>"><?php echo $v?></option>
			<?php endforeach;?>
		</select><br />
		
		<label for="<?php echo $this->get_field_id( 'theme' ); ?>"><?php _e( 'Theme', 'ac_spotify_follow'  ); ?></label> <br (>
		<select id="<?php echo $this->get_field_id( 'theme' ); ?>" name="<?php echo $this->get_field_name( 'theme' ); ?>">
			<?php foreach($themes as $k => $v): ?>
			<option <?php if($k == $theme): echo "selected"; endif;?> value="<?php echo $k?>"><?php echo $v?></option>
			<?php endforeach;?>
		</select><br />
		<label for="<?php echo $this->get_field_id( 'spotify_uri' ); ?>"><?php _e( 'Spotify URI', 'ac_spotify_follow'  ); ?></label> <br />
		<input class="widefat" id="<?php echo $this->get_field_id( 'spotify_uri' ); ?>" name="<?php echo $this->get_field_name( 'spotify_uri' ); ?>" type="text" value="<?php echo esc_attr( $spotify_uri ); ?>" />
		
		<hr/>
		<p>Follow me on Spotify</p>
		<iframe src="https://embed.spotify.com/follow/1/?uri=spotify:user:drsounds&size=detail&theme=light" width="300" height="56" scrolling="no" frameborder="0" style="border:none; overflow:hidden;" allowtransparency="true"></iframe>
		
		</p>
		<?php 
	}
		
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['spotify_uri'] = ( ! empty( $new_instance['spotify_uri'] ) ) ? strip_tags( $new_instance['spotify_uri'] ) : '';
		$instance['theme'] = ( ! empty( $new_instance['theme'] ) ) ? strip_tags( $new_instance['theme'] ) : '';
		$instance['size'] = ( ! empty( $new_instance['size'] ) ) ? strip_tags( $new_instance['size'] ) : '';
		return $instance;
	}
} // Class wpb_widget ends here

// Register and load the widget
function ac_load_widget() {
	register_widget( 'AC_Spotify_Follow_Widget' );
}
add_action( 'widgets_init', 'ac_load_widget' );