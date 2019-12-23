<?php
/**
 * Plugin Name:     Sedoo Wppl Userpage
 * Plugin URI:      https://github.com/sedoo/sedoo-wppl-userpage
 * Description:     Pages profils utilisateurs
 * Author:          Pierre VERT - SEDOO DATA CENTER
 * Author URI:      https://www.sedoo.fr 
 * Text Domain:     sedoo-wppl-userpage
 * Domain Path:     /languages
 * Version:         0.1.0
 * GitHub Plugin URI: sedoo/sedoo-wppl-userpage
 * GitHub Branch:     master
 * @package         Sedoo_Wppl_Userpage
 */


/**
 * REGISTER ACF fields 
 */
include(plugin_dir_path(__FILE__).'inc/sedoo-wppl-acf-config.php');

/**
 * INSERT USER CUSTOM FIELD 
 */
include(plugin_dir_path(__FILE__).'inc/simple_html_dom.php');

// Create DOM from URL or file
// $html = new simple_html_dom();
// $html = file_get_html("http://www.get.obs-mip.fr/profils/Aretz_Markus");

// echo userpage_extract_html($html, 'div#tab1');

function userpage_extract_html($html, $element) {

    foreach($html->find(''.$element.'') as $e) {

        // remove attributes
        if (isset($e->id)){    
            $e->id = null;   
        }
        if (isset($e->class)){
            $e->class = null;   
        }
        return $e;
    }
}

// function sedoo_userpage_new_action( $actions, $user ) {
//     $actions['new_action'] = "<a class='new_action' href='" . admin_url( "users.php?&action=new_action&amp;user=$user->ID") . "'>" . esc_html__( 'Récupérer les pages profils', 'sedoo-wppl-userpage' ) . "</a>";
//     return $actions;
// }
// add_filter('user_row_actions', 'sedoo_userpage_new_action', 10, 2);

add_action('profile_update', 'sedoo_userpage_update_extra_profile_fields', 10, 2);
function sedoo_userpage_update_extra_profile_fields($user_id) {  

    // Create DOM from URL or file
    $html = new simple_html_dom();
    $html = file_get_html("http://www.get.obs-mip.fr/profils/Aretz_Markus");

    //******************************* REMOVE ATTR <A> eZTOC  ******************************* -->
    foreach($html->find('a') as $e) {
        // remove attributes
        if (isset($e->id)){
            $e->id = null;
        }
        if (isset($e->name)){
            $e->name = null;
        }
    }
    $cv = userpage_extract_html($html, 'div#tab1');
    $research = userpage_extract_html($html, 'div#tab2');
    $responsabilites = userpage_extract_html($html, 'div#tab3');
    $publications = userpage_extract_html($html, 'div#tab4');
    $projets = userpage_extract_html($html, 'div#tab5');
    $enseignement = userpage_extract_html($html, 'div#tab6');
    $rsxMetiers = userpage_extract_html($html, 'div#tab7');
    
    if ( current_user_can('edit_user',$user_id) ) {
        if (get_user_meta($user_id, 'cv_fonctions') == "") {
            update_user_meta($user_id, 'cv_fonctions', ''.$cv.'');
        }
        if (get_user_meta($user_id, 'travaux_de_recherche') == "") {
        update_user_meta($user_id, 'travaux_de_recherche', ''.$research.'');
        }
        if (get_user_meta($user_id, 'responsabilites') == "") {
            update_user_meta($user_id, 'responsabilites', ''.$responsabilites.'');
        }
        if (get_user_meta($user_id, 'publis') == "") {
            update_user_meta($user_id, 'publis', ''.$publications.'');
        }
        if (get_user_meta($user_id, 'projets') == "") {
            update_user_meta($user_id, 'projets', ''.$projets.'');
        }
        if (get_user_meta($user_id, 'enseignement') == "") {
            update_user_meta($user_id, 'enseignement', ''.$enseignement.'');
        }
        if (get_user_meta($user_id, 'rsx_metiers') == "") {
            update_user_meta($user_id, 'rsx_metiers', ''.$rsxMetiers.'');
        }
    }
         
}


// TEMPLATE
add_filter( 'template_include', 'sedoo_userpage_template_loader' );

function sedoo_userpage_template_loader( $template ) {

    $file = '';

    if ( is_author() ) {
        $file   = 'custom-author.php'; // the name of your custom template
        $find[] = $file;
        $find[] = 'sedoo_wppl_userpage/' . $file; // name of folder it could be in, in user's theme
    } 

    if ( $file ) {
        $template       = locate_template( array_unique( $find ) );
        if ( ! $template ) { 
            // if not found in theme, will use your plugin version
            $template = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/templates/' . $file;
        }
    }

    return $template;
}