<?php
  
  // Register a Article block.

  acf_register_block( array(
      'name'            => 'hero',
      'title'           => __( 'Hero', 'mas' ),
      'description'     => __( 'A wide block that is usually the used as the top most module for everyone to see.', 'mas' ),
      'render_callback' => 'mas_block_hero_render_callback',
      'category'        => 'common',
      'icon'            => 'admin-comments',
      'keywords'        => array( 'hero', 'banner', 'top', 'above' ),
      'example'  => array(
        'attributes' => array(
          'mode' => 'preview',
          'data' => array(
            'items' => array(
              'title' => 'A Hero Title',
              'desc' => 'Extra descriptive texts',
              'image' => null
            )
          )
        )
      ),
      'enqueue_assets' => function(){
        wp_enqueue_style( 'block-hero', get_template_directory_uri() . '/assets/css/blocks/hero.css' );
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
  function mas_block_hero_render_callback( $block, $content = '', $is_preview = false ) {
    $context = Timber::context();

    $context['block'] = $block;
    $context['id'] = $block['id'];
    $context['type'] = 'hero';
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;

    // Render the block.
    Timber::render( 'views/_patterns/blocks/hero/hero.twig', $context );


  }


?>