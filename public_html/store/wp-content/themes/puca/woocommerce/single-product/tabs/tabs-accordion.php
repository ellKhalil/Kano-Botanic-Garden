<?php
$_id = time() . rand();
$columns = 1;

if (!defined( 'ABSPATH' )) {
    exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if (!empty( $tabs )) : $selectIds = '#collapse-tab-0'; ?>

    <div class="wc-tabs-wrapper" id="woocommerce-tabs" data-ride="carousel">
        <div class="panel-group accordion-group" id="accordion" role="tablist" aria-multiselectable="true">
            <?php $i = 0;
            foreach ($tabs as $key => $tab): $in = ( $i == 0 ) ? 'in' : '';
                $arrow = ( $i == 0 ) ? 'up' : 'down';
                $i++; ?>
                <div class="panel">
                    <div class="tabs-title <?php echo esc_attr( $key ); ?>_tab" role="tab" id="heading-<?php echo esc_attr( $i ); ?>">
                        <a role="button" class="collapsed" data-toggle="collapse" data-parent="#accordion"
                           href="#collapse-tab-<?php echo esc_attr( $i ); ?>" aria-expanded="true"
                           aria-controls="collapse-tab-<?php echo esc_attr( $i ); ?>">
                            <?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?>
                            <i class="fa fa-angle-<?php echo esc_attr( $arrow ); ?> radius-x"></i> </a>
                    </div>
                    <div id="collapse-tab-<?php echo esc_attr( $i ); ?>"
                         class="panel-collapse collapse <?php echo esc_attr( $in ); ?>" role="tabpanel"
                         aria-labelledby="heading-<?php echo esc_attr( $i ); ?>">
                        <div class="entry-content"><?php call_user_func( $tab['callback'], $key, $tab ); ?></div>
                    </div>
                </div>
                <?php $selectIds .= ',#collapse-tab-' . $i; endforeach ?>
        </div>

        <?php do_action( 'woocommerce_product_after_tabs' ); ?>
    </div>

    <script type="text/javascript">
        jQuery(function ($) {
            var selectIds = $('<?php echo trim( $selectIds ); ?>');
            selectIds.on('show.bs.collapse hidden.bs.collapse', function (e) {
                $(this).prev().find('.fa').toggleClass('fa-angle-down fa-angle-up');
            })
        });
    </script>


<?php endif; ?>
