<?php
  
  // Register a Article block.

  acf_register_block( array(
      'name'            => 'featured',
      'title'           => __( 'Featured', 'mas' ),
      'description'     => __( 'A three box block for containing special mention items.', 'mas' ),
      'render_callback' => 'mas_block_featured_render_callback',
      'category'        => 'common',
      'icon'            => 'admin-comments',
      'keywords'        => array( 'feature', 'list' ),
      'example'  => array(
        'attributes' => array(
          'mode' => 'preview',
          'data' => array(
            'items' => array(
              array(
                'title' => 'Item 1 title',
                'desc' => 'Item 1 description texts',
                'image' => array(
                  'sizes' => array(
                    'medium' => 'https://via.placeholder.com/350x250'
                  )
                )
              ),
              array(
                'title' => 'Item 2 title',
                'desc' => 'Item 2 description texts',
                'image' => array(
                  'sizes' => array(
                    'medium' => 'https://via.placeholder.com/350x250'
                  )
                )
              ),
              array(
                'title' => 'Item 3 title',
                'desc' => 'Item 3 description texts',
                'image' => array(
                  'sizes' => array(
                    'medium' => 'https://via.placeholder.com/350x250'
                  )
                )
              )
            )
            
          )
        )
      ),
      'enqueue_assets' => function(){
        wp_enqueue_style( 'block-featured', get_template_directory_uri() . '/assets/css/blocks/featured.min.css' );
        //wp_enqueue_script( 'block-article', get_template_directory_uri() . '/template-parts/blocks/testimonial/testimonial.js', array('jquery'), '', true );
      },
  ) );

  /**
   *  This is the callback that displays the block.
   *
   * @param   array  $block      The block settings and attributes.
   * @param   string $content    The block content (emtpy string).
   * @param   bool   $is_preview True during AJAX preview.
   */
  function mas_block_featured_render_callback( $block, $content = '', $is_preview = false ) {
    $context = Timber::context();

    /*
    // Store block values.
    $context['block'] = $block;

    // Store field values.
    $context['fields'] = get_fields();

    // Store $is_preview value.
    $context['is_preview'] = $is_preview;
    */

    $context['block'] = $block;
    $context['id'] = $block['id'];
    $context['type'] = 'featured';
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;

    // Render the block.
    Timber::render( 'views/partials/blocks/featured/featured.twig', $context );


  }


?>