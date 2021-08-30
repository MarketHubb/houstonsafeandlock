<form role="search" id="searchform" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<label class="search-field-row" for="s">
    <input type="hidden" name="post_type" value="product" />
	<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'woocommerce' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'woocommerce' ); ?>" />

        <button id="searchsubmit" href="javascript:void(0)">
            <div id="searchIcon" class="search-icon"></div>
        </button>
    </label>
    <span class="search-label">Search</span>
</form>