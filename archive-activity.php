<?php
/**
 * Archives template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}
?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" type="text/javascript"></script>

<div id="archive-filters">
<?php foreach( $GLOBALS['my_query_filters'] as $key => $name ): 
        // get the field's settings without attempting to load a value
	$field = get_field_object("climbing_competence", 25, false);

	// set value if available
	if( isset($_GET[ $name ]) ) {
		$field['value'] = explode(',', $_GET[ $name ]);
	}

	// create filter
	?>
    <div class="filter" data-filter="<?php echo $name; ?>">
	<?php create_field( $field ); ?>
    </div>
    
<?php endforeach; ?>
</div>

<script type="text/javascript">
    (function($) {
    
    // change
    $('#archive-filters').on('change', 'input[type="checkbox"]', function(){

    // vars
    var url = '<?php echo home_url('activity/'); ?>';
    args = {};
    
    // loop over filters
    $('#archive-filters .filter').each(function(){
        // vars
        var filter = $(this).data('filter'),
        vals = [];
    
        // find checked inputs
        $(this).find('input:checked').each(function(){
            vals.push( $(this).val() );
        });
    
        // append to args
        args[ filter ] = vals.join(',');
    
    });
    
    // update url
    url += '?';
    
    // loop over args
    $.each(args, function( name, value ){
        url += name + '=' + value + '&';
    });
    
    // remove last &
    url = url.slice(0, -1);
    
    // reload page
    window.location.replace( url );
    
    });

    })(jQuery);
</script>

<?php get_header(); ?>
<section id="content" <?php Avada()->layout->add_class( 'content_class' ); ?> <?php Avada()->layout->add_style( 'content_style' ); ?>>
    <?php if ( category_description() ) : ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class( 'fusion-archive-description' ); ?>>
	    <div class="post-content">
		<?php echo category_description(); ?>
	    </div>
	</div>
    <?php endif; ?>

    <?php get_template_part( 'templates/blog', 'layout-activity' ); ?>
</section>
<?php do_action( 'avada_after_content' ); ?>
<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
echo var_dump($wp_query);
