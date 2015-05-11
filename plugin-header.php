<?php
/*
Plugin Name: plugin-header
Plugin URI: http://poohBot.com
Description: Marvelous stuff
Version: 2015
Author: Tracey Pooh
Author URI: http://poohBot.com
License: GPL2
*/
?><?

// http://codex.wordpress.org/Plugin_API/Action_Reference

// Make sure we don't expose any info if called directly
if (!function_exists('add_action'))  exit;
  
// other interesting ones...
//add_filter('wp_title',   ...);
//add_action('wp_head',    ...);
//add_filter('body_class', ...);
//add_filter('the_content',...);

add_filter('template_include', function($str){
  get_header();

  wp_enqueue_script('jquery'); // let's assume we'll want jQuery
  wp_enqueue_style ('my-css-name', '/my.css'); // some custom CSS
  wp_enqueue_script('my-js-name', '/my.js'); // some custom JS
  wp_add_inline_style('my-css-name', '
#nasa {
  height:225px;
  overflow:hidden;
  position:relative;
  -webkit-transition: height 1.2s ease;
     -moz-transition: height 1.2s ease;
       -o-transition: height 1.2s ease;
          transition: height 1.2s ease;
}
#nasa:hover{
  height:500px;
}
#nasa h2 {
  position:absolute;
  left:25%;
  top:100px;
  color:white;
  margin:auto;
}
');

  echo '<div id="nasa"><h2>WELCOME, HUMAN!</h2><img src="https://archive.org/download/HSF-photo-91707090/91707090.jpg"/></div>';

  $template = strrchr($str,'/');
  if ($template == '/index.php'){
    // top/home page *or* paging on/from it, eg: /page/2/
    // ..
  }
  else if ($template == '/page.php'){
    // this is a page in WP land
    if (@$_SERVER['REQUEST_URI'] == '/fillin'){
      echo 'i want this content for this page';
      comments_template();
      get_footer();
      return; // this knocks out WP template that would normally render the page
    }
  }
  // else there's more, search pages, category pages, topic pages, archive pages, etc...

  
  // returning the passed in arg has WP do what it would normally do...
  return $str;
});

