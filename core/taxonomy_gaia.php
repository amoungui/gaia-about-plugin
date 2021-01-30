<?php

class Taxonomy_gaia {
    public function __construct() {
        //--------------- Action hook to create taxonomy
        add_action('init', array($this, 'gaia_define_taxononomy_about')); 
        add_action('pre_get_posts', array($this, 'gaia_media_in_main_query'));                  
    }   
    
    //===============================================================================
    //===========  custom taxonomy pour gaia_media 
    //===============================================================================
    function gaia_define_taxononomy_about() {
        $label = array(
            'name' => 'Catégorie au sein de l\'organisation',
            'singular_name' => 'Catégorie',
            'all_items' => 'tous les catégories',
            'edit_item' => 'Editer un catégorie',
            'update_item' => 'mettre à jour un catégorie',
            'add_new_item' => 'Ajouter un catégorie',
            'search_items' => 'Rechercher un catégorie',
            'new_item_name' => 'Nouveau nom du catégorie',
            'menu_name' => 'type de catégorie'
        );

        $args = array(
            'labels' => $label,
            'public' => true,
            'publicly_queryable' => true,
            'hierarchical' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'poste'),
            'show_admin_column' => true,
            //'show_in_nav_menu' => true
        );
        register_taxonomy('genre_mus', 'gaia_media', $args);
    }

    //===============================================================================
    //===========  ajouter gaia_media à la requete par défaut pour taxonomy.php 
    //===============================================================================
    function gaia_media_in_main_query($query){
        if(is_tax('genre_mus')){
            $query->set('post_type', array('post', 'page', 'nav_menu_item', 'gaia_media'));
        }
    }

}