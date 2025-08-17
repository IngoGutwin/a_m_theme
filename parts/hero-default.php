<?php
$hero_section = $args;

?>
<!-- hero section start -->
<section
  class="hero"
  id="hero-section">

  <picture>
    <source media="(min-width:465px)" type="image/jpeg" srcset="<?php echo esc_html($hero_section['images']['hero_bg_image_sm'] . ' 558w'); ?>">
    <source media="(max-width:465px)" srcset="<?php echo esc_html($hero_section['images']['hero_bg_image_xl'] . ' 1448w'); ?>">
    <img srcset="<?php echo esc_html(implode(', ', [$hero_section['images']['hero_bg_image_sm'] . ' 558w', $hero_section['images']['hero_bg_image_xl'] . ' 1448w'])); ?>" src="<?php echo esc_html($hero_section['images']['hero_bg_image_xl']); ?>" alt="Schwangere Shooting in Bonn" />
  </picture>


  <button class="book-appointment-btn" id="hero-btn-appointment"><?php echo esc_html($hero_section['hero_button_text']) ?? '' ?></button>
  <h1><?php echo esc_html($hero_section['hero_title']) ?? '' ?></h1>
  <div class="hero-intro">
    <?php echo $hero_section['hero_sub_title'] ?? '' ?>
  </div>

</section>
<!-- hero section end -->