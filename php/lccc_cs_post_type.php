<?php

// Register Custom Post Type
function custom_crime_log() {

	$labels = array(
		'name'                  => _x( 'Crime Logs', 'Post Type General Name', 'crime_log' ),
		'singular_name'         => _x( 'Crime Log', 'Post Type Singular Name', 'crime_log' ),
		'menu_name'             => __( 'Crime Logs', 'crime_log' ),
		'name_admin_bar'        => __( 'Crime Log', 'crime_log' ),
		'archives'              => __( 'Crime Log Archives', 'crime_log' ),
		'parent_item_colon'     => __( 'Parent Item:', 'crime_log' ),
		'all_items'             => __( 'All Crime Logs', 'crime_log' ),
		'add_new_item'          => __( 'Add New Log', 'crime_log' ),
		'add_new'               => __( 'Add New Crime Log', 'crime_log' ),
		'new_item'              => __( 'New Item Crime Log', 'crime_log' ),
		'edit_item'             => __( 'Edit Crime Log', 'crime_log' ),
		'update_item'           => __( 'Update Crime Log', 'crime_log' ),
		'view_item'             => __( 'View Crime Log', 'crime_log' ),
		'search_items'          => __( 'Search Crime Logs', 'crime_log' ),
		'not_found'             => __( 'Not found', 'crime_log' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'crime_log' ),
		'featured_image'        => __( 'Featured Image', 'crime_log' ),
		'set_featured_image'    => __( 'Set featured image', 'crime_log' ),
		'remove_featured_image' => __( 'Remove featured image', 'crime_log' ),
		'use_featured_image'    => __( 'Use as featured image', 'crime_log' ),
		'insert_into_item'      => __( 'Insert into Crime Log', 'crime_log' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Crime Log', 'crime_log' ),
		'items_list'            => __( 'Crime Logs list', 'crime_log' ),
		'items_list_navigation' => __( 'Crime Logs navigation', 'crime_log' ),
		'filter_items_list'     => __( 'Filter items list', 'crime_log' ),
	);
	$args = array(
		'label'                 => __( 'Crime Log', 'crime_log' ),
		'description'           => __( 'This Crime Log post type are for reported crimes on the LCCC Elyria campus.', 'crime_log' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', ),
		'taxonomies'            => array( 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-shield',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'crime_log', $args );

}
add_action( 'init', 'custom_crime_log', 0 );

function lccc_cl_register_taxonomies() {
	$taxonomies = array(
		array(
			'slug'         => 'report_year',
			'single_name'  => 'Report Year',
			'plural_name'  => 'Report Years',
			'post_type'    => 'crime_log',
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'report-year' ),
		),
				array(
			'slug'         => 'report_month',
			'single_name'  => 'Report Month',
			'plural_name'  => 'Report Months',
			'post_type'    => 'crime_log',
			'hierarchical' => true,
			'rewrite'      => array( 'slug' => 'report-month' ),
		)
	);
		foreach( $taxonomies as $taxonomy ) {
		$labels = array(
			'name' => $taxonomy['plural_name'],
			'singular_name' => $taxonomy['single_name'],
			'search_items' =>  'Search ' . $taxonomy['plural_name'],
			'all_items' => 'All ' . $taxonomy['plural_name'],
			'parent_item' => 'Parent ' . $taxonomy['single_name'],
			'parent_item_colon' => 'Parent ' . $taxonomy['single_name'] . ':',
			'edit_item' => 'Edit ' . $taxonomy['single_name'],
			'update_item' => 'Update ' . $taxonomy['single_name'],
			'add_new_item' => 'Add New ' . $taxonomy['single_name'],
			'new_item_name' => 'New ' . $taxonomy['single_name'] . ' Name',
			'menu_name' => $taxonomy['plural_name']
		);
		
		$rewrite = isset( $taxonomy['rewrite'] ) ? $taxonomy['rewrite'] : array( 'slug' => $taxonomy['slug'] );
		$hierarchical = isset( $taxonomy['hierarchical'] ) ? $taxonomy['hierarchical'] : true;
	
		register_taxonomy( $taxonomy['slug'], $taxonomy['post_type'], array(
			'hierarchical' => $hierarchical,
			 'show_tagcloud' => false,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'show_admin_column' => true,
			'rewrite' => $rewrite,
		));
	}
}
add_action( 'init', 'lccc_cl_register_taxonomies' );

//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_topics_hierarchical_taxonomy', 0 );

function lc_crime_cpt_add_taxonomy_filters() {
	global $typenow;
 
	// an array of all the taxonomyies you want to display. Use the taxonomy name or slug
	$taxonomies = array('report_year','report_month');
 
	// must set this to the post type you want the filter(s) displayed on
	if( $typenow == 'crime_log' ){
 
		foreach ($taxonomies as $tax_slug) {
			$tax_obj = get_taxonomy($tax_slug);
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			if(count($terms) > 0) {
				echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
				echo "<option value=''>Show All $tax_name</option>";
				foreach ($terms as $term) { 
					echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
				}
				echo "</select>";
			}
		}
	}
}
add_action( 'restrict_manage_posts', 'lc_crime_cpt_add_taxonomy_filters' );


?>