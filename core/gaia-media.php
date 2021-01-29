<?php

/**
 * 
 */
class Gaia_media {
    public function __construct()
    {
        /**
         * Hook d'initialisation du custome post type   
         */ 
        add_action('init', array($this, 'gaia_media_init'));  
    }

    /**
     * @function gaia_media_init
     * @description Action d'initialisation du custome post type pour l'enregistrement des membres et leurs poste  
     */     
    public function gaia_media_init(){ 
        $label = array(
            'name' => 'Gaia about page',
            'singular_name' => 'Pôle',
            'add_new' => 'Ajouter un élément',
            'add_new_item' => 'Ajouter un élément à la page',
            'edit_item' => 'Editer un élément à la page',
            'new_item' => 'Nouvelle section',
            'all_items' => 'Voir la liste',
            'view_item' => 'Voir l\'élément',
            'search_items' => 'Rechercher un élément',
            'not_found' => 'aucune élément trouvé',
            'not_found_in_trash' => 'aucune élément trouvé dans la corbeille',
            'parent_item_colon' => '',
            'menu_name' => 'Gaia about page'
        );
        //série d'argument que prendra la function register_post_type
        $args = array(
            'labels' => $label,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'publicly_queryable' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'a-propos'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 20,
            //'menu_icon' => get_stylesheet_directory_uri().'/assets/disc_16.png',
            'exclude_form_search' => false,
            //'register_meta_box_cb' => 'gaia_media_register_meta_box',
            //'taxonomies' => array('post_tag', 'category'),
            'supports' => array('title', 'editor', 'page-attributes' ,'thumbnail'),
        );

        register_post_type('gaia_media', $args); // on enregistre ici un type de post que l'on appelera gaia_media
    }
}