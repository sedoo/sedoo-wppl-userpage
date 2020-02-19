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
		<main id="main" class="site-main">
        <?php 
        var_dump($userObject); 
        ?>
            <div class="wrapper-layout">
                <?php //if (have_posts()): the_post(); ?>
                <div class="author-header">
                    <h1> 
                        <?php
                            the_author_meta('user_firstname', $userObject->ID);
                        ?> 
                        <?php
                            the_author_meta('user_lastname', $userObject->ID);    
                        ?>
                    </h1>
                    <p class="h2"><?php the_field('poste', 'user_'.$userObject->ID);?>
                    </p>
                    
                </div>
                <div class="author-card">
                    <div>
                        <div class="img-author">
                            
                            <img src="<?php the_field('photo_auteur', 'user_'.$userObject->ID); ?>"/>
                        </div>
                        <div>
                            <p><b>Email :</b>
                                <a href="mailto:<?php echo get_the_author_meta('user_email'); ?>">
                                    <?php echo get_the_author_meta('user_email', $userObject->ID); ?>
                                </a>
                            </p>
                            <?php the_field('ldap_field', 'user_'.$userObject->ID); ?>
                            <p><b>Téléphone :</b>
                                <a href="tel:<?php echo get_the_author_meta('user_phone'); ?>">
                                    <?php echo get_the_author_meta('user_phone', $userObject->ID); ?>
                                </a>
                            </p>
                            <p><b>Adresse professionnelle :</b><?php the_field('adresse_pro', 'user_'.$userObject->ID); ?></p>
                            <p><b>Site web personnel :</b>
                            <a href="<?php the_field('url_site_perso', 'user_'.$userObject->ID); ?>" target="_blank"><?php the_field('url_site_perso', 'user_'.$userObject->ID); ?></a></p>
                        </div>
                    </div>
                    <div>
                        <h2>À propos de l'auteur</h2>
                        <p>
                        <?php echo get_the_author_meta('user_description', $userObject->ID); ?>
                        </p>
                    </div>
                </div>
                <section class="author-content wrapper-content">
                    <div>
                        <h2>CV / Fonctions</h2>
                        <?php the_field('cv_fonctions', 'user_'.$userObject->ID);?>
                    </div>
                    <div>
                        <h2>Recherche</h2>
                        <?php the_field('travaux_de_recherche', 'user_'.$userObject->ID);?>
                    </div>
                    <div>
                        <h2>Responsabilités</h2>
                        <?php the_field('responsabilites', 'user_'.$userObject->ID);?>
                    </div>
                    <div>
                        <h2>Principales publications</h2>
                        <?php the_field('publis', 'user_'.$userObject->ID);?>
                    </div>
                    <div>
                        <h2>Projets</h2>
                        <?php the_field('projets', 'user_'.$userObject->ID);?>
                    </div>
                    <div>
                        <h2>Enseignement</h2>
                        <?php the_field('enseignement', 'user_'.$userObject->ID);?>
                    </div>
                    <div>
                        <h2>Réseaux Métiers</h2>
                        <?php the_field('rsx_metiers', 'user_'.$userObject->ID);?>
                    </div>
                </section>
                                
                <?php //endif; ?>
                
            </div>
		</main><!-- #main -->
        <aside id="stickyMenu" class="open">
            <div>
                <p>Sommaire</p>
                <nav role="sommaire">
                    <ol id="tocList">
                    </ol>
                </nav>
                <button class="bobinette">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 30 30" enable-background="new 0 0 30 30" xml:space="preserve">
                            <rect fill="none" width="30" height="30"/>
                            <polyline points="
                            10.71,2.41 23.29,15 10.71,27.59 	"/>
                    </svg>                
                </button>
            </div>
        </aside>
	</div><!-- #primary -->
<?php

get_footer();
