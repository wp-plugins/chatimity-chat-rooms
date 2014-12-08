<?php
/**
 * Plugin Name: Chatimity Chat Rooms
 * Plugin URI: http://chatimity.com/wp/chatimity-widget.zip
 * Description: Widget for visitors to chat using chatimity on a particular topic.
 * Version: 1.0.2
 * Author: Chatimity Software Pvt Ltd
 * Author URI: http://chatimity.com
 *
 */

add_action( 'widgets_init', 'chatimity_load_widgets' );

/**
 * Register widget.
 */
function chatimity_load_widgets() {
    register_widget( 'Chatimity_Widget' );
}

/**
 * Chatimity Widget class.
 * Adds the html to load chatimity widget.
 *
 * @since 0.1
 */
class Chatimity_Widget extends WP_Widget {

    function Chatimity_Widget() {
        $widget_ops = array( 'classname' => 'chatimity', 'description' => __('Widget for visitors to chat using chatimity on a particular topic', 'chatimity') );

        $control_ops = array( 'width' => 250, 'height' => 400, 'id_base' => 'chatimity-widget' );

        $this->WP_Widget( 'chatimity-widget', __('Chatimity Chat Rooms', 'chatimity'), $widget_ops, $control_ops );
    }

    function widget( $args, $instance ) {
        extract( $args );

        $topics = $instance['topics'];
        $title = $instance['title'];

        echo $before_widget;

        printf( '<script type="text/javascript">' );
        printf( '   var chatimity_url = "https://secure.chatimity.com/widget?ct=6&cv=2&title=%s&topics=%s";', urlencode($title), urlencode(str_replace(",", " ", $topics)) );
        printf( '   (function() {' );
        printf( '   var e = document.createElement("script"); e.type = "text/javascript"; e.async = true;' );
        printf( '   e.src = "https://secure.chatimity.com/chat.js";' );
        printf( '   var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(e, s);' );
        printf( '   }());' );
        printf( '</script>' );

        echo $after_widget;

    }

	/**
	 * Update the widget settings.
	 */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['topics'] = strip_tags( $new_instance['topics'] );
        return $instance;
    }

    function form( $instance ) {

        /* Set up some default widget settings. */
        $defaults = array( 'title' => __('Music Chat', 'chatimity'), 'topics' => __('Music', 'chatimity') );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <!-- Widget Title -->
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'chatimity'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>

        <!-- Widget Topic -->
        <p>
            <label for="<?php echo $this->get_field_id( 'topics' ); ?>"><?php _e('Topics:', 'chatimity'); ?></label>
            <input id="<?php echo $this->get_field_id( 'topics' ); ?>" name="<?php echo $this->get_field_name( 'topics' ); ?>" value="<?php echo $instance['topics']; ?>" style="width:100%;" />
        </p>

    <?php
    }
}

?>
