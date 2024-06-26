<?php

// Create id attribute allowing for custom "anchor" value.
$id = 'sedoo_userpage-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'sedoo_blocks_userpage';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

$rechercheparequipe = get_field('filtrer_par_equipe');

if($rechercheparequipe == true) {
    // recherche par equipe
    $filtreequipe = get_field('equipe_de_recherche');
    $args = array(
        'meta_query' => array(
            array(
              'key' => 'research_team_tag',
              'value' => $filtreequipe[0],
              'compare' => 'LIKE'
                )
            ),
            'meta_key' => 'last_name',
            'orderby' => 'meta_value',
            'order' => 'ASC',
    );
} else {
    $args = array(
        'meta_key' => 'last_name',
        'orderby' => 'meta_value',
        'order' => 'ASC',
    );
}

// $affichage = get_field('affichage');  desactivé pour l'instant

 
$utilisateurs = new WP_User_Query( $args );
if ( ! empty( $utilisateurs->get_results() ) ) {
    ?>
    <section class="userpage-list users-cards <?php echo $className; ?>">
        <?php  
        $firstletter="";
        $count=count($utilisateurs->get_results());

        foreach ( $utilisateurs->get_results() as $user ) {
            if (!is_super_admin($user->ID)) {

                $user_last_name_firstLetter = strtoupper(substr($user->last_name, 0, 1));
            ?>
             <?php 
            // if ($count>4) {
                if (($firstletter == "") || (($firstletter !== "") && ( $firstletter!==$user_last_name_firstLetter) ) ){
                    $firstletter= $user_last_name_firstLetter;
                    echo "<div class=\"firstletterList\"><span>".$firstletter."</span></div>";
                } else {
                    $firstletter= $user_last_name_firstLetter;
                }
            // }
            ?>
            <article class="fl-<?php echo $user_last_name_firstLetter;?>">
           
                <a href="<?php echo get_author_posts_url($user->ID);?>">    
                     <figure> 
                        <?php 
                            $img_id = get_user_meta($user->ID, 'photo_auteur', true);
                            $primaryblogid = get_user_meta($user->ID, 'primary_blog', true);
                            if (($primaryblogid == 1)||($primaryblogid == "")) {
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
                                    <img src="<?php echo esc_url($url); ?>" alt="<?php echo get_user_meta( $user->ID,'first_name', true). ' '.get_user_meta( $userObject->ID,'last_name', true); ?>" />
                                <?php 
                            } else {
                                echo "<span class=\"userLetters\">".substr($user->last_name, 0, 1).substr($user->first_name, 0, 1)."</span>";
                            }
                    ?>
                    </figure>    
                    <div>   
                        <?php 
                        if ($user->last_name == "") {
                            $user_display_name=$user->display_name;
                        } else {
                            $user_display_name="".$user->last_name." ".$user->first_name."";
                        }
                        ?>
                        <p class="h3">
                        <?php echo $user_display_name;?>
                        </p>
                        <?php 
                        if (get_field('poste', 'user_'.$user->ID) || get_field('userpage_block_show_tutelle') == true) { 
                        ?>
                        <p class="sedoo_userpage_position">
                            <?php 
                            if (get_field('poste', 'user_'.$user->ID)) {
                                echo get_field('poste', 'user_'.$user->ID);
                            }
                            ?>
                            
                            <?php 
                            if(get_field('userpage_block_show_tutelle') == true) {
                                if (get_field('poste', 'user_'.$user->ID) && (get_field('tutelle', 'user_'.$user->ID) || get_field('grade', 'user_'.$user->ID)) ) { 
                                    ?>
                                    <br>
                                <?php
                                }
                                ?>

                                <?php       
                                if (get_field('tutelle', 'user_'.$user->ID) || get_field('grade', 'user_'.$user->ID) ) { 
                                ?>                                
                                    <em>
                                        <?php echo get_field('grade', 'user_'.$user->ID);?> <?php echo get_field('tutelle', 'user_'.$user->ID);?>
                                    </em>
                                <?php 
                                }
                            }
                            ?>
                        </p>
                        <?php 
                        }
                        ?>
                        
                        
                    </div>
                </a>
            </article>
        <?php 
            }
        }
        ?>
    </section>
    <?php
} else {
    echo 'No result.';
}
?>
