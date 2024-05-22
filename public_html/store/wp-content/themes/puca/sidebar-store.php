<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage puca
 * @since Puca 1.3.6
 */


$sidebar = puca_get_sidebar_dokan();

if(!isset($sidebar['id']) || empty($sidebar['id'])) return;

?> <div class="puca-sidebar-vendor sidebar"><?php dynamic_sidebar( $sidebar['id'] ); ?></div>


 

