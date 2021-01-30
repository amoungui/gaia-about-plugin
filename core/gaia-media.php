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
        /**
         * hook d'initialization de meta boxes pour les custom post type de gaia_media 
         */
        add_action('add_meta_boxes', array($this, 'gaia_media_register_meta_box'));  
        /**
         * hook pour enregistrer la meta-box  quand le post est enregistrer
         */
        add_action('save_post', array($this, 'gaia_media_save_meta_box'));   
        add_filter('manage_edit-gaia_media_columns', array($this, 'gaia_col_change2'));  
        add_action('manage_gaia_media_posts_custom_column', array($this, 'gaia_content_show2'), 10, 2);                        
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

    /**
     * @function gaia_media_register_meta_box
     * @execute add_meta_box (
     *              $id: nom_de_la_meta_box, 
     *              $title: titre associer à la meta box, 
     *              $callback: nom de la function qui servira a construire la section,
     *              $context: on designe le type de contenu auquel s'applique la meta box: gaia-media en occurance,
     *              $priority: priorité,
     *              $position: position
     * ) 
     * @description
     */
    function gaia_media_register_meta_box() {
        add_meta_box('gaia_media_meta', 'Références de section', array($this, 'gaia_media_meta_building'), 'gaia_media', 'normal', 'high');
    }

    /**
     * @function gaia_media_meta_building
     * @param $post qui contiendra tous les meta données et CPT
     * @description permet de remplir le contenu de nos metas boxes
     */
    function gaia_media_meta_building($post) {
        
        $gaia_meta_an = get_post_meta($post->ID, '_media_meta_an', true);
        
        $gaia_meta_editeur = get_post_meta($post->ID, '_media_meta_editeur', true);

        wp_nonce_field('gaia_media_meta_box_saving', 'gaia_2021');

        $gaia_orgs = array(
            'Préseident(e)',
            'Vice-président(e)',
            'Secrétaire Général(e)',
            'Trésorier(e)',
            'responsable RH',
            'responsable Qualité',
            'responsable SI',
            'responsable Commercial',
            'responsable Communication',
            'responsable Suivi d\'etudes',
            'Chargé(e) de mission RSE',
            'Chargé(e) Ressources Humaines',
            'Chargé(e) de Trésorerie',
            'Chargé(e) de Systèmes d\'informatiques',
            'Commercial',
            'Chargé(e) Qualité',
            'Expert IA',
            'Graphiste',
            'Happiness Manager'
        );
        echo '<div>';
        echo '<p><label for="media_detail_an">Organisation</label>';
        echo '<select id="media_detail_an" name="media_detail_an">';
            foreach($gaia_orgs as $gaia_org):
                echo '<option value="'.$gaia_org.'"'.selected($gaia_meta_an, $gaia_org, false).'>'.$gaia_org.'</option>';
            endforeach;
        echo '</select></p>';

        echo '<p><label for="media_detail_editeur">Grande école</label>';
        echo '<input type="text" size="30" value="'.$gaia_meta_editeur.'" id="media_detail_editeur" name="media_detail_editeur"/><p>';

        echo '</div>';
    }    

    /**
     * @function gaia_media_save_meta_box
     * @param $post_id
     * @description sauvegarde meta boxes pour custom post type gaia_media
     */
    function gaia_media_save_meta_box($post_id) {
        if ( get_post_type($post_id) == 'gaia_media' && isset( $_POST['media_detail_an']) ){
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {return;}
            check_admin_referer('gaia_media_meta_box_saving', 'gaia_2021');
            update_post_meta($post_id, '_media_meta_an', sanitize_text_field($_POST['media_detail_an']));
            update_post_meta($post_id, '_media_meta_editeur', sanitize_text_field($_POST['media_detail_editeur']));        
        }
    }    

    //===============================================================================
    //===========  ajout de l'image et année dans la colonne admin pour le gaia_media 
    //===============================================================================

    function gaia_col_change2($columns) {
        $columns['gaia_media_org'] = "organisation";
        $columns['gaia_media_editeur'] = "école";
        $columns['gaia_media_image'] = "image affichée";

        return $columns;
    }

    function gaia_content_show2($column, $post_id) {
        global $post;
        if( $column == 'gaia_media_image' ){
            echo the_post_thumbnail(array(120, 120));
        }

        if( $column == 'gaia_media_editeur' ){
            $gaia_meta_editeur = get_post_meta($post_id, '_media_meta_editeur', true);
            echo $gaia_meta_editeur;
        }    

        if( $column == 'gaia_media_org' ){
            $gaia_meta_org = get_post_meta($post_id, '_media_meta_an', true);
            echo $gaia_meta_org;
        }
    }    
}