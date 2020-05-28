<?php
/**
 * Plugin Name:     Sedoo Wppl Userpage
 * Plugin URI:      https://github.com/sedoo/sedoo-wppl-userpage
 * Description:     Pages profils utilisateurs
 * Author:          Pierre VERT - SEDOO DATA CENTER
 * Author URI:      https://www.sedoo.fr 
 * Text Domain:     sedoo-wppl-userpage
 * Domain Path:     /languages
 * Version:         0.5.3
 * GitHub Plugin URI: sedoo/sedoo-wppl-userpage
 * GitHub Branch:     master
 * @package         Sedoo_Wppl_Userpage
 */


/**
 * REGISTER ACF fields 
 */
include(plugin_dir_path(__FILE__).'inc/sedoo-wppl-acf-config.php');


include 'sedoo-wppl-userpage-acf.php';
include 'sedoo-wppl-userpage-functions.php';


// si la taxonomie research team tag n'est pas présente, je charge un fichier différent
function sedoo_check_teamtagtaxo() {
    include 'inc/sedoo-wppl-userpage-default-acf-fields.php';
    if(taxonomy_exists('sedoo-research-team-tag')) {
        include 'inc/sedoo-wppl-userpage-teamtag-acf-fields.php';
    } 
}
add_action('init','sedoo_check_teamtagtaxo');

// LOAD CSS & SCRIPTS 
function sedoo_userpage_scripts() {
    wp_register_style( 'sedoo_userpage', plugins_url('css/sedoo_userpage.css', __FILE__) );
    wp_enqueue_style( 'sedoo_userpage' );
}
add_action('wp_enqueue_scripts','sedoo_userpage_scripts');
function sedoo_userpage_color_style() {
    $code_color = get_theme_mod( 'labs_by_sedoo_color_code' );
    ?>
    <style type="text/css">
    :root {
        --main-color:<?php echo $code_color;?>;
    }

    .user-administratives-informations,
    .user-tabs [type="radio"]:checked + label,
    .user-tabs label:hover {
        background:var(--main-color);
    }

    <?php
    
}
add_action( 'wp_head', 'sedoo_userpage_color_style');

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

// recover LDAP OMP INFORMATIONS

function sedoo_userpage_recover_ldap_fields($user_id) {

    $wp_user_info = get_userdata($user_id);
    $wp_user_email = $wp_user_info->user_email;

    $fileLDAP=fopen("https://annuaire.obs-mip.fr/listeWithPageProfil.csv", "r");

    $result = false;
    while ($row = fgetcsv($fileLDAP, 1000, ";")) {
        if ($row[3] == $wp_user_email) {
            $result = $row;
            break;
        }
    }
    fclose($fileLDAP);
    return $result;
}

