<?php
function ajax_post_loader_load_more()
{
    check_ajax_referer('ajax_post_loader_nonce', 'security');

    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 10,
        'paged' => $paged,
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
?>
            <div class="ajax-post">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php the_excerpt(); ?>
            </div>
<?php
        }
        wp_reset_postdata();
        wp_die();
    } else {
        wp_die('no_more_posts');
    }
}
add_action('wp_ajax_nopriv_ajax_post_loader_load_more', 'ajax_post_loader_load_more');
add_action('wp_ajax_ajax_post_loader_load_more', 'ajax_post_loader_load_more');
