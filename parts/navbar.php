<?php
$menu_items = wp_get_nav_menu_items('Navigation');
?>
<nav class="navbar" id="navbar">
  <div>
    <a href="<?php echo home_url() ?>">
      <div class="logo"><span class="-mb-3">authentische</span><br><span>Momente</span></div>
    </a>
  </div>

  <div class="nav-right">
    <button id="shootings-btn-nav" data-is-toggled="false">
      shootings
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="nav__submenu-toggle-icon">
        <path d="M12 17L19 8H5L12 17Z" fill="currentColor"></path>
      </svg>
    </button>

    <div class="hamburger" id="navbar-toggle">
      <div></div>
      <div></div>
      <div></div>
    </div>

    <ul
      class="navigation"
      id="navbar-links"
      data-is-toggled="false">
      <?php foreach ($menu_items as $item) {
        if ($item->post_title === 'home') {
          continue;
        } ?>
        <li>
          <a href="<?php echo $item->url; ?>"><?php echo $item->post_title; ?></a>
        </li>
      <?php } ?>
    </ul>
  </div>
</nav>