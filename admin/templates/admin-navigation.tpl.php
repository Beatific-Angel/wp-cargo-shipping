<?php
	$view = $_GET['page'];
?>
<h2 id="wpcargo-settings-nav" class="nav-tab-wrapper">
  <a class="nav-tab <?php echo ( $view == 'wpcargo-settings') ? 'nav-tab-active' : '' ;  ?>" href="<?php echo admin_url().'admin.php?page=wpcargo-settings'; ?>" ><?php echo wpcargo_general_settings_label(); ?></a>
  <a class="nav-tab <?php echo ( $view == 'wpcargo-email-settings') ? 'nav-tab-active' : '' ;  ?>" href="<?php echo admin_url().'admin.php?page=wpcargo-email-settings'; ?>" ><?php echo wpcargo_client_email_settings_label(); ?></a>
  <a class="nav-tab <?php echo ( $view == 'wpcargo-admin-email-settings') ? 'nav-tab-active' : '' ;  ?>" href="<?php echo admin_url().'admin.php?page=wpcargo-admin-email-settings'; ?>" ><?php echo wpcargo_admin_email_settings_label(); ?></a>
  <?php do_action('wpc_add_settings_nav'); ?>
</h2>