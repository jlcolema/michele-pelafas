<?php

/**
 * WC function/methods
 * https://github.com/woocommerce/woocommerce/blob/master/includes
 *
 *
 */


//createUpdateMembers();
//createAttributes();
//createAttributeTerms();
//createProductCategories(); // Critical - only run once
//createProducts();
//createProductsBatch();
//die();


// TODO run each of these
// if( $_GET['arc'] === '1' ) {
    //add_action( 'init', array( 'CreateCustomers', 'init' ) );
// }
//add_action( 'init', 'createProductCategories' ); // Critical - only run once
//add_action( 'init', array( 'CreateProducts', 'init' ) );


/**
 *
 * Customers
 *
 */

 class CreateCustomers {

    // How many customers to batch
    private $batchSize = 1000;
    private $customerCount = 4000; // set to 4000 for prod

    public static function init() {
        $class = __CLASS__;
        new $class;
    }

    public function __construct() {
        $this->createCustomersBatch();
    }

    public function createCustomersBatch( $start = 3000 ) {
        //return; // For easy testing

        $start += intval( @$_GET['start'] );

        $next = $start + $this->batchSize;

        // Put this up here so we get it on the last batch run too
        if( http_response_code() === 200 ) {
            header( 'Processed: ' . $start . '-' . $next );
        }

        if( $start < $this->customerCount ) {
            // Because apparently we need to check this, otherwise this runs 3 times -- sometimes
            if( http_response_code() === 200 ) {
                $this->createUpdateCustomers( $start );
                sleep(2);

                wp_redirect( '/?arc=1&start=' . $next );
            }
            //die();
        }
    }

    //public function createUpdateCustomers( $start = 0 ) {
    function createUpdateCustomers( $start = 0 ) {
        $filename = 'Customers_53U82V5CZZ.spadecor.com.csv';
        $customers = array_map( 'str_getcsv', file( get_theme_file_path( '/volusion/' . $filename ) ) );
        //var_dump( $customers );
        array_walk( $customers, function( &$a ) use( $customers ) {
          $a = array_combine( $customers[0], $a );
        });
        array_shift( $customers );
        //var_dump( $customers );

        //var_dump( $customers );
        //die();

        /*
        $filename = 'Customers_USJXSKU2QQ.salondesign.luxury.csv';
        $customers2 = array_map( 'str_getcsv', file( get_theme_file_path( '/volusion/' . $filename ) ) );
        //var_dump( $customers );
        array_walk( $customers2, function( &$a ) use( $customers2 ) {
          $a = array_combine( $customers2[0], $a );
        });
        array_shift( $customers2 );
        //var_dump( $customers );

        $customers = array_merge( $customers, $customers2 );
        */

        $customers = array_slice( $customers, $start, $this->batchSize );
        //var_dump( $start );
        //var_dump( $products );

        //var_dump( $customers );
        //die();

        foreach( $customers as $customer ) {
            //var_dump( $customer['firstname'] );

            $email_address = preg_replace( '/\s/', '', $customer['emailaddress'] );
            var_dump( $email_address );

            // If we have a new user to add
            if( !empty( $email_address ) && is_email( $email_address ) ) {

                // Generate the password and create the user
                $user_id = email_exists( $email_address );
                if( $user_id === FALSE ) {
                    echo '... ADDING ...' . "\r\n";
                    $password = wp_generate_password( 12, false );
                    $user_id = wp_create_user( $email_address, $password, $email_address );

                } else {
                    echo '... UPDATING ...' . "\r\n";
                }
                var_dump( 'User ID', $user_id );

                // Save volusion data
                var_dump( 'volusion_customer_data', update_user_meta( $user_id, 'volusion_customer_data', $customer ) );

                // Import the WP User data
                wp_update_user(
                    array(
                        'ID'         => $user_id,
                        'nickname'   => $email_address,
                        'first_name' => @$customer['firstname'],
                        'last_name'  => @$customer['lastname']
                    )
                );

                // Set the role
                $user = new WP_User( $user_id );
                //var_dump( $user );
                $role = @$customer['issuperadmin'];
                if( $role === 'Y' ) {
                    if( !in_array( 'administrator', $user->roles ) )
                        $user->set_role( 'administrator' );
                } else {
                    if( !in_array( 'customer', $user->roles ) )
                        $user->set_role( 'customer' );
                }

                $country = @$customer['country'];
                if( $country === 'United States' ) {
                    $country = 'US';
                } elseif( $country === 'Canada' ) {
                    $country = 'CA';
                } else {
                    $country = '';
                }

                // Import the WC user data
                $data = array(
                    'billing_company'     => @$customer['companyname'],
                    'billing_first_name'  => @$customer['firstname'],
                    'billing_last_name'   => @$customer['lastname'],
                    'billing_email'       => $email_address,
                    'billing_address_1'   => @$customer['billingaddress1'],
                    'billing_address_2'   => @$customer['billingaddress2'],
                    'billing_city'        => @$customer['city'],
                    'billing_state'       => @$customer['state'],
                    'billing_postcode'    => @$customer['postalcode'],
                    'billing_country'     => $country,
                    'billing_phone'       => @$customer['phonenumber'],

                    'shipping_company'    => @$customer['companyname'],
                    'shipping_first_name' => @$customer['firstname'],
                    'shipping_last_name'  => @$customer['lastname'],
                    'shipping_email'      => $email_address,
                    'shipping_address_1'  => @$customer['billingaddress1'],
                    'shipping_address_2'  => @$customer['billingaddress2'],
                    'shipping_city'       => @$customer['city'],
                    'shipping_state'      => @$customer['state'],
                    'shipping_postcode'   => @$customer['postalcode'],
                    'shipping_country'    => $country,
                    'shipping_phone'      => @$customer['phonenumber']
                );
                foreach( $data as $meta_key => $meta_value ) {
                    var_dump( $meta_key, update_user_meta( $user_id, $meta_key, $meta_value ) );
                }

                // Only run this once for testing
                // Remove for full run
                //die();
            }

            // Only run this once for testing
            // Remove for full run
            //die();

            echo "\r\n";
            //sleep(2);
        }

        //die();
    }
}





