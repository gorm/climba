
<?php
// Adding session goal
$terms = get_field('session_phase');
if( $terms ): ?>
    <ul>
        <?php foreach( $terms as $term ): ?>
    	    <h2><?php echo $term->name; ?></h2>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php
// Adding stage
$terms = get_field('stage');
if( $terms ): ?>
    <ul>
        <?php foreach( $terms as $term ): ?>
    	    <h2><?php echo $term->name; ?></h2>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


<?php
/*
   (
   [term_id] => 9
   [name] => &gt; 15 minutes
   [slug] => morethan15m
   [term_group] => 0
   [term_taxonomy_id] => 9
   [taxonomy] => Time
   [description] => 
   [parent] => 0
   [count] => 0
   [filter] => raw
   )

 */

// Adding time
$term = get_field('time');
if( $term ): ?>
    <h2><?php echo $term->name; ?></h2>
    <h2><?php echo $term->description; ?></h2>    
<?php endif; ?>

<?php 
// Adding difficulty
$terms = get_field('difficulty');
if( $terms ): ?>
    <ul>
        <?php foreach( $terms as $term ): ?>
    	    <h2><?php echo $term->name; ?></h2>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php 
// Adding tags
$terms = get_field('tags');
if( $terms ): ?>
    <ul>
        <?php foreach( $terms as $term ): ?>
    	    <h2><?php echo $term->name; ?></h2>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php echo kk_star_ratings(); ?>

