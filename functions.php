<?php
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 99);
function child_enqueue_styles() {
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ) );
    wp_enqueue_script('jquery');
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
        //$meta_query = array('realtion' => 'AND');
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

        foreach ( $values as $key2 => $value2) {
            // append meta query
    	    $meta_query[] = array(
                'key'		=> $key,
                'value'		=> '"' . $value2 . '"',
                'compare'       => 'LIKE',
            );
        }
    } 
    
    // update meta query
    $query->set('meta_query', $meta_query);

    return;
}

/* function get_acf_field_keys( $custom_field_slug = '' ) {
 * 
 *     $result = array();
 * 
 *     $meta_key_start = 'field_';
 * 
 *     $acf_args = array(
 * 	'post_type'		=> 'acf-field'
 *     );
 * 
 *     if ( $custom_field_slug !== '' ) {
 * 	$acf_args[ 'name' ] = $custom_field_slug;
 *     }
 * 
 *     $acf_query = new WP_Query( $acf_args );
 *     print_r($acf_query);
 *     if ( $acf_query->have_posts() ) {
 *         echo "yo";
 * 	while ( $acf_query->have_posts() ) {
 * 	    $acf_query->the_post();
 * 	    $meta_values = get_post_meta( get_the_id() );
 * 	    foreach ( $meta_values as $meta_key => $meta_value ) {
 * 		
 * 		if ( substr( $meta_key, 0, strlen( $meta_key_start ) ) === $meta_key_start ) {
 * 
 * 		    $meta_value_array = unserialize( $meta_value[0] );
 * 
 * 		    $result[ $meta_value_array['name'] ] = $meta_key;
 * 
 * 		}
 * 
 * 	    }
 * 
 * 	}
 * 
 *     }
 * 
 *     wp_reset_postdata();
 * 
 *     if ( empty( $result ) ) {
 *         echo "no";
 * 	$result = false;
 *     }
 * 
 *     return $result;
 * 
 * }*/
