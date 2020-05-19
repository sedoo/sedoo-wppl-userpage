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
    $idequipe = $filtreequipe[0];
    $args = array(
        'meta_query' => array(
            array(
              'key' => 'research_team_tag',
              'value' => $idequipe,
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
                    if (get_field('photo_auteur', 'user_'.$user->ID)) {
                    $userImage=get_field('photo_auteur', 'user_'.$user->ID);
                    if( !empty($userImage) ){
                        $size='thumbnail';
                        $thumb= $userImage['sizes'][$size];
                    ?>
                    
                        <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo $image['alt']; ?>" />
                    
                    <?php
                        }                        
                    }else {
                        echo "<span class=\"userLetters\">".substr($user->last_name, 0, 1).substr($user->first_name, 0, 1)."</span>";
                    }
                    ?>  
                    </figure>    
                    <div>   
                        <?php 
                        // var_dump($user);
                        if ($user->last_name == "") {
                            $user_display_name=$user->display_name;
                        } else {
                            $user_display_name="".$user->last_name." ".$user->first_name."";
                        }
                        ?>
                        <h3>
                        <?php echo $user_display_name;?>
                        </h3>
                        <?php 
                        if (get_field('poste', 'user_'.$user->ID)) { 
                        ?>
                        <p class="sedoo_userpage_position">
                            <?php echo get_field('poste', 'user_'.$user->ID);?>
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
