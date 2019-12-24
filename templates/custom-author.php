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

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
            <div class="wrapper-layout">
                <?php //if (have_posts()): the_post(); ?>
                <div class="author-header">
                    <h1> 
                        <?php
                            echo get_the_author_meta('user_firstname', get_the_author_meta('ID'));
                        ?> 
                        <?php
                            echo get_the_author_meta('user_lastname');    
                        ?>
                    </h1>
                    <p class="h2"><?php //the_field('poste', 'user_'.get_the_author_meta('ID'));?>
                        Chercheur IRAP<br>
                        <small>Galaxies, Astrophysique des Hautes Energies et Cosmologie</small>
                    </p>
                    
                </div>
                <div class="author-card">
                    <div>
                        <div class="img-author">
                            <img src="<?php echo get_template_directory_uri() . '/image/john-doe.jpg'; ?>"/>
                        </div>
                        <div>
                            <p><b>Email :</b>
                                <a href="mailto:<?php echo get_the_author_meta('user_email'); ?>">
                                    <?php echo get_the_author_meta('user_email'); ?>
                                </a>
                            </p>
                            <p><b>Téléphone :</b>
                                <a href="tel:<?php echo get_the_author_meta('user_phone'); ?>">
                                    <?php echo get_the_author_meta('user_phone'); ?>
                                </a>
                            </p>
                            <p><b>Bureau :</b>308</p>
                            <p><b>Insitution :</b>OMP</p>
                            <p><b>Adresse professionnelle :</b>14 avenue Édouard Belin, 31400 Toulouse</p>
                            <p><b>Site web personnel :</b><a href="<?php echo get_the_author_meta('user_url'); ?>" target="_blank"><?php echo get_the_author_meta('user_url'); ?></a></p>
                        </div>
                    </div>
                    <div>
                        <h2>À propos de l'auteur</h2>
                        <p><?php //echo get_the_author_meta('user_description'); ?>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. In scelerisque turpis et arcu fermentum, eu scelerisque odio accumsan. Mauris neque sem, pulvinar nec felis ultricies, varius sagittis neque. Ut molestie neque id dui tincidunt venenatis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus vitae sollicitudin dui. Phasellus ac tempus dui. Morbi iaculis nulla ac nisl scelerisque euismod. Quisque nec massa id arcu finibus scelerisque ac quis mauris. Pellentesque imperdiet tincidunt lacus, ac porttitor nibh pulvinar semper. Sed aliquam auctor augue, vel fermentum nulla varius quis. Sed fermentum nunc a quam pulvinar imperdiet. Etiam luctus pretium convallis. Praesent sed congue orci. Proin fermentum sem id nunc dignissim mollis. Sed viverra lacus vel felis placerat ornare. Cras tincidunt non sem eget vehicula. 
                        </p>
                    </div>
                </div>
                <section class="author-content wrapper-content">
                    <div>
                        <h2>CV / Fonctions</h2>
                       
                    </div>
                    <div>
                        <h2>Recherche</h2>
                        
                    </div>
                    <div>
                        <h2>Responsabilités</h2>
                        
                    </div>
                    <div>
                        <h2>Principales publications</h2>
                        
                    </div>
                    <div>
                        <h2>Projets</h2>
                    </div>
                    <div>
                        <h2>Enseignement</h2>
                    </div>
                    <div>
                        <h2>Réseaux Métiers</h2>
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
