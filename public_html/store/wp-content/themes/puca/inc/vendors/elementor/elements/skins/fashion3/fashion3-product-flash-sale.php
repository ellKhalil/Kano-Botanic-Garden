<?php

if (! defined('ABSPATH') || function_exists('Puca_Elementor_Product_Flash_Sales')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;

class Puca_Elementor_Product_Flash_Sales extends Puca_Elementor_Carousel_Base
{
    public function get_name()
    {
        return 'tbay-fashion3-product-flash-sale';
    }

    public function get_title()
    {
        return esc_html__('Puca Product Flash Sales', 'puca');
    }

    public function get_categories()
    {
        return [ 'puca-elements', 'woocommerce-elements'];
    }

    public function get_icon()
    {
        return 'eicon-flash';
    }

    /**
     * Retrieve the list of scripts the image carousel widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @since 1.3.0
     * @access public
     *
     * @return array Widget scripts dependencies.
     */
    public function get_script_depends()
    {
        return ['slick', 'puca-custom-slick', 'jquery-countdowntimer'];
    }

    public function get_keywords()
    {
        return [ 'woocommerce-elements', 'product', 'products', 'Flash Sales', 'Flash' ];
    }

    protected function register_controls()
    {
        $this->register_controls_heading();

        $this->start_controls_section(
            'general',
            [
                'label' => esc_html__('General', 'puca'),
            ]
        );
        

        $this->register_control_main();
        
        $this->end_controls_section();
        
        $this->register_style_heading();
        $this->register_control_viewall();

        $this->add_control_responsive();

        $this->add_control_carousel(['layout_type' => 'carousel']);
    }

    

    private function register_control_main()
    {
        $prefix = 'main_';
        $this->add_control(
            $prefix .'advanced',
            [
                'label' => esc_html__('Main', 'puca'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'date_title',
            [
                'label' => esc_html__('Title Date', 'puca'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Ends in: ', 'puca'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'date_title_ended',
            [
                'label' => esc_html__('Title deal ended', 'puca'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Deal ended.', 'puca'),
                'label_block' => true,
            ]
        );


        $this->add_control(
            'end_date',
            [
                'label' => esc_html__('End Date', 'puca'),
                'type' => Controls_Manager::DATE_TIME,
                'label_block' => true,
                'placeholder' => esc_html__('Choose the end time', 'puca'),
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label'     => esc_html__('Layout Type', 'puca'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => [
                    'grid'      => esc_html__('Grid', 'puca'),
                    'carousel'  => esc_html__('Carousel', 'puca'),
                ],
            ]
        );
  
        $products = $this->get_available_on_sale_products();
        
        if (!empty($products)) {
            $repeater = $this->register_products_sale_repeater();
            $this->add_control(
                $prefix .'product_sale',
                [
                    'label' => esc_html__('Select products', 'puca'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'trending_field' => '{{{ product_sale_item }}}',
                    
                ]
            );
        } else {
            $this->add_control(
                $prefix .'html_products',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('You do not have any discount products. <br>Go to the <strong><a href="%s" target="_blank">Products screen</a></strong> to create one.', 'puca'), admin_url('edit.php?post_type=product')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                    
                ]
            );
        }

        $this->add_control(
            'enable_readmore',
            [
                'label' => esc_html__('Enable Button "Read More" ', 'puca'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
    }
    private function register_products_sale_repeater()
    {
        $repeater = new \Elementor\Repeater();

        $products = $this->get_available_on_sale_products();
        $repeater->add_control(
            'product_sale_item',
            [
                'label' => esc_html__('Product', 'puca'),
                'type'         => Controls_Manager::SELECT,
                'options'      => $products,
                'default'      => array_keys($products)[0],
                'multiple' => true,
                'label_block' => true,
                'save_default' => true,
                'description' => esc_html('Only search for sale products', 'puca'),
            ]
        );
 

        return $repeater;
    }

   
    private function register_style_heading()
    {
        $this->start_controls_section(
            'section_style_heading_fl',
            [
                'label' => esc_html__('Style Heading Flash Sale', 'puca'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_fl_bg',
            [
                'label'     => esc_html__('Color', 'puca'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .top-flash-sale-wrapper' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_fl_padding',
            [
                'label'      => esc_html__('Padding', 'puca'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '12',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .top-flash-sale-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'heading_fl_margin',
            [
                'label'      => esc_html__('Margin', 'puca'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '22',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .top-flash-sale-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_heading_categories_tab',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .top-flash-sale-wrapper',
                'separator'   => 'before',
            ]
        );
 

        $this->end_controls_section();
    }

    protected function register_control_viewall()
    {
        $this->start_controls_section(
            'section_readmore',
            [
                'label' => esc_html__('Read More Options', 'puca'),
                'type'  => Controls_Manager::SECTION,
                'condition' => [
                    'enable_readmore' => 'yes'
                ],
            ]
        );

        $this->add_control(
            'readmore_text',
            [
                'label' => esc_html__('Button "Read More" Custom Text', 'puca'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Read More', 'puca'),
                'label_block' => true,
            ]
        );

        $pages = $this->get_available_pages();

        if (!empty($pages)) {
            $this->add_control(
                'readmore_page',
                [
                    'label'        => esc_html__('Page', 'puca'),
                    'type'         => Controls_Manager::SELECT2,
                    'options'      => $pages,
                    'default'      => array_keys($pages)[0],
                    'label_block' => true,
                    'save_default' => true,
                    'separator'    => 'after',
                ]
            );
        } else {
            $this->add_control(
                'readmore_page',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf(__('<strong>There are no pages in your site.</strong><br>Go to the <a href="%s" target="_blank">pages screen</a> to create one.', 'puca'), admin_url('edit.php?post_type=page')),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                ]
            );
        }
        $this->end_controls_section();
    }


    protected function render_btn_readmore()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        if (!empty($readmore_page)) {
            $link = get_permalink($readmore_page);
        }

        if ($enable_readmore && !empty($link)) : ?>
            <a class="show-all" href="<?php echo esc_url($link); ?>" title="<?php esc_attr($readmore_text); ?>"><?php echo trim($readmore_text); ?></a>
        <?php endif;
    }

   

    public function render_content_main()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $ids = $this->get_id_products_flash_sale($main_product_sale);


        if (count($ids) === 0) {
            echo '<div class="not-product-flash-sales">'. esc_html__('Please select the show product', 'puca')  .'</div>';
            return;
        }
        
        $args = array(
            'post_type'            => 'product',
            'ignore_sticky_posts'  => 1,
            'no_found_rows'        => 1,
            'posts_per_page'       => -1,
            'orderby'              => 'post__in',
            'post__in'             => $ids,
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

        $loop = new WP_Query($args);

        $end_date     = strtotime($end_date);
        if (!$loop->have_posts()) {
            return;
        }

        
        $this->add_render_attribute('row', 'class', ['products']);

        $attr_row = $this->get_render_attribute_string('row');

        wc_get_template( 'layout-products/themes/fashion3/layout-products.php' , array( 'loop' => $loop, 'flash_sales' => true, 'end_date' => $end_date,'attr_row' => $attr_row, 'rows' => $rows) );
        
        $this->render_btn_readmore();
    }
    public function deal_end_class() 
    {
        $settings = $this->get_settings_for_display();
        extract($settings);


        $class_deal_ended   = '';
        $end_date           = strtotime($end_date);
        $today              = strtotime("today");
        if (!empty($end_date) &&  ($today > $end_date)) {
            $class_deal_ended = 'deal-ended';
        }

        return $class_deal_ended;
    }

    protected function get_id_products_flash_sale($main_product_sale)
    {
        $product_ids = array();

        if( sizeof($main_product_sale) === 0 ) return $product_ids;

        foreach ($main_product_sale as $item) :

            extract($item);
        array_push($product_ids, $product_sale_item);

        endforeach;

        return $product_ids;
    }
}
$widgets_manager->register(new Puca_Elementor_Product_Flash_Sales());
