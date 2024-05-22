<?php

if( !class_exists('NextendSocialLogin') ) return;

add_action('woocommerce_login_form_end', 'NextendSocialLogin::addLoginFormButtons');
add_action('woocommerce_register_form_end', 'NextendSocialLogin::addLoginFormButtons');