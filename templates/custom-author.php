<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package labs_by_Sedoo
 */
// get the current taxonomy term
$userObject = get_queried_object()->data;

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main user-page">
            <div class="user-informations">
            <?php 
                $img_id = get_user_meta($userObject->ID, 'photo_auteur', true);
                $primaryblogid = get_user_meta($userObject->ID, 'primary_blog', true);
                if($primaryblogid == 1) {
                    $table_name = 'posts';
                }
                else {
                    $table_name = $primaryblogid.'_posts';
                }
                global $wpdb;
                $results = $wpdb->get_results( "SELECT * FROM {$wpdb->base_prefix}".$table_name." WHERE ID = ".$img_id, OBJECT );
                if($results) {
                    $url = $results[0]->guid;
                    ?>
                    <figure>
                        <img src="<?php echo esc_url($url); ?>" alt="<?php echo get_user_meta( $userObject->ID,'first_name', true). ' '.get_user_meta( $userObject->ID,'last_name', true); ?>" />
                    </figure>
                    <?php 
                } else {
                    ?>
                    <figure>
                        <img src="<?php echo plugins_url('empty-user.svg', __FILE__); ?>" alt="<?php echo get_user_meta( $userObject->ID,'first_name', true). ' '.get_user_meta( $userObject->ID,'last_name', true); ?>" />
                    </figure>
                    <?php 
                }
                ?>
                <h1><span class="firstname">
                    <?php
                        the_author_meta('user_firstname', $userObject->ID);
                    ?> 
                    </span>
                    <?php
                        the_author_meta('user_lastname', $userObject->ID);    
                    ?>
                </h1>
                <p class="h3 poste"><?php the_field('poste', 'user_'.$userObject->ID);?></p>
                <p class="gradeTutelle"><em>
                    <?php the_field('grade', 'user_'.$userObject->ID);?> <?php the_field('tutelle', 'user_'.$userObject->ID);?></em>
                </p>

                <div class="user-administratives-informations">
                    <p><b>Email :</b>
                        <?php 
                        $userMail = explode("@", get_the_author_meta('user_email', $userObject->ID)); 
                        echo $userMail[0]."<span class=\"hideEmail\">Dear bot, you won't get my mail address</span>@<span class=\"hideEmail\">and my domain...</span>".$userMail[1]; ?>
                        </a>
                    </p>
                    <?php the_field('ldap_field', 'user_'.$userObject->ID); ?>
                    <p><b>Adresse professionnelle :</b><?php the_field('adresse_pro', 'user_'.$userObject->ID); ?></p>
                    <p>
                    <a class="user-siteperso" href="<?php the_field('url_site_perso', 'user_'.$userObject->ID); ?>" target="_blank"><b>>> Site web personnel</b></a></p>
                </div>

            </div>
           
            <section class="author-content wrapper-content">                    
                <section class="user-description">
                    <p>
                    <?php echo get_the_author_meta('user_description', $userObject->ID); ?>
                    </p>
                </section>             
                    
                
                <nav class="users-tabs" role="tablist">
                <?php

                if (get_field('cv_fonctions', 'user_'.$userObject->ID)) {  // SHOW CV/ FUNCTIONS
                    sedoo_userpage_displayACF_content('cv_fonctions', $userObject->ID, true);
                } 

                if (get_field('travaux_de_recherche', 'user_'.$userObject->ID)) { // SHOW RESEARCH
                    sedoo_userpage_displayACF_content('travaux_de_recherche', $userObject->ID, false);
                } 
                
                if (get_field('responsabilites', 'user_'.$userObject->ID)) { // SHOW RESPONSABILITIES
                    sedoo_userpage_displayACF_content('responsabilites', $userObject->ID, false);
                }

                // SHOW PUBLICATIONS
                if (get_field('publis', 'user_'.$userObject->ID)) {
                    sedoo_userpage_displayACF_content('publis', $userObject->ID, false);
                }

                // SHOW PROJECTS
                if (get_field('projets', 'user_'.$userObject->ID)) {
                    sedoo_userpage_displayACF_content('projets', $userObject->ID, false);
                }
                
                // SHOW TEACHING
                if (get_field('enseignement', 'user_'.$userObject->ID)) {
                    sedoo_userpage_displayACF_content('enseignement', $userObject->ID, false);
                } 

                // SHOW RSX METIERS
                if (get_field('rsx_metiers', 'user_'.$userObject->ID)) {
                    sedoo_userpage_displayACF_content('rsx_metiers', $userObject->ID, false);
                } 
                ?>
                 </nav> 
            </section>
                                
                <?php //endif; ?>
                
            </div>
		</main><!-- #main -->
        
	</div><!-- #primary -->
<?php

get_footer();
