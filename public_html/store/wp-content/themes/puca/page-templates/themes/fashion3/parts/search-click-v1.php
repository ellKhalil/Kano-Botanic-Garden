<?php if ( puca_tbay_get_config('show_searchform') ): ?>
<?php 

$_id = puca_tbay_random_key(); 

?>
<div class="search-click">
  <button type="button" id="btn-search-click">
    <?php esc_html_e('Search', 'puca'); ?>
    <i class="tb-icon tb-icon-zz-search"></i>
  </button>

  <div class="search-form-click" id="searchformshow-<?php echo esc_attr($_id); ?>">
    <?php puca_tbay_get_page_templates_parts('productsearchform','full'); ?>
  </div>  
</div>

<?php endif; ?>