# gaia-about-plugin
## This is the Gaia about section plugin to customize a about page into Gaia WebSite

[![Issues](https://img.shields.io/github/issues/amoungui/contact-form?style=flat-square)](https://github.com/amoungui/gaia-about-plugin/issues)

[![Stars](https://img.shields.io/github/stars/amoungui/contact-form?style=flat-square)](https://github.com/amoungui/gaia-about-plugin/stargazers)

### Deploy ###
 
Create at the root of the theme you want to use, an archive-gaia_media.php file and a single-gaia_media.php file by copying the index.php file. And at the end, create a global-taxonomy-tpl.php file with the following content
```
<?php
/**
 * Template Name: liste par taxonomie
 */
get_header(); ?>
<div id="about-taxonomy">
    <section id="pagetitle" class="pagetitle dark" >
        <div class="container">
            <h1 class="pagetitle-title heading">A propos</h1>
            <div id="breadcrumb" class="breadcrumb">
                <a class="breadcrumb-link" href="https://www.demos-test.gaia-junior.com/">Home</a>
                <span class='breadcrumb-separator'></span><span class='breadcrumb-title'>A propos</span>
            </div>	
        </div>
    </section>
    <div id="contact" class="contact">
    <div class="container">
        <h1>Notre Equipe</h1>
    </div>
    <?php 
        $gaia_term_list = get_terms(array('taxonomy' => 'genre_mus', 'hide_empty' => true, ));
        if ($gaia_term_list > 0):
            foreach ($gaia_term_list as $the_term): ?>
            <section>
                <?php  
                    $arg_taxo_rupt = array(
                        'post_type' => 'gaia_media',
                        'posts_per_page' => -1,

                        'tax_query' => array(
                            array(
                                'taxonomy' => 'genre_mus',
                                'field' => 'slug',
                                'terms' => $the_term->slug
                            )
                        )
                    );
                    $req_taxo_rupt = new WP_Query($arg_taxo_rupt);

                    if($req_taxo_rupt->have_posts()): ?>
                        <div class="container">
                            <div style="width: 23%; background-color: #5c5b5b; color: #fff!important;margin-left: 3%; margin-bottom: -30px; border-radius: 3%;padding-left: 1%;">
                                <h3><?php echo $the_term->name ?></h3>
                            </div>
                            <div style="display: flex; justify-content: space-around; margin-bottom: 5%; border: 1px solid #5c5b5b; border-radius: 10px;">
                                <?php while ($req_taxo_rupt->have_posts()): ?>
                                    <?php $req_taxo_rupt->the_post(); ?>
                                    <article style="margin-top: 2%;">
                                        <div class="panel panel-default">
                                        <?php the_post_thumbnail('medium-large', array('style' => '-webkit-border-radius: 40%; -moz-border-radius: 40%; -ms-border-radius: 40%; -o-border-radius: 40%; border-radius: 40%;')) ?>
                                            <div class="panel-footer">
                                                <h4 class="h4 text-center"><?php the_title() ?></h4>
                                            </div>
                                        </div> 
                                    </article>
                                <?php endwhile; wp_reset_postdata(); ?>
                            </div>
                        </div>  
                    <?php endif; ?>         
            </section>
        <?php 
            endforeach;
        endif;
    ?>
    </div>
</div>

<?php get_footer(); ?>
```
