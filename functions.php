<?php
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 99);
function child_enqueue_styles() {
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ) );
}

if ( get_stylesheet() !== get_template() ) {
    add_filter( 'pre_update_option_theme_mods_' . get_stylesheet(), function ( $value, $old_value ) {
        update_option( 'theme_mods_' . get_template(), $value );
        return $old_value; // prevent update to child theme mods
    }, 10, 2 );
    add_filter( 'pre_option_theme_mods_' . get_stylesheet(), function ( $default ) {
        return get_option( 'theme_mods_' . get_template(), $default );
    } );
}

// array of filters (field key => field name)
$GLOBALS['my_query_filters'] = array( 
    'climbing_competence'	=> 'cc'
);

// action
add_action('pre_get_posts', 'my_pre_get_posts', 10, 1);

function my_pre_get_posts( $query ) {
    // bail early if is in admin
    if( is_admin() ) return;
    
    // bail early if not main query
    // - allows custom code / plugins to continue working
    if( !$query->is_main_query() ) return;
    
    // get meta query
    $meta_query = $query->get('meta_query');
    if ( $meta_query == '' ) {
        $meta_query = array();
    }
    // loop over filters
    foreach( $GLOBALS['my_query_filters'] as $key => $name ) {
	// continue if not found in url
	if( empty($_GET[ $name ]) ) {
	    continue;
	}
	
	// get the value for this filter
	// eg: http://www.website.com/events?city=melbourne,sydney
	$values = explode(',', $_GET[ $name ]);

        foreach ( $values as $value ) {
	    // append meta query
    	    $meta_query[] = array(
                'key'		=> $key,
                'value'		=> '"' . $value . '"',
                'compare'	        => 'LIKE',
            );
        }
    } 
    
    // update meta query
    $query->set('meta_query', $meta_query);

    return;
}

