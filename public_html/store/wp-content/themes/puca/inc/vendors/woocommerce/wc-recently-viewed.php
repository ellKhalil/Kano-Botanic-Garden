<?php

if ( !puca_is_woocommerce_activated() ) return;


if (! function_exists('puca_tbay_recently_viewed_set_cookie_meta')) {
    function puca_tbay_recently_viewed_set_cookie_meta($products_list)
    {
        $user_id            = get_current_user_id();
        $meta_products_list = 'puca_recently_viewed_product_list';
        $cookie_name        = 'puca_recently_viewed_products_list';

        $duration = 5;
        $duration = time() + (86400 * $duration);

        // if user also exists add meta with products list
        if ($user_id) {
            update_user_meta($user_id, $meta_products_list, $products_list);
        } else {
            // set cookie
            setcookie($cookie_name, serialize($products_list), $duration, COOKIEPATH, COOKIE_DOMAIN, false, true);
        }
    }
}

if (! function_exists('puca_tbay_wc_track_user_get_cookie')) {
    function puca_tbay_wc_track_user_get_cookie()
    {
        $user_id            = get_current_user_id();
        $cookie_name        = 'puca_recently_viewed_products_list';
        $meta_products_list = 'puca_recently_viewed_product_list';

        if (! $user_id) {
            $products_list = isset($_COOKIE[$cookie_name]) ? unserialize($_COOKIE[ $cookie_name ]) : array();
        } else {
            $meta = get_user_meta($user_id, $meta_products_list, true);
            $products_list = ! empty($meta) ? $meta : array();
        }

        return $products_list;
    }
}

if (! function_exists('puca_tbay_wc_track_user_viewed_produts')) {
    function puca_tbay_wc_track_user_viewed_produts()
    {
        global $post;

        $products_list      = puca_tbay_wc_track_user_get_cookie();

        if (is_null($post) || $post->post_type != 'product' || ! is_product()) {
            return;
        }


        $product_id = intval($post->ID);

        // if product is in list, remove it
        if (($key = array_search($product_id, $products_list)) !== false) {
            unset($products_list[$key]);
        }

        $timestamp = time();
        $products_list[$timestamp] = $product_id;

        // set cookie and save meta
        puca_tbay_recently_viewed_set_cookie_meta($products_list);
    }
    add_action('template_redirect', 'puca_tbay_wc_track_user_viewed_produts', 99);
    // add_action( 'woocommerce_before_single_product', 'puca_tbay_wc_track_user_viewed_produts', 99 );
}

if (! function_exists('puca_tbay_get_products_recently_viewed')) {
    function puca_tbay_get_products_recently_viewed($num_post = 8)
    {
        $products_list      = puca_tbay_wc_track_user_get_cookie();

        if (empty($products_list)) {
            return '';
        }

        $products_list_value    = array_values($products_list);

        $args = array(
            'post_type'            => 'product',
            'ignore_sticky_posts'  => 1,
            'no_found_rows'        => 1,
            'posts_per_page'       => $num_post,
            'orderby'              => 'post__in',
            'post__in'             => array_reverse($products_list_value)
        );


        if (version_compare(WC()->version, '2.7.0', '<')) {
            $args[ 'meta_query' ]   = isset($args[ 'meta_query' ]) ? $args[ 'meta_query' ] : array();
            $args[ 'meta_query' ][] = WC()->query->visibility_meta_query();
        } elseif (taxonomy_exists('product_visibility')) {
            $product_visibility_term_ids = wc_get_product_visibility_term_ids();
            $args[ 'tax_query' ]         = isset($args[ 'tax_query' ]) ? $args[ 'tax_query' ] : array();
            $args[ 'tax_query' ][]       = array(
                'taxonomy' => 'product_visibility',
                'field'    => 'term_taxonomy_id',
                'terms'    => is_search() ? $product_visibility_term_ids[ 'exclude-from-search' ] : $product_visibility_term_ids[ 'exclude-from-catalog' ],
                'operator' => 'NOT IN',
            );
        }

        return $args;
    }
}

/*The list product recently viewed*/
if (! function_exists('puca_tbay_wc_get_recently_viewed')) {
    function puca_tbay_wc_get_recently_viewed()
    {
        $num_post           =   puca_tbay_get_config('max_products_recentview', 6);
            
        $args = puca_tbay_get_products_recently_viewed($num_post);
        $args = apply_filters('puca_list_recently_viewed_products_args', $args);


        $products = new WP_Query($args);

        ob_start(); ?>
                <?php while ($products->have_posts()) : $products->the_post(); ?>

                    <?php wc_get_template_part('content', 'recent-viewed'); ?>

                <?php endwhile; // end of the loop.?>

            <?php

            $content = ob_get_clean();

        wp_reset_postdata();

        return $content;
    }
}