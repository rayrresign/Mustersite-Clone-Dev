<?php
/**
 * The template for displaying 404 pages (Not Found).
 */

get_header(); ?>

<div id="primary" class="content-area container">
  <main id="main" class="site-main" role="main">
    <section class="error-404 not-found">
      <div class="row">
        <div class="col-xs-12 col-md-12 text-center">
          <div class="page-header" style="border-bottom: 0px">
            <p class="well-md"> <i class="fa fa-paper-plane-o fa-4x"></i> </p>
            <h3 class="page-title">
              <?php _e( 'Die Seite wurde leider nicht gefunden...', 'musterpage-v8' ); ?>
            </h3>
            <p>
              <?php bloginfo( 'name' ); ?>
            </p>
            <ul class="breadcrumb breadcrumb-light breadcrumb-divider-middot">
              <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">zur Startseite</a> </li>
            </ul>
          </div>
        </div>
      </div>
      

    </section>
  </main>
</div>
<?php get_footer(); ?>
