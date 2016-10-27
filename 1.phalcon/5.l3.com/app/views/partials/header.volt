<!-- Button call sidebar -->
<div class="longliulo header">
  <div class="longliulo sticky">
    <button on='tap:longliulo-menu-sidebar'>
      <i class="fa fa-bars" aria-hidden="true"></i> Menu
    </button>
  </div>
</div>

<!-- Menu Siderbar -->
<amp-sidebar id='longliulo-menu-sidebar'  side="left" layout='nodisplay'>
  <div>
    <ul class="menu-list">
        <li><a href="/">L3</a></li>
        <li>Contact</li>
        <li><button on='tap:longliulo-menu-sidebar.close'><i class="fa fa-reply" aria-hidden="true"></i></button></li>
    </ul>
  </div>
</amp-sidebar>
