<?php

/*
Plugin Name: Duolingo Widget
Plugin URI: http://polyglotwannabe.com/
Description: A small plugin to display a widget that retrieves data from my Duolingo account
Version: 1.0
Author: Lidia Cirrone
Author URI: http://polyglotwannabe.com/
*/

if (!defined('ABSPATH')) {
   exit; // Exit if accessed directly
}

if (!function_exists('flags_css')) {
   function flags_css()
   {
      global $post;
      if (has_shortcode($post->post_content, 'duolingo')) {
         wp_enqueue_style('flag-icons-main', plugins_url('pw-duolingo-widget') . '/flag-icons-main/css/flag-icons.min.css', array(), null);
      }
   }
}
add_action('wp_enqueue_scripts', 'flags_css');




if (!function_exists('duolingo_shortcode')) {
   function duolingo_shortcode($attributes)
   {
      include "connect.php";
      // var_dump($resp);
      
      ob_start();
?>
      bla bla bla duo
<?php
      return ob_get_clean();
   }
}
add_shortcode('duolingo', 'duolingo_shortcode');
