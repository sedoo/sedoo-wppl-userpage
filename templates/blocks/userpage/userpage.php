<?php

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
          'order' => 'ASC',
          'orderby' => 'display_name',
    );
} else {
    $args = array(
        'order' => 'ASC',
        'orderby' => 'display_name'
    );
}

$affichage = get_field('affichage');

 
$utilisateurs = new WP_User_Query( $args );
if ( ! empty( $utilisateurs->get_results() ) ) {
    if($affichage != 'foldable') {
        echo '<ul class="sedoo_userpage_ul sedoo_'.$affichage.'">';
        foreach ( $utilisateurs->get_results() as $user ) {
            echo '<li><a href="'.get_author_posts_url($user->ID).'"><span class="dashicons dashicons-admin-users"></span> <p class="sedoo_userpage_p_name">' . $user->first_name .' '.$user->last_name.' </p><span class="sedoo_userpage_span_post">'.get_field('poste', 'user_'.$user->ID).'</span><span>'.get_field('grade', 'user_'.$user->ID).' / '.get_field('tutelle', 'user_'.$user->ID).'</span></a></li>';
        }
        echo '</ul>';
    } else {  
        echo '<nav class="sedoo_userpage_ul users-tabs" role="tablist">';   
        foreach ( $utilisateurs->get_results() as $user ) {
        ?>
        <section id="<?php echo $user->ID;?>_section">
            <input type="radio" name="tabs" id="<?php echo $user->ID;?>" />
            <label for="<?php echo $user->ID;?>" id="<?php echo $user->ID;?>Tab" role="tab" aria-controls="<?php echo $user->ID;?>panel">
                <span class="dashicons dashicons-arrow-right-alt2"></span><?php echo $user->first_name .' '.$user->last_name;?> -  <span class="sedoo_userpage_span_tut"> <?php echo get_field('tutelle', 'user_'.$user->ID); ?></span>
            </label>
            <article id="<?php echo $user->ID;?>panel" role="tabpanel" aria-labelledby="<?php echo $user->ID;?>Tab">
                <span class="sedoo_userpage_span_post"><?php echo get_field('poste', 'user_'.$user->ID). ' - ' .get_field('grade', 'user_'.$user->ID); ?></span><br />
               <?php echo get_user_meta($user->ID, 'description', true); ?>
            </article>
        </section>
        <?php 
        }
        echo '</nav>';
    }

} else {
    echo 'Aucun utilisateur.';
}
?>