///**
// *
// * WC Attributes
// *
// */
//
//function createAttributes() {
//    $filename = 'OptionCategories_FD5JC6FNBB.csv';
//    $attributes = array_map( 'str_getcsv', file( get_theme_file_path( '/volusion/' . $filename ) ) );
//    //var_dump( $attributes );
//    array_walk( $attributes, function( &$a ) use( $attributes ) {
//      $a = array_combine( $attributes[0], $a );
//    });
//    array_shift( $attributes );
//    //var_dump( $attributes );
//
//    foreach( $attributes as $attribute ) {
//        $name = @$attribute['optioncategoriesdesc'];
//        var_dump( $name );
//        //var_dump( get_attribute_id_from_name( $name ) );
//
//        // If we have a new attribute to add
//        if( !empty( $name ) && get_attribute_id_from_name( $name ) === false ) {
//            echo '... ADDING ...' . "\r\n";
//
//            save_product_attribute_from_name( $name );
//
//            // Only run this once for testing
//            // Remove for full run
//            //die();
//        }
//    }
//}
//
///**
// * Save a new product attribute from it's name (slug).
// *
// * @since 3.0.0
// * @param string $name  | The product attribute name (slug).
// * @param string $label | The product attribute label (name).
// */
//function save_product_attribute_from_name( $name, $label='', $set=true ){
//    if( ! function_exists ('get_attribute_id_from_name') ) return;
//
//    global $wpdb;
//
//    $label = $label == '' ? ucfirst($name) : $label;
//    $attribute_id = get_attribute_id_from_name( $name );
//
//    if( empty($attribute_id) ){
//        $attribute_id = NULL;
//    } else {
//        $set = false;
//    }
//    $args = array(
//        'attribute_id'      => $attribute_id,
//        'attribute_name'    => substr( $name, 0, 28 ), // Required string length
//        'attribute_label'   => $label,
//        'attribute_type'    => 'select',
//        'attribute_orderby' => 'menu_order',
//        'attribute_public'  => 0,
//    );
//
//    if( empty($attribute_id) )
//        $wpdb->insert(  "{$wpdb->prefix}woocommerce_attribute_taxonomies", $args );
//
//    // TODO - save volusion attribute data somewhere?
//
//    if( $set ){
//        $attributes = wc_get_attribute_taxonomies();
//        $args['attribute_id'] = get_attribute_id_from_name( $name );
//        $attributes[] = (object) $args;
//        //print_r($attributes);
//        set_transient( 'wc_attribute_taxonomies', $attributes );
//    } else {
//        return;
//    }
//}
//
///**
// * Get the product attribute ID from the name.
// *
// * @since 3.0.0
// * @param string $name | The name (slug).
// */
//function get_attribute_id_from_name( $name ){
//    global $wpdb;
//    $attribute_id = $wpdb->get_col("SELECT attribute_id
//    FROM {$wpdb->prefix}woocommerce_attribute_taxonomies
//    WHERE attribute_name LIKE '" . substr( $name, 0, 28 ) . "'");
//    return reset($attribute_id);
//}
//
//
//
//
//
//
//
///**
// *
// * WC Attribute Terms
// *
// */
//
//function createAttributeTerms() {
//    // Attributes
//    $filename = 'OptionCategories_FD5JC6FNBB.csv';
//    $attributes = array_map( 'str_getcsv', file( get_theme_file_path( '/volusion/' . $filename ) ) );
//    //var_dump( $attributes );
//    array_walk( $attributes, function( &$a ) use( $attributes ) {
//      $a = array_combine( $attributes[0], $a );
//    });
//    array_shift( $attributes );
//    //var_dump( $attributes );
//
//    // Terms
//    $filename = 'Options_HE7ME8HQDC.csv';
//    $terms = array_map( 'str_getcsv', file( get_theme_file_path( '/volusion/' . $filename ) ) );
//    //var_dump( $terms );
//    array_walk( $terms, function( &$a ) use( $terms ) {
//      $a = array_combine( $terms[0], $a );
//    });
//    array_shift( $terms );
//    //var_dump( $terms );
//
//
//    foreach( $terms as $term ) {
//        $name = @$term['optionsdesc'];
//        var_dump( $name );
//
//        $parent = @$term['optioncatid'];
//        $parent_id = 0;
//        //var_dump( $parent );
//        if( !empty( $parent ) ) {
//            foreach( $attributes as $attribute ) {
//                if( $parent === @$attribute['id'] ) {
//                    //var_dump( $attribute );
//                    $parent_id = get_attribute_id_from_name( @$attribute['optioncategoriesdesc'] );
//                }
//            }
//        }
//        //var_dump( $parent_id );
//        //var_dump( wc_get_attribute( $parent_id ) );
//        $wp_attribute = wc_get_attribute( $parent_id );
//
//
//        //var_dump( get_term_by( 'name', $name, 'product_cat' ) );
//
//        //var_dump( get_attribute_term_id_from_name($name) );
//
//        if( !empty( $name ) ) { //&& !get_attribute_term_id_from_name( $name ) ) {
//            echo '... ADDING ...' . "\r\n";
//
//
//            //var_dump( wc_get_attribute_taxonomies() );
//            //var_dump( wc_get_attribute_taxonomy_names() );
//            //var_dump( wc_get_object_terms( 10, 'pa_test-attribute' ) );
//            //var_dump( wc_attribute_taxonomy_name_by_id( $parent_id ) );
//            //var_dump( wc_attribute_taxonomy_id_by_name( wc_attribute_taxonomy_name_by_id( $parent_id ) ) );
//            //var_dump( wc_attribute_taxonomy_id_by_name( 'pa_test-attribute' ) );
//            //var_dump( wc_attribute_taxonomy_name_by_id( wc_attribute_taxonomy_id_by_name( 'pa_test-attribute' ) ) );
//
//            var_dump( $name, $wp_attribute->slug, $wp_attribute->id );
//            //var_dump( $name, $wp_attribute->slug );
//            //var_dump( wp_insert_term(
//            //    $name,
//            //    $wp_attribute->slug/*,
//            //    array(
//            //        'parent' => $wp_attribute->id
//            //    )*/
//            //) );
//
//            // insert term
//            //var_dump( sanitize_title( 'super duper test' ) );
//            var_dump( save_product_attribute_term_from_name( $name ) );
//            $term_id = get_attribute_term_id_from_name( $name );
//
//            // Save volusion data
//            var_dump( update_term_meta( $term_id, 'volusion_option_data', $term ) );
//
//            // insert termmeta
//            var_dump( save_product_attribute_termmeta_from_name( $term_id, $wp_attribute->slug ) );
//
//            // insert term taxonomy
//            var_dump( save_product_attribute_term_taxonomy_from_name( $term_id, $wp_attribute->slug ) );
//
//            // Only run this once for testing
//            // Remove for full run
//            //die();
//        }
//    }
//}
//
///**
// * Save a new product attribute term from it's name.
// *
// * @since 3.0.0
// * @param string $name  | The product attribute name.
// */
//function save_product_attribute_term_from_name( $name ){
//    if( ! function_exists ('get_attribute_term_id_from_name') ) return;
//
//    global $wpdb;
//
//    $attribute_id = get_attribute_term_id_from_name( $name );
//
//    $args = array(
//        'name' => htmlentities( $name, ENT_QUOTES ),
//        'slug' => sanitize_title( $name ),
//    );
//
//    if( empty( $attribute_id ) )
//        return $wpdb->insert(  "{$wpdb->prefix}terms", $args );
//}
//
///**
// * Save a new product attribute termmeta from it's name (slug).
// *
// * @since 3.0.0
// * @param int $id       | The product attribute term id.
// * @param string $label | The product attribute taxonomy name.
// */
//function save_product_attribute_termmeta_from_name( $id, $tax ){
//    if( ! function_exists ('get_attribute_termmeta_id_from_name') ) return;
//
//    global $wpdb;
//
//    $attribute_id = get_attribute_termmeta_id_from_name( 'order_' . $tax, $id );
//
//    $args = array(
//        'term_id'    => $id,
//        'meta_key'   => 'order_' . $tax,
//        'meta_value' => 0
//    );
//
//    if( empty( $attribute_id ) )
//        return $wpdb->insert(  "{$wpdb->prefix}termmeta", $args );
//}
//
///**
// * Save a new product attribute term taxonomy from it's name (slug).
// *
// * @since 3.0.0
// * @param int $id       | The product attribute term id.
// * @param string $label | The product attribute taxonomy name.
// */
//function save_product_attribute_term_taxonomy_from_name( $id, $tax ){
//    if( ! function_exists ('get_attribute_term_taxonomy_id_from_name') ) return;
//
//    global $wpdb;
//
//    $attribute_id = get_attribute_term_taxonomy_id_from_name( $tax, $id );
//
//    $args = array(
//        'term_id'     => $id,
//        'taxonomy'    => $tax
//    );
//
//    if( empty( $attribute_id ) )
//        return $wpdb->insert(  "{$wpdb->prefix}term_taxonomy", $args );
//}
//
///**
// * Get the product attribute term ID from the name.
// *
// * @since 3.0.0
// * @param string $name | The name (slug).
// */
//function get_attribute_term_id_from_name( $name ){
//    global $wpdb;
//    $attribute_id = $wpdb->get_col("SELECT term_id
//    FROM {$wpdb->prefix}terms
//    WHERE name = '" . htmlentities( $name, ENT_QUOTES ) . "'");
//    return reset($attribute_id);
//}
//
///**
// * Get the product attribute term ID from the name.
// *
// * @since 3.0.0
// * @param string $name | The name (slug).
// * @param int $id      | The product attribute term id.
// */
//function get_attribute_termmeta_id_from_name( $name, $id ){
//    global $wpdb;
//    $attribute_id = $wpdb->get_col("SELECT term_id
//    FROM {$wpdb->prefix}termmeta
//    WHERE meta_key = '" . htmlentities( $name, ENT_QUOTES ) . "'
//    AND term_id = '$id'");
//    return reset($attribute_id);
//}
//
///**
// * Get the product attribute term ID from the name.
// *
// * @since 3.0.0
// * @param string $name | The name (slug).
// * @param int $id      | The product attribute term id.
// */
//function get_attribute_term_taxonomy_id_from_name( $name, $id ){
//    global $wpdb;
//    $attribute_id = $wpdb->get_col("SELECT term_id
//    FROM {$wpdb->prefix}term_taxonomy
//    WHERE taxonomy = '$name'
//    AND term_id = '$id'");
//    return reset($attribute_id);
//}






