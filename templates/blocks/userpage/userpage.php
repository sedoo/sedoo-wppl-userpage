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
        echo '<ul class="sedoo_userpage_ul sedoo_'.$affichage.'">';
        foreach ( $utilisateurs->get_results() as $user ) {
            echo '<li><a href="'.get_author_posts_url($user->ID).'"><span class="dashicons dashicons-admin-users"></span> <p>' . $user->first_name .' '.$user->last_name.' </p><span class="sedoo_userpage_span_post">'.get_field('poste', 'user_'.$user->ID).'</span></a></li>';
        }
        echo '</ul>';
    } else {
        echo 'Aucun utilisateur.';
    }
?>
