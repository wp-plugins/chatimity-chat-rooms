<?php
/**
 * Plugin Name: Chatimity Site Chat
 * Plugin URI: http://chatimity.com/wp/chatimity-widget.zip
 * Description: Widget for visitors to chat using chatimity on a particular topic.
 * Version: 2.0.1
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

        $title = $instance['title'];
        $width = $instance['width'];
        $height = $instance['height'];

        $canonical_name = preg_replace("/([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/?])+/", "", $title);
        $trimmed_nospace = trim(preg_replace("/\s+/", " ", $canonical_name));
        $formatted = strtolower(preg_replace("/ /", "-", $trimmed_nospace));

        echo $before_widget;

        printf( '<script async id="chatimity" src="https://secure.chatimity.com/chat.js?v=2"> {"url": "title=%s+Chat&topics=%s&cv=2", "width": "%dpx", "height": "%dpx"} </script>', $formatted, $formatted, intval($width), intval($height) );


        echo $after_widget;

    }

  /**
   * Update the widget settings.
   */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['width'] = strip_tags( $new_instance['width'] );
        $instance['height'] = strip_tags( $new_instance['height'] );

        return $instance;
    }

    function form( $instance ) {

        /* Set up some default widget settings. */
        $defaults = array( 'title' => __('Trivia', 'chatimity'), 'topics' => __('Trivia', 'chatimity'), 'height' => '400', 'width' => '250' );
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <!-- Widget Title -->
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'chatimity'); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
        </p>

        <!-- Widget Height -->
        <p>
            <label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Height (px):', 'chatimity'); ?></label>
            <input onkeyup="if(this.value.match(/[^0-9]/g)){this.value=this.value.replace(/[^0-9]/g,'');}" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php echo $instance['height']; ?>" style="width:100%;" />
        </p>

        <!-- Widget Width -->
        <p>
            <label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e('Width (px):', 'chatimity'); ?></label>
            <input onkeyup="if(this.value.match(/[^0-9]/g)){this.value=this.value.replace(/[^0-9]/g,'');}" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php echo $instance['width']; ?>" style="width:100%;" />
        </p>
    <?php
    }
}

?>
