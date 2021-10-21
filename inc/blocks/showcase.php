<?php
  
  // Register a showcase block.

  acf_register_block( array(
      'name'            => 'showcase',
      'title'           => __( 'Showcase', 'mas' ),
      'description'     => __( 'A block that represents a list of featured items in a carousel slideshow.', 'mas' ),
      'render_callback' => 'mas_block_showcase_render_callback',
      'category'        => 'common',
      'icon'            => 'admin-comments',
      'keywords'        => array( 'showcase', 'feature', 'preview', 'tout' ),
      'example'  => array(
        'attributes' => array(
          'mode' => 'preview',
          'data' => array(
            'slides' => array(
              array(
                'title' => 'Item 1 title',
                'desc' => 'Item 1 description texts',
                'image' => array(
                  'sizes' => array(
                    'medium' => 'https://via.placeholder.com/350x250'
                  ),
                  'alt' => 'placeholder'
                )
              ),
              array(
                'title' => 'Item 2 title',
                'desc' => 'Item 2 description texts',
                'image' => array(
                  'sizes' => array(
                    'medium' => 'https://via.placeholder.com/350x250'
                  ),
                  'alt' => 'placeholder'
                )
              ),
              array(
                'title' => 'Item 3 title',
                'desc' => 'Item 3 description texts',
                'image' => array(
                  'sizes' => array(
                    'medium' => 'https://via.placeholder.com/350x250'
                  ),
                  'alt' => 'placeholder'
                )
              )
            )
          )
        )
      ),
      'enqueue_assets' => function(){
        wp_enqueue_script( 'splidejs', get_template_directory_uri() . '/assets/js/vendors/splide.min.js', array(), '', true );
        wp_enqueue_style( 'splidecss', get_template_directory_uri() . '/assets/css/vendors/splide/splide-core.min.css' );
        wp_enqueue_script( 'block-showcase-js', get_template_directory_uri() . '/assets/js/blocks/showcase.min.js', array('splidejs'), '', true );
        wp_enqueue_style( 'block-showcase', get_template_directory_uri() . '/assets/css/blocks/showcase.min.css' );
      },
  ) );

  /**
   *  This is the callback that displays the block.
   *
   * @param   array  $block      The block settings and attributes.
   * @param   string $content    The block content (emtpy string).
   * @param   bool   $is_preview True during AJAX preview.
   */
  function mas_block_showcase_render_callback( $block, $content = '', $is_preview = false ) {
    $context = Timber::context();

    $context['block'] = $block;
    $context['id'] = $block['id'];
    $context['type'] = 'showcase';
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;

    // Render the block.
    Timber::render( 'views/_patterns/blocks/showcase/showcase.twig', $context );


  }


?>