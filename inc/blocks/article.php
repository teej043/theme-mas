<?php
  
  // Register a Article block.

  acf_register_block( array(
      'name'            => 'article',
      'title'           => __( 'Article', 'mas' ),
      'description'     => __( 'A rich texts (wysiwyg) article block.', 'mas' ),
      'render_callback' => 'mas_block_article_render_callback',
      'category'        => 'common',
      'icon'            => 'admin-comments',
      'keywords'        => array( 'article', 'texts', 'rte', 'wysiwyg' ),
      'example'  => array(
        'attributes' => array(
          'mode' => 'preview',
          'data' => array(
            'content'   => 'Example content text here',
            'is_preview'    => true
          )
        )
      ),
      'enqueue_assets' => function(){
        wp_enqueue_style( 'block-article', get_template_directory_uri() . '/assets/css/blocks/article.css' );
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
  function mas_block_article_render_callback( $block, $content = '', $is_preview = false ) {
    $context = Timber::context();

    $context['block'] = $block;
    $context['id'] = $block['id'];
    $context['type'] = 'article';
    $context['fields'] = get_fields();
    $context['is_preview'] = $is_preview;

   

    // Render the block.
    Timber::render( 'views/_patterns/blocks/article/article.twig', $context );


  }


?>