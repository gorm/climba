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


<?php

/*$climbing_competence_terms = get_terms([
   'taxonomy' => 'climbing_competence',
   'hide_empty' => false,
   ]);*/

?>

<?php get_header(); ?>

<section id="content" <?php Avada()->layout->add_class( 'content_class' ); ?> <?php Avada()->layout->add_style( 'content_style' ); ?>>
    <?php if ( category_description() ) : ?>
	<div id="post-<?php the_ID(); ?>" <?php post_class( 'fusion-archive-description' ); ?>>
	    <div class="post-content">
		<?php echo category_description(); ?>
	    </div>
	</div>
    <?php endif; ?>

    <div id="archive-filters">
        <?php foreach( $GLOBALS['my_query_filters'] as $key => $name ): 

        // get the field's settings without attempting to load a value
        $field = get_field_object("climbing_competence", 25, false);

        // set value if available
        if( isset($_GET[ $name ]) ) {
	    $field['value'] = explode(',', $_GET[ $name ]);
        } else {
            $field['value'] = array();
        }

        // create filter
        ?>
            <div class="filter" data-filter="<?php echo $name; ?>">
	        <?php acf_render_field( $field ); ?>
            </div>
            
        <?php endforeach; ?>
    </div>
    
    <?php get_template_part( 'templates/blog', 'layout-activity' ); ?>
</section>
<?php do_action( 'avada_after_content' ); ?>

<script type="text/javascript" defer>
 (function($) {
     // change
     $('#archive-filters').on('change', 'input[type="checkbox"]', function(){
         // vars
         var url = '<?php echo home_url('activity/'); ?>';
         var args = {};

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

<?php
get_footer();



/* Omit closing PHP tag to avoid "Headers already sent" issues. */
//echo $wp_query->request;
