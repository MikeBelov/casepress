<?php

add_action('init', 'gf_register_cases_posttype');
function gf_register_cases_posttype() {
  global $cpanel;
  $n = array('Дело', 'Дела', 'Дел');//in next versions this variable need move to options WP

  $labels = array(
    'name' => $n[1],
    'singular_name' => $n[0],
    'add_new' 			=> 'Добавить',
    'add_new_item' 		=> 'Добавить '.$n[0],
    'edit_item' 		=> 'Редактировать '.$n[0],
    'new_item' 			=> 'Новое '.$n[0],
    'view_item' 		=> 'Просмотр '.$n[1],
    'search_items' 		=> 'Поиск '.$n[1],
    'not_found' 		=> $n[0].' не найдено',
    'not_found_in_trash'=> 'В корзине '.$n[0].' не найдено',
    'parent_item_colon' => ''
    );

  $supports = array(
    'editor',
    'comments',
    'title'
     );

  //add custom-fields, if it is enable
  if (get_option( 'enable_custom_fields_for_cases' )) $supports[]="custom-fields";
  if (get_option( 'enable_custom_fields_for_cases' )) $supports[]="excerpt";
      
  $args = array(
    'labels' => $labels,
    'singular_label' => $n[0],
    'public' => true,
    'show_ui' => true,
    'query_var' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => true,
    'rewrite' => array('slug' => 'cases', 'with_front' => false ),
    'supports' => $supports,
    'menu_position' => 5,
    //'taxonomies' => $taxonomies
  );

  register_post_type('cases',$args);
  add_rewrite_rule('^cases/(\d+)/[^/]+/?$', 'index.php?post_type=cases&p=$matches[1]', 'top');
} 



add_action('init', 'gf_cases_rewrite');
function gf_cases_rewrite(){
  global $wp_rewrite;
  $wp_rewrite->add_rewrite_tag('%cases_id%', '([^/]+)', 'post_type=cases&p=');
  $wp_rewrite->add_permastruct('cases', '/cases/%cases_id%', false);
  
} 




add_action( 'admin_menu', 'remove_cases_metabox' );
function remove_cases_metabox() {
  remove_meta_box('functionsdiv', 'cases', 'side');
  remove_meta_box('tagsdiv-navigation', 'cases', 'side');
  remove_meta_box('tagsdiv-results', 'cases', 'side');
  remove_meta_box('tagsdiv-state', 'cases', 'side');  
  remove_meta_box('commentsdiv', 'cases', 'side');  
}

add_filter('post_type_link', 'cases_post_type_link', 9, 3);
 
function cases_post_type_link( $link, $post = 0 ){
    if ( $post->post_type == 'cases' ){
        return home_url( 'cases/' . $post->ID );
    } else {
        return $link;
    }
}
 
add_action( 'init', 'cases_rewrites_init' );
 
function cases_rewrites_init(){
    add_rewrite_rule(
        'cases/([0-9]+)?$',
        'index.php?post_type=cases&p=$matches[1]',
        'top' );
}


/*
add_filter('post_type_link', 'gf_fix_permalink', 1, 2);
function gf_fix_permalink( $post_link, $id = 0 ) {
  $r = get_post($id);
  if(is_wp_error($r) || $r->post_type != 'cases') return $post_link;
  empty($r->slug) and $r->slug = sanitize_title_with_dashes($r->post_title);
  return home_url(user_trailingslashit("cases/$r->ID"));
} 

function gf_cases_flush_rules(){
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
} add_action('init', 'gf_cases_flush_rules', 100);
*/