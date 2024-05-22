<?php
/**
 * Product quantity inputs.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 *
 * @version 7.4.0
 */
defined('ABSPATH') || exit;

$active_theme = puca_tbay_get_theme();

wc_get_template('global/themes/'.$active_theme.'/quantity-input.php', ['min_value' => $min_value, 'max_value' => $max_value, 'step' => $step, 'input_name' => $input_name, 'input_value' => $input_value, 'input_id' => $input_id, 'placeholder' => $placeholder, 'inputmode' => $inputmode, 'classes' => $classes, 'readonly' => $readonly, 'type' => $type]);