/**
 *
 * Product Categories
 *
 * WARNING: Creates duplicate categories. Cannot be run multiple times.
 *
 */

function createProductCategories() {
    $filename = 'Categories_ZXQ4WRZ7VV.salondesign.luxory.csv';
    $categories = array_map( 'str_getcsv', file( get_theme_file_path( '/volusion/' . $filename ) ) );
    //var_dump( $categories );
    array_walk( $categories, function( &$a ) use( $categories ) {
      $a = array_combine( $categories[0], $a );
    });
    array_shift( $categories );
    //var_dump( $categories );

    //wp_cache_delete ( 'alloptions', 'options' );

    foreach( $categories as $category ) {
        $name = @$category['categoryname'];
        var_dump( $name );

        if( !empty( $name ) ) { // && !get_attribute_term_id_from_name( $name ) ) {
            echo '... ADDING ...' . "\r\n";

            // Save term
            $term_id = save_product_category_from_name( $name );
            var_dump( $term_id );

            // Save volusion data
            var_dump( update_term_meta( $term_id, 'volusion_category_data', $category ) );

            // Set as a product category
            //var_dump( save_product_category_term_taxonomy_from_name( $term_id, 'product_cat' ) );

            // Set meta description
            //$meta = get_option( $meta_title );
            //var_dump( $meta );
            //$meta_array = maybe_unserialize( $meta );
            //var_dump( $meta_array );
            //var_dump( $meta );

            //if( !is_array( $meta ) )
            //    $meta = array();
            //
            //if( !is_array( $meta['product_cat'] ) )
            //    $meta['product_cat'] = array();
            //
            //if( !is_array( $meta['product_cat'][$term_id] ) )
            //    $meta['product_cat'][$term_id] = array();

            if( !empty( @$category['metatag_description'] ) ) {
                $meta_title = 'wpseo_taxonomy_meta';
                $meta = maybe_unserialize( get_option( $meta_title ) );
                $meta['product_cat'][$term_id]['wpseo_desc'] = $category['metatag_description'];
                //var_dump( $meta );

                if( get_option( $meta_title ) !== false ) {
                    echo '... UPDATE META ...' . "\r\n";
                    var_dump( update_option( $meta_title, $meta ) );
                } else {
                    echo '... ADD META ...' . "\r\n";
                    var_dump( add_option( $meta_title, $meta ) );
                }
            }

            // Set as a product category
            // Update category parent
            $parent_id = @$category['parentid'];
            $parent_term_id = 0;
            if( !empty( $parent_id ) && $parent_id !== '0' ) {
                var_dump( $parent_id );
                $parent_term_id = get_category_term_id_from_volusion_parent_id( $parent_id );
                var_dump( $parent_term_id );
            }
            //$parent_name = '';
            //foreach( $categories as $cat ) {
            //    if( @$cat['categoryid'] === $parent_id ) {
            //        $parent_name = @$cat['categoryname'];
            //        break;
            //    }
            //    //echo 'we still here?';
            //}
            //var_dump( $parent_name );

            //$parent_term_id = 0;
            //if( !empty( $parent_name ) ) {
            //    $parent_term_id = get_attribute_term_id_from_name( $parent_name );
            //    var_dump( $parent_term_id );
            //}
            //
            var_dump( save_product_category_term_taxonomy_from_name( $term_id, $parent_term_id ) );

            // Only run this once for testing
            // Remove for full run
            //die();
        } else {
            echo '... NOT ADDING ...' . "\r\n";
        }

        echo "\r\n";
    }

    // Fixes sub category linking
    //clean_term_cache();

    die();
}

