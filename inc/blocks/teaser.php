<?php
  
  // Register a Teaser block.

  acf_register_block( array(
      'name'            => 'teaser',
      'title'           => __( 'Teaser', 'mas' ),
      'description'     => __( 'A block that represents a sneak preview of certain post or page.', 'mas' ),
      'render_callback' => 'mas_block_teaser_render_callback',
      'category'        => 'common',
      'icon'            => 'admin-comments',
      'keywords'        => array( 'teaser', 'feature', 'preview', 'tout' ),
      'example'  => array(
        'attributes' => array(
          'mode' => 'preview',
          'data' => array(
            'title' => 'A Teaser Title',
            'desc' => 'Extra descriptive texts',
            'image' => array(
              'sizes' => array(
                'medium' => 'https://via.placeholder.com/350x250'
              )
            )
          )
        )
      ),
      'enqueue_assets' => function(){
        wp_enqueue_style( 'block-teaser', get_template_directory_uri() . '/assets/css/blocks/teaser.css' );
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
  function mas_block_teaser_render_callback( $block, $content = '', $is_preview = false ) {
    $context = Timber::context();

    $context['block'] = $block;
    $context['id'] = $block['id'];
    $context['type'] = 'teaser';
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;

    // Render the block.
    Timber::render( 'views/_patterns/blocks/teaser/teaser.twig', $context );


  }


?>