add_action('profile_update', 'sedoo_userpage_update_extra_profile_fields', 10, 2);
function sedoo_userpage_update_extra_profile_fields($user_id) {  

    $userLDAPinfo = sedoo_userpage_recover_ldap_fields($user_id);

    if (array_key_exists (0, $userLDAPinfo)){$labo=$userLDAPinfo[0];}
    // if (array_key_exists (1, $userLDAPinfo)){$nom=$userLDAPinfo[1];}                 // USE WP USER INFORMATION
    // if (array_key_exists (2, $userLDAPinfo)){$prenom=$userLDAPinfo[2];}              // USE WP USER INFORMATION
    // if (array_key_exists (3, $userLDAPinfo)){$mail=explode("@", $userLDAPinfo[3]);}  // USE WP USER INFORMATION
    if (array_key_exists (4, $userLDAPinfo)){$tel=$userLDAPinfo[4];}
    if (array_key_exists (5, $userLDAPinfo)){$bureau=$userLDAPinfo[5];}
    if (array_key_exists (6, $userLDAPinfo)){$site=$userLDAPinfo[6];}
    if (array_key_exists (7, $userLDAPinfo)){$status=$userLDAPinfo[7];}
    if (array_key_exists (8, $userLDAPinfo)){$equipe=$userLDAPinfo[8];}
  
    // force insert LDAP informations !!! user can't modify this field content !!!
    $administrativeInformation = "<p><b>Tel :</b>".$tel."</p>\n<p><b>Bureau :</b>".$bureau.", ".$site."</p>\n<div class=\"deploy\"><p><b>Status :</b>".$status."</p></div>";
    update_user_meta($user_id, 'ldap_field', ''.$administrativeInformation.'');


    // GET FIRST NAME & LAST NAME FROM WP USERMETA
    $firstName = get_user_meta($user_id, 'first_name', true);
    $lastName = get_user_meta($user_id, 'last_name', true);
    // remplacement DE TOUS LES ESPACES par des "-" sur NOM PRENOM
    $firstName_url=str_replace(" ", "-", $firstName);
    $lastName_url=str_replace(" ", "-", $lastName);

    // URL LABO
    $url_labo=array(
        // "CESBIO" => "https://www.cesbio.cnrs.fr",
        "ECOLAB" => "http://www3.obs-mip.fr/ecolab/",
        "GET" => "http://www3.obs-mip.fr/get/",
        "IRAP" => "http://www3.obs-mip.fr/irap/",
        "LA" => "http://www3.obs-mip.fr/la/",
        // "LEGOS" => "http://www.legos.obs-mip.fr/",
        // "TBL" => "http://tbl.omp.eu/",
        // "UMS831" => "http://www.obs-mip.fr/",
    );

    // GENERATE URL_PROFIL TO GET CONTENT
    $urlProfil = $url_labo[$labo]."profils/".$lastName_url."_".$firstName_url;

    // Create DOM from URL or file
    $html = new simple_html_dom();
    $html = file_get_html($urlProfil);
    // var_dump($html);

    if ($html == true) {
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
            if (get_user_meta($user_id, 'cv_fonctions', true) == "") {
                update_user_meta($user_id, 'cv_fonctions', ''.$cv.'');
            }
            if (get_user_meta($user_id, 'travaux_de_recherche', true) == "") {
            update_user_meta($user_id, 'travaux_de_recherche', ''.$research.'');
            }
            if (get_user_meta($user_id, 'responsabilites', true) == "") {
                update_user_meta($user_id, 'responsabilites', ''.$responsabilites.'');
            }
            if (get_user_meta($user_id, 'publis', true) == "") {
                update_user_meta($user_id, 'publis', ''.$publications.'');
            }
            if (get_user_meta($user_id, 'projets', true) == "") {
                update_user_meta($user_id, 'projets', ''.$projets.'');
            }
            if (get_user_meta($user_id, 'enseignement', true) == "") {
                update_user_meta($user_id, 'enseignement', ''.$enseignement.'');
            }
            if (get_user_meta($user_id, 'rsx_metiers', true) == "") {
                update_user_meta($user_id, 'rsx_metiers', ''.$rsxMetiers.'');
            }
        }
    // } else {
    //     echo "<h1>NO CONTENT AVAILABLE</h1>";
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
        // $template       = locate_template( array_unique( $find ) );
        // if ( ! $template ) { 
            // if not found in theme, will use your plugin version
            $template = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/templates/' . $file;
        //}
    }

    return $template;
}

// Display content ACF

function sedoo_userpage_displayACF_title($fieldName) {
    $title = array(
        'cv_fonctions'          => __('CV / functions', 'sedoo-wppl-labtools' ),
        'travaux_de_recherche'  => __('Research', 'sedoo-wppl-labtools' ),
        'responsabilites'       => __('Responsabilities', 'sedoo-wppl-labtools' ),
        'publis'                => __('Publications', 'sedoo-wppl-labtools' ),
        'projets'               => __('Projects', 'sedoo-wppl-labtools' ),
        'enseignement'          => __('Teaching', 'sedoo-wppl-labtools' ),
        'rsx_metiers'           => __('Network', 'sedoo-wppl-labtools' ),
    
    );
    return $title[$fieldName];
}

function sedoo_userpage_displayACF_menuContent($fieldName, $userID) { 
    ?>
    <li><a href="#<?php echo $fieldName;?>" ><?php echo sedoo_userpage_displayACF_title($fieldName);?> </a></li>
    <?php
}

function sedoo_userpage_displayACF_content($fieldName, $userID, $checked) {
    if (get_field($fieldName, 'user_'.$userID) ) { ?>
    <section id="<?php echo $fieldName;?>_section">
        <input type="checkbox" name="tabs" id="<?php echo $fieldName;?>" />
        <label for="<?php echo $fieldName;?>" id="<?php echo $fieldName;?>Tab" role="tab" aria-controls="<?php echo $fieldName;?>panel"><?php echo sedoo_userpage_displayACF_title($fieldName);?></label>
        <article id="<?php echo $fieldName;?>panel" role="tabpanel" aria-labelledby="<?php echo $fieldName;?>Tab">
            <?php the_field($fieldName, 'user_'.$userID);?>
        </article>
    </section>
    <?php } 
}