/**
 * Returns the WordPress Term ID based on the Volusion ID
 *
 */
function get_category_term_id_from_volusion_parent_id( $volusion_id ) {
    global $wpdb;

    //var_dump( $wpdb->get_results("SELECT *
    //FROM {$wpdb->prefix}terms AS T
    //LEFT JOIN {$wpdb->prefix}termmeta AS TM
    //ON T.term_id = TM.term_id
    //WHERE TM.meta_key = 'volusion_category_data'
    //AND meta_value LIKE '%\"categoryid\";s:3:\"$volusion_id\"%'") );

    $attribute_id = $wpdb->get_col("SELECT T.term_id
    FROM {$wpdb->prefix}terms AS T
    LEFT JOIN {$wpdb->prefix}termmeta AS TM
    ON T.term_id = TM.term_id
    WHERE TM.meta_key = 'volusion_category_data'
    AND meta_value LIKE '%\"categoryid\";s:3:\"$volusion_id\"%'");
    //var_dump( $wpdb->last_query );
    return reset($attribute_id);
}

/**
 * Save a new product attribute term from it's name.
 *
 * @since 3.0.0
 * @param string $name  | The product attribute name.
 */
function save_product_category_from_name( $name ){
    global $wpdb;

    $slug = sanitize_title( $name );
    $name = htmlentities( $name, ENT_QUOTES );

    // loop through this until it's empty
    var_dump( 'Checking ' . $slug );
    $attribute_id = get_term_id_from_slug( $slug );
    var_dump( 'Found ' . $attribute_id );
    $i = 1;
    while( !empty( $attribute_id ) ) {
        $slug = sanitize_title( $name ) . '-' . $i;
        var_dump( 'Checking ' . $slug );
        $attribute_id = get_term_id_from_slug( $slug );
        var_dump( 'Found ' . $attribute_id );
        $i++;
    }

    $args = array(
        'name' => $name,
        'slug' => $slug,
    );

    $wpdb->insert(  "{$wpdb->prefix}terms", $args );
    return $wpdb->insert_id;
}

/**
 * Get the product attribute term ID from the name.
 *
 * @since 3.0.0
 * @param string $name | The name (slug).
 */
function get_term_id_from_slug( $slug ){
    global $wpdb;
    $attribute_id = $wpdb->get_col("SELECT term_id
    FROM {$wpdb->prefix}terms
    WHERE slug = '" . $slug . "'");
    return reset($attribute_id);
}


/**
 * Save a new product attribute term taxonomy from it's name (slug).
 *
 * @since 3.0.0
 * @param int $id       | The product attribute term id.
 * @param string $label | The product attribute taxonomy name.
 */
function save_product_category_term_taxonomy_from_name( $id, $parent = 0 ){
    global $wpdb;

    $args = array(
        'term_id'     => $id,
        'taxonomy'    => 'product_cat',
        'parent'      => $parent
    );

    return $wpdb->insert(  "{$wpdb->prefix}term_taxonomy", $args );
}








/**
 *
 * Products
 *
 */

 class CreateProducts {

    private $volusionProducts;

    // How many products to batch
    private $batchSize = 10;
    private $productCount = 10; //100; // set to 2100 for prod

    public static function init() {
        $class = __CLASS__;
        new $class;
    }

    public function __construct() {
        // Get content
        $volusionURL = 'http://www.salondesign.luxury/net/WebService.aspx?Login=michele@spainteriors.com&EncryptedPassword=09F4C74C1ABCD5791140DC509552F7212E96A3921C2C38221F8C8AFD06603AB6&EDI_Name=Generic\all_products';
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $volusionURL );
        curl_setopt( $ch, CURLOPT_HEADER, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $volusionProductHolder = curl_exec( $ch );
        curl_close( $ch );

        $this->volusionProducts = @simplexml_load_string( $volusionProductHolder );
        //var_dump( $volusionProducts->Product );

        $this->createProductsBatch();
        //$this->createUpdateProducts();
    }

    public function createProductsBatch( $start = 0 ) {
        //return; // For easy testing

        $start = intval( $_GET['start'] );

        $next = $start + $this->batchSize;

        // Put this up here so we get it on the last batch run too
        if( http_response_code() === 200 ) {
            header( 'Processed: ' . $start . '-' . $next );
        }

        if( $start < $this->productCount ) {
            // Because apparently we need to check this, otherwise this runs 3 times -- sometimes
            if( http_response_code() === 200 ) {
                $this->createUpdateProducts( $start );
                sleep(2);

                wp_redirect( '/?start=' . $next );
                exit('Should be redirecting here');
            }
            //die();
        }
    }
    public function createUpdateProducts( $start = 0 ) {
        $filename = 'Products_Joined_EC4HB5EM99.missing-products2.no-line-breaks.csv';
        $products = array_map( 'str_getcsv', file( get_theme_file_path( '/volusion/' . $filename ) ) );
        //var_dump( $products );
        array_walk( $products, function( &$a ) use( $products ) {
          $a = array_combine( $products[0], $a );
        });
        array_shift( $products );
        //var_dump( $products );

        //wp_cache_delete ( 'alloptions', 'options' );

        $products = array_slice( $products, $start, $this->batchSize );
        //var_dump( $start );
        //var_dump( $products );

        foreach( $products as $product ) {
            $name = @$product['productname'];
            var_dump( $name );

            // Status
            $status = @$product['hideproduct'];
            if( $status === 'Y' ) {
                $status = 'draft';
            } else {
                $status = 'publish';
            }

            $sku = @$product['productcode'];

            $post_id = product_sku_exists( $sku );

            // Check for product sku - only create if doesnt exist
            if( !product_sku_exists( $sku ) ) {
                echo '... ADDING ...' . "\r\n";

                // Create Product
                $post = array(
                    'post_author'  => 1,
                    'post_content' => @$product['productdescription'],
                        //iconv("UTF-8","UTF-8//IGNORE", @$product['productdescription'] ), -- removes trouble chars <-- 2nd
                        //utf8_encode( @$product['productdescription'] )  -- removes non utf8 <-- 1st
                    'post_status'  => $status,
                    'post_title'   => @$product['productname'],
                    'post_parent'  => '',
                    'post_type'    => "product",
                );
                $post_id = wp_insert_post( $post, $wp_error );

            } else {
                echo '... UPDATING ...' . "\r\n";
            }
            //var_dump( $product );
            var_dump( $post_id );

            if( $post_id ) {
                $photourl = @$product['photourl'];
                $type = pathinfo( $photourl );
                $type = $type['extension'];

                // Product Images
                $photos = downloadAssets( $sku, $type );
                var_dump( $photos );
                if( !empty( $photos ) ) {
                    var_dump( update_post_meta( $post_id, '_thumbnail_id', $photos[0] ) );

                    // Add gallery if more than one photo added
                    if( count( $photos ) > 1 ) {
                        // Remove first photo
                        unset( $photos[0] );
                        $gallery = implode( ',', $photos );
                        var_dump( $gallery );
                        var_dump( update_post_meta( $post_id, '_product_image_gallery', $gallery ) );

                    } else {
                        var_dump( update_post_meta( $post_id, '_product_image_gallery', '' ) );
                    }
                }

                // Save volusion data
                var_dump( update_post_meta( $post_id, 'volusion_product_data', $product ) );

                // Product type
                var_dump( wp_set_object_terms( $post_id, 'simple', 'product_type' ) );

                // SKU
                var_dump( update_post_meta( $post_id, '_sku', $sku ) );

                // Availability
                $availability = @$product['availability'];
                if( empty( $availability ) ) {
                    $availability = 'In Stock';
                }
                var_dump( update_post_meta( $post_id, '_stock_status', 'outofstock' ) );
                var_dump( update_post_meta( $post_id, '_custom_availability', $availability ) );

                // Price information
                $price     = @$product['productprice'];
                $saleprice = '';
                $listprice = @$product['listprice'];
                if( !empty( $listprice ) ) {
                    $saleprice = $price;     // Set sale price to productprice
                    $price     = $listprice; // Set regular price to listprice
                }

                var_dump( update_post_meta( $post_id, '_price', $price ) );
                var_dump( update_post_meta( $post_id, '_regular_price', $price ) );
                var_dump( update_post_meta( $post_id, '_sale_price', $saleprice ) );
                var_dump( update_post_meta( $post_id, '_sale_price_dates_from', '' ) );
                var_dump( update_post_meta( $post_id, '_sale_price_dates_to', '' ) );

                // Shipping sizes
                var_dump( update_post_meta( $post_id, '_weight', @$product['productweight'] ) );
                var_dump( update_post_meta( $post_id, '_length', @$product['length'] ) );
                var_dump( update_post_meta( $post_id, '_width', @$product['width'] ) );
                var_dump( update_post_meta( $post_id, '_height', @$product['height'] ) );

                // Product options
                var_dump( update_post_meta( $post_id, '_product_attributes', array() ) );

                // Vendor information - ACF
                var_dump( update_post_meta( $post_id, 'vendor_name', @$product['productmanufacturer'] ) );
                var_dump( update_post_meta( $post_id, 'vendor_sku', @$product['vendor_partno'] ) );
                var_dump( update_post_meta( $post_id, 'vendor_price', @$product['vendor_price'] ) );

                // Yoast
                var_dump( update_post_meta( $post_id, '_yoast_wpseo_metadesc', @$product['metatag_description'] ) );
                $keywords = @$product['metatag_keywords'];
                var_dump( $keywords );
                if( !empty( $keywords ) ) {
                    $keywords = explode( ',', $keywords );
                    var_dump( update_post_meta( $post_id, '_yoast_wpseo_focuskw', $keywords[0] ) );

                    unset( $keywords[0] );
                    if( !empty( $keywords ) ) {
                        $premium_keywords = '[';
                        for( $i = 0; $i < count( $keywords ); $i++ ) {
                            $premium_keywords.= '{"keyword":"' . $keywords[$i] . '"}';

                            if( $i < count( $keywords ) - 1 ) {
                                $premium_keywords.= ',';
                            }
                        }
                        $premium_keywords.= ']';
                        var_dump( $premium_keywords );
                        var_dump( update_post_meta( $post_id, '_yoast_wpseo_focuskeywords', $premium_keywords ) );
                    }
                }

                // Misc WC meta to add
                var_dump( update_post_meta( $post_id, 'total_sales', '0' ) );
                var_dump( update_post_meta( $post_id, '_backorders', 'no' ) );
                var_dump( update_post_meta( $post_id, '_crosssell_ids', array() ) );
                var_dump( update_post_meta( $post_id, '_default_attributes', array() ) );
                var_dump( update_post_meta( $post_id, '_download_expiry', '-1' ) );
                var_dump( update_post_meta( $post_id, '_download_limit', '-1' ) );
                var_dump( update_post_meta( $post_id, '_downloadable', 'no' ) );
                var_dump( update_post_meta( $post_id, '_edit_last', '' ) );
                var_dump( update_post_meta( $post_id, '_edit_lock', '' ) );
                var_dump( update_post_meta( $post_id, '_manage_stock', 'yes' ) );
                var_dump( update_post_meta( $post_id, '_product_version', '3.4.5' ) );
                var_dump( update_post_meta( $post_id, '_purchase_note', '' ) );
                var_dump( update_post_meta( $post_id, '_sold_individually', 'no' ) );
                var_dump( update_post_meta( $post_id, '_stock', '1000000' ) );
                var_dump( update_post_meta( $post_id, '_tax_class', '' ) );
                var_dump( update_post_meta( $post_id, '_tax_status', 'taxable' ) );
                var_dump( update_post_meta( $post_id, '_upsell_ids', array() ) );
                var_dump( update_post_meta( $post_id, '_virtual', 'no' ) );
                var_dump( update_post_meta( $post_id, '_wc_average_rating', '0' ) );
                var_dump( update_post_meta( $post_id, '_wc_rating_count', array() ) );
                var_dump( update_post_meta( $post_id, '_wc_review_count', '0' ) );

                // Add categories
                $categoryids = @$product['categoryids'];
                $category_ids_to_add = array();
                if( !empty( $categoryids ) ) {
                    $categories = explode( ',', $categoryids );
                    //var_dump( $categories );
                    foreach( $categories as $category ) {
                        $category = intval( $category );
                        // Ignore "0" records
                        if( !empty( $category ) ) {
                            //var_dump( $category );

                            $category_id = get_category_term_id_from_volusion_parent_id( $category );
                            //var_dump( $category_id );

                            // Not all categoryids exist - bad data from Volusion
                            if( $category_id ) {
                                $category_ids_to_add[] = $category_id;
                                //echo "Add $category_id \r\n";
                                //var_dump( 'product cat', wp_set_object_terms( $post_id, $category_id, 'product_cat' ) );
                            }
                        }
                    }
                }
                var_dump( $category_ids_to_add );
                $update = wc_get_product( $post_id );
                //var_dump( $update );
                $update->set_category_ids( $category_ids_to_add );
                var_dump( $update->save() );

                // Add options
                // Export sucks, going to have to use API
                // http://www.salondesign.luxury/net/WebService.aspx?Login=michele@spainteriors.com&EncryptedPassword=09F4C74C1ABCD5791140DC509552F7212E96A3921C2C38221F8C8AFD06603AB6&EDI_Name=Generic\all_products
                //$optionids = @$product['optionids'];
                ////var_dump( $optionids );
                //if( !empty( $optionids ) ) {
                //    $options = explode( ',', $optionids );
                //    //var_dump( $options );
                //    foreach( $options as $option ) {
                //        $option = intval( $option );
                //        // Ignore "0" records
                //        if( !empty( $option ) ) {
                //            //var_dump( $option );
                //
                //            $option_data = get_option_data_from_volusion_parent_id( $option );
                //            //var_dump( $option_data );
                //
                //            // Not all categoryids exist - bad data from Volusion
                //            if( $option_data ) {
                //                //echo "Add $option_id \r\n";
                //                //var_dump( wp_set_object_terms( $post_id, $option_id, 'product_cat' ) );
                //
                //                $meta = maybe_unserialize( $option_data->meta_value );
                //                //var_dump( $meta );
                //                if( is_array( $meta ) ) {
                //                    $category_id = $meta['optioncatid'];
                //                    var_dump( $category_id );
                //
                //                    // Get parent category name
                //                    $filename = 'OptionCategories_FD5JC6FNBB.csv';
                //                    $attributes = array_map( 'str_getcsv', file( get_theme_file_path( '/volusion/' . $filename ) ) );
                //                    //var_dump( $attributes );
                //                    array_walk( $attributes, function( &$a ) use( $attributes ) {
                //                      $a = array_combine( $attributes[0], $a );
                //                    });
                //                    array_shift( $attributes );
                //                    //var_dump( $attributes );
                //
                //                    $product_option_id = 0;
                //                    foreach( $attributes as $attribute ) {
                //                        //var_dump( $attribute );
                //                        //var_dump( $attribute['id'], $category_id );
                //                        if( $attribute['id'] === $category_id ) {
                //                            //var_dump( 'Found', $attribute );
                //                            //var_dump( 'save option', $attribute['optioncategoriesdesc'] );
                //
                //                            $title = $attribute['optioncategoriesdesc'];
                //
                //                            $exists = get_product_option( $post_id, $title );
                //                            if( $exists !== false ) {
                //                                $product_option_id = $exists;
                //                            } else {
                //                                $product_option_id = save_product_option( $post_id, $title );
                //                            }
                //                            var_dump( $product_option_id );
                //
                //                            //var_dump( 'save option', $product_option_id );
                //                            break;
                //                        }
                //                    }
                //
                //                    // Add option value
                //                    var_dump( save_product_option_value( $product_option_id, $post_id, $option_data->name, $meta['pricediff'] ) );
                //                }
                //            }
                //        }
                //    }
                //}
                if( $this->volusionProducts ) {
                    $this->volusionProducts = json_decode( json_encode( $this->volusionProducts, true ) );

                    foreach( $this->volusionProducts->Product as $volusionProduct ) {
                        //var_dump( $volusionProduct->ProductCode );

                        if( $volusionProduct->ProductCode === $sku ) {
                            //print_r( $volusionProduct );
                            //echo "\r\n\r\n\r\n";

                            // Force this to an array - could be an array or not an array in API data
                            $optionCategories = $volusionProduct->OptionCategory;
                            if( !is_array( $optionCategories ) ) {
                                $optionCategories = array( $optionCategories );
                            }

                            if( !empty( $optionCategories ) ) {
                                //var_dump( $optionCategories );

                                foreach( $optionCategories as $optionCategory ) {
                                    //if( !is_array( $optionCategory ) ) {
                                    //    $optionCategory = array( $optionCategory );
                                    //}
                                    ////$optionCategory = (array) $optionCategory;
                                    var_dump( $optionCategory );

                                    $title = $optionCategory->OptionCategoriesDesc;
                                    var_dump( $title );

                                    if( !empty( $title ) ) {
                                        $exists = get_product_option( $post_id, $title );
                                        if( $exists !== false ) {
                                            $product_option_id = $exists;
                                        } else {
                                            $product_option_id = save_product_option( $post_id, $title );
                                        }
                                        var_dump( $product_option_id );

                                        $options = $optionCategory->Options;
                                        if( $options ) {
                                            foreach( $options as $option ) {
                                                var_dump( $option->OptionsDesc );
                                                var_dump( $option->PriceDiff );

                                                // TODO - does not update existing option data
                                                if( !get_product_option_value( $product_option_id, $post_id, $option->OptionsDesc ) ) {
                                                    var_dump( save_product_option_value( $product_option_id, $post_id, $option->OptionsDesc, $option->PriceDiff ) );
                                                }
                                            }
                                        }

                                        echo "\r\n\r\n\r\n";
                                    }
                                }
                            }

                            // Stop processing the massive volusion product xml/array
                            break;
                        }
                    }
                }
            } else {
                var_dump( 'SKU ' . $sku . ' already exists.' );
            }

            // Only run this once for testing
            // Remove for full run
            die();

            echo "\r\n";
            sleep(2);
        }

        //die();
    }
}

/**
 * Returns the WordPress Term ID based on the Volusion ID
 *
 */
function get_option_data_from_volusion_parent_id( $volusion_id ) {
    global $wpdb;
    $data = $wpdb->get_results("SELECT *
    FROM {$wpdb->prefix}terms AS T
    LEFT JOIN {$wpdb->prefix}termmeta AS TM
    ON T.term_id = TM.term_id
    LEFT JOIN wp_term_taxonomy AS TT
    ON T.term_id = TT.term_id
    WHERE TM.meta_key = 'volusion_option_data'
    AND meta_value LIKE '%\"id\";s:3:\"$volusion_id\"%'");
    //var_dump( $data );
    //var_dump( $wpdb->last_query );
    return reset($data);
}



/**
 * Returns true if option $title exists for $product_id
 *
 */
function get_product_option( $product_id, $title ) {
    var_dump( 'get_product_option' );
    global $wpdb;
    $data = $wpdb->get_col("SELECT option_id
    FROM {$wpdb->prefix}pofw_product_option
    WHERE product_id = '$product_id'
    AND title = '$title'");
    //var_dump( $data );
    var_dump( $wpdb->last_query );
    return reset($data);
}



/**
 *
 *
 */
function save_product_option( $product_id, $title, $price = '0.00', $type = 'drop_down', $required = '0', $sort_order = NULL ) {
    //var_dump( 'save_product_option' );
    global $wpdb;

    $args = array(
        'product_id' => $product_id,
        'title'      => $title,
        'price'      => number_format( intval( $price ), 2 ),
        'type'       => $type,
        'required'   => $required,
        'sort_order' => $sort_order,
    );
    //var_dump( $args );

    var_dump( $wpdb->insert(  "{$wpdb->prefix}pofw_product_option", $args ) );
    return $wpdb->insert_id;
}


/**
 * Returns true if option $title exists for $product_id
 *
 */
function get_product_option_value( $option_id, $product_id, $title ) {
    var_dump( 'get_product_option_value' );
    global $wpdb;
    $data = $wpdb->get_col("SELECT value_id
    FROM {$wpdb->prefix}pofw_product_option_value
    WHERE option_id = '$option_id'
    AND product_id = '$product_id'
    AND title = '$title'");
    //var_dump( $data );
    var_dump( $wpdb->last_query );
    return reset($data);
}


/**
 *
 *
 */
function save_product_option_value( $option_id, $product_id, $title, $price = '0.00', $sort_order = NULL ) {
    global $wpdb;

    $args = array(
        'option_id'  => $option_id,
        'product_id' => $product_id,
        'title'      => $title,
        'price'      => number_format( $price, 2 ),
        'sort_order' => $sort_order,
    );

    $wpdb->insert(  "{$wpdb->prefix}pofw_product_option_value", $args );
    return $wpdb->insert_id;
}

/**
 * Returns an array of files downloaded
 *
 */
//var_dump( downloadAssets( '410305' ) );
//die();
function downloadAssets( $sku, $type = 'jpg' ) {
    $photos = array();

    // Check for urls
    for( $i = 2; $i <= 10; $i++ ) {
        switch( $type ) {
            case 'jpg':
                $photos[] = 'http://www.salondesign.luxury/v/vspfiles/photos/' . $sku . '-' . $i . '.jpg';
                //$photos[] = 'http://www.salondesign.luxury/v/vspfiles/photos/' . $sku . '-' . $i . 'S.jpg';
                //$photos[] = 'http://www.salondesign.luxury/v/vspfiles/photos/' . $sku . '-' . $i . 'T.jpg';
                break;

            case 'png':
                $photos[] = 'http://www.salondesign.luxury/v/vspfiles/photos/' . $sku . '-' . $i . '.png';
                //$photos[] = 'http://www.salondesign.luxury/v/vspfiles/photos/' . $sku . '-' . $i . 'S.png';
                //$photos[] = 'http://www.salondesign.luxury/v/vspfiles/photos/' . $sku . '-' . $i . 'T.png';
                break;

            default:
                break;
        }
    }
    //var_dump( $photos );

    $added = array();
    if( $photos ) {
        foreach( $photos as $photo ) {
            var_dump( 'Checking: ' . $photo );

            // Check headers only
            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $photo );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt( $ch, CURLOPT_HEADER, 1);
            curl_setopt( $ch, CURLOPT_NOBODY, 1 );
            $contents = curl_exec( $ch );
            $httpcode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
            var_dump( $httpcode );
            curl_close( $ch );

            if( $httpcode === 200 ) {
                //var_dump( $photo );

                $filename = basename( $photo );
                //var_dump( $filename );

                $uploaddir = wp_upload_dir();
                $uploadfile = $uploaddir['path'] . '/' . $filename;
                //var_dump( $uploadfile );

                // Get existing file ID
                if( file_exists( $uploadfile ) ) {
                    $post = get_page_by_title( $filename, OBJECT, 'attachment' );
                    //var_dump( $post );
                    if( !empty( $post ) ) {
                        $attach_id = $post->ID;
                        var_dump( $attach_id );
                    }

                // Add new file
                } else {
                    // Get content
                    $ch2 = curl_init();
                    curl_setopt( $ch2, CURLOPT_URL, $photo );
                    curl_setopt( $ch2, CURLOPT_HEADER, 0 );
                    curl_setopt( $ch2, CURLOPT_RETURNTRANSFER, 1 );
                    curl_setopt( $ch2, CURLOPT_BINARYTRANSFER, 1 );
                    $contents = curl_exec( $ch2 );
                    curl_close( $ch2 );

                    //$fp = fopen( $uploadfile, 'x' );
                    //fwrite( $fp, $contents );
                    //fclose( $fp );
                    file_put_contents( $uploadfile, $contents );

                    $wp_filetype = wp_check_filetype( basename( $filename ), null );
                    var_dump( $wp_filetype );

                    $attachment = array(
                        'post_mime_type' => $wp_filetype['type'],
                        'post_title'     => $filename,
                        'post_content'   => '',
                        'post_status'    => 'inherit'
                    );

                    $attach_id = wp_insert_attachment( $attachment, $uploadfile );
                    var_dump( $attach_id );

                    $imagenew = get_post( $attach_id );
                    var_dump( $imagenew );

                    $fullsizepath = get_attached_file( $imagenew->ID );
                    var_dump( $fullsizepath );

                    //$attach_data = wp_generate_attachment_metadata( $attach_id, $fullsizepath );
                    //var_dump( $attach_data );
                    //
                    //var_dump( wp_update_attachment_metadata( $attach_id, $attach_data ) );
                }

                $added[] = $attach_id;
            }
        }
    }

    return $added;
}

// Returns product id or false
function product_sku_exists( $sku ) {
    global $wpdb;
    $value = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_sku' AND meta_value = '%s'" , $sku ) );
    //var_dump( $wbdp->last_query );
    //var_dump( $value );
    if( $value )
        return $value;

    return FALSE;
}
