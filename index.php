<?php
/*
Plugin Name: Gaia section about plugin
Plugin URI: https://github.com/amoungui/gaia-section-about-plugin
Description: This is the plugin to design the section about into the gaia website
Version: 0.1
Author: Serge Mbele Amoungui
Author URI: http://arrowrising.site
License: GPL2
*/

class Gaia_about_section {
    public function __construct(){
        //inclusion des fichiers du plugin
        include_once plugin_dir_path( __FILE__ ).'core/gaia-media.php';
        include_once plugin_dir_path( __FILE__ ).'core/taxonomy_gaia.php';
        //instanciation des class contenu dans les fichiers
        new Gaia_media();
        new Taxonomy_gaia();
    }
}

new Gaia_about_section();
