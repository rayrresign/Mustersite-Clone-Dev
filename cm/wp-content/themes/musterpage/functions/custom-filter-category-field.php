<?php

// Add the field to the Add New Category page
add_action( 'Filter_add_form_fields', 'pt_taxonomy_add_new_meta_field', 10, 2 );
 
function pt_taxonomy_add_new_meta_field() {
    // this will add the custom meta field to the add new term page
    ?>
    <div class="form-field">
        <label for="term_meta[cat_order]"><?php _e( 'Reihenfolge', 'pt' ); ?></label>
        <input type="text" name="term_meta[cat_order]" id="term_meta[cat_order]" value="">
        <p class="description"><?php echo 'Wählen Sie die Reihenfolge der Kategorien / Rubriken auf dem Navigationsmenü.'; ?></p>
    </div>
<?php
}


// Add the field to the Edit Category page
add_action( 'Filter_edit_form_fields', 'pt_taxonomy_edit_meta_field', 10, 2 );
 
function pt_taxonomy_edit_meta_field($term) {
 
    // put the term ID into a variable
    $t_id = $term->term_id;
 
    // retrieve the existing value(s) for this meta field. This returns an array
    $term_meta = get_option( "cat_order_$t_id" ); ?>
    <tr class="form-field">
    <th scope="row" valign="top"><label for="term_meta[cat_order]"><?php _e( 'Reihenfolge', 'pt' ); ?></label></th>
        <td>
            <input type="text" name="term_meta[cat_order]" id="term_meta[cat_order]" value="<?php echo esc_attr( $term_meta['cat_order'] ) ? esc_attr( $term_meta['cat_order'] ) : ''; ?>">
            <p class="description"><?php echo 'Wählen Sie die Reihenfolge der Kategorien / Rubriken auf dem Navigationsmenü.'; ?></p>
        </td>
    </tr>
<?php
}

// Save extra taxonomy fields callback function.
add_action( 'edited_Filter', 'pt_save_taxonomy_custom_meta', 10, 2 );
add_action( 'create_Filter', 'pt_save_taxonomy_custom_meta', 10, 2 );
 
function pt_save_taxonomy_custom_meta( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "cat_order_$t_id" );
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ) {
            if ( isset ( $_POST['term_meta'][$key] ) ) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        // Save the option array.
        update_option( "cat_order_$t_id", $term_meta );
    }
}

// Header
function Filter_column_header($columns)
{
    $columns['reihenfolge'] = __('Reihenfolge');
    return $columns;
}
add_filter('manage_edit-Filter_columns', 'Filter_column_header', 10, 1);

// Header Values
function Filter_column_value($empty = '', $custom_column, $term_id) 
{
    return  esc_html(get_option( "cat_order_$term_id")['cat_order']);     
}
add_filter('manage_Filter_custom_column', 'Filter_column_value', 10, 3);

// Quick-Edit
function my_quick_edit_custom_box($column_name = null, $screen= null, $name= null)
{   
    if($name != 'Filter') return false;
?>
    <fieldset>
        <div class="inline-edit-col">
            <label>
                <span class="title" name="reihenfolge"><?php if($column_name == 'reihenfolge') _e('Reihenfolge'); ?></span>
                <span class="input-text-wrap"><input type="text" name="<?php echo $column_name; ?>" class="ptitle" value=""></span>
            </label>
        </div>
    </fieldset>
<?php 
}
//add_action('quick_edit_custom_box', 'my_quick_edit_custom_box', 10, 3); 

// Update Quick-Edit
function my_save_term_meta($term_id)
{
    $allowed_html = array( );
    if(isset($_POST['reihenfolge'])) 
        update_term_meta($term_id, 'reihenfolge', wp_kses($_POST['reihenfolge'], $allowed_html));    
}
//add_action('edited_Filter', 'my_save_term_meta', 10, 1);



?>

