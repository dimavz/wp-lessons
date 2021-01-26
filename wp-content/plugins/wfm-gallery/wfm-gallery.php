<?php
/*
Plugin Name: Галерея
Description: Используйте шорткод вида: [gallery ids="1,2,3"], где в атрибуте ids указывайте ID картинок
Plugin URI: http://webformyself.com
Author: Андрей
Author URI: http://webformyself.com
*/

remove_shortcode( 'gallery' );
add_shortcode( 'gallery', 'wfm_gallery' );
add_action( 'wp_enqueue_scripts', 'wfm_add_styles_scripts' );
add_action( 'admin_init', 'wfm_gallery_options' );
register_deactivation_hook( __FILE__, 'wfm_gall_delete_options' );

function wfm_gall_delete_options(){
	delete_option( 'wfm_gallery_options' );
}

function wfm_gallery_options(){
	// $option_group, $option_name, $sanitize_callback
	register_setting( 'general', 'wfm_gallery_options' );

	// $id, $title, $callback, $page
	add_settings_section( 'gallery_section_id', 'Опции галереи', '', 'general' );

	// $id, $title, $callback, $page, $section, $args
	add_settings_field( 'gallery_option_title', 'Название галереи', 'wfm_gallery_title_cb', 'general', 'gallery_section_id' );
	add_settings_field( 'gallery_option_text', 'Текст при отсутствии картинок', 'wfm_gallery_text_cb', 'general', 'gallery_section_id' );
}

function wfm_gallery_title_cb(){
	$options = get_option('wfm_gallery_options');
	?>

<input type="text" name="wfm_gallery_options[gallery_option_title]" id="gallery_option_title" value="<?php echo esc_attr($options['gallery_option_title']); ?>" class="regular-text">

	<?php
}

function wfm_gallery_text_cb(){
	$options = get_option('wfm_gallery_options');
	?>

<input type="text" name="wfm_gallery_options[gallery_option_text]" id="gallery_option_text" value="<?php echo esc_attr($options['gallery_option_text']); ?>" class="regular-text">

	<?php
}

function wfm_add_styles_scripts(){
	wp_register_script( 'wfm-lightbox-js', plugins_url( 'js/lightbox.min.js', __FILE__ ), array('jquery') );
	wp_register_style( 'wfm-lightbox', plugins_url( 'css/lightbox.css', __FILE__ ) );
	wp_register_style( 'wfm-lightbox-style', plugins_url( 'css/lightbox-style.css', __FILE__ ) );

	wp_enqueue_script( 'wfm-lightbox-js' );
	wp_enqueue_style( 'wfm-lightbox' );
	wp_enqueue_style( 'wfm-lightbox-style' );
}

function wfm_gallery($atts){
//    echo '<pre>';
//    print_r($atts);
//    echo '</pre>';
//    exit();
    $html = '';
    $options = get_option( 'wfm_gallery_options' );
    if(!empty($atts))
    {
        $img_id = explode(',', $atts['ids']);

        if( empty($atts) && !$img_id[0] ) return '<div class="wfm-gallery"><h3>' . $options['gallery_option_title'] . '</h3>' . $options['gallery_option_text'] . '</div>';
        $html = '<div class="wfm-gallery"><h3>' . $options['gallery_option_title'] . '</h3>';
        foreach($img_id as $item){
            $img_data = get_posts( array(
                'p' => $item,
                'post_type' => 'attachment'
            ) );

            $img_desc = $img_data[0]->post_content;
            $img_caption = $img_data[0]->post_excerpt;
            $img_title = $img_data[0]->post_title;
            $img_thumb = wp_get_attachment_image_src( $item );
            $img_full = wp_get_attachment_image_src( $item, 'full' );

            $html .= "<a href='{$img_full[0]}' data-lightbox='gallery' data-title='{$img_caption}'><img src='{$img_thumb[0]}' width='{$img_thumb[1]}' height='{$img_thumb[2]}' alt='{$img_title}'></a>";
        }
        $html .= '</div>';
    }
    else{
        return '<div class="wfm-gallery"><h3>' . $options['gallery_option_title'] . '</h3>' . $options['gallery_option_text'] . '</div>';
    }
	return $html;
}