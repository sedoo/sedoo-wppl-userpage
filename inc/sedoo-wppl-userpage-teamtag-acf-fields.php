<?php
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_5e68c534be3c4',
        'title' => 'Laboratoire utilisateur',
        'fields' => array(
            array(
                'key' => 'field_5e68c53e2b46c',
                'label' => 'Equipe de recherche',
                'name' => 'research_team_tag',
                'type' => 'relationship',
                'instructions' => '<p style="background:#ff9800;color:#000;padding:5px;">Si le site propose plusieurs langues, sélectionnez toutes les traductions existantes de votre équipe</p>',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'sedoo-research-team',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'search',
                    1 => 'post_type',
                ),
                'elements' => '',
                'min' => '',
                'max' => '',
                'return_format' => 'object',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'user_form',
                    'operator' => '==',
                    'value' => 'all',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
    
    acf_add_local_field_group(array(
        'key' => 'group_5e6a46746f089',
        'title' => 'Bloc userpage teamtag',
        'fields' => array(
            array(
                'key' => 'field_5e6a469a6d532',
                'label' => 'Filtrer par équipe',
                'name' => 'filtrer_par_equipe',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 0,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_5e6a46b26d533',
                'label' => 'Equipe de recherche',
                'name' => 'equipe_de_recherche',
                'type' => 'relationship',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_5e6a469a6d532',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'sedoo-research-team',
                ),
                'taxonomy' => '',
                'filters' => array(
                    0 => 'search',
                    1 => 'post_type',
                ),
                'elements' => '',
                'min' => '1',
                'max' => '1',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_619503f5cb8da',
                'label' => 'Afficher Grade / tutelle',
                'name' => 'userpage_block_show_tutelle',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/sedoo-userpage',
                ),
            ),
        ),
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));
    
    endif;
    ?>