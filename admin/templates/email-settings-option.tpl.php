<form method="post" action="options.php" class="email-setting-admin-form" style="display: block;overflow: hidden;clear: both;">
 <?php
 settings_fields( 'wpcargo_mail_settings' );
 do_settings_sections( 'wpcargo_mail_settings' );
 ?>
 <div id="tags-wrapper" class="one-fourth first" style="background-color: #dbf5e0; padding: 6px;">
   <h3><?php esc_html_e('WPCargo Merge Tags','wpcargo'); ?></h3>
   <p class="description"><?php esc_html_e('Note: Use this tags for email setup to display shipment data.', 'wpcargo'); ?></p>
   <table id="email_meta_tags">
     <tr>
       <th><?php esc_html_e('Code', 'wpcargo'); ?></th>
       <th><?php esc_html_e('Label', 'wpcargo'); ?></th>
     </tr>
     <?php
       foreach ( $email_meta_tags as $key => $value ) {
         ?>
         <tr>
           <td><?php echo $key; ?></td>
           <td><?php echo $value; ?></td>
         </tr>
         <?php
       }
     ?>
   </table>
 </div> <!-- tags-wrapper -->
 <div id="form-fields-wrapper" class="three-fourths">
   <table class="form-table">
     <tbody>
       <tr>
         <th scope="row"><?php esc_html_e('Activate Client Email Notification?', 'wpcargo'); ?></th>
         <td><input type="checkbox" name="wpcargo_mail_settings[wpcargo_active_mail]" <?php checked(isset($options['wpcargo_active_mail']), 1); ?> value="1">
           <p class="description">
             <?php esc_html_e('Please check if you want to send email after updating the shipment.','wpcargo'); ?>
           </p>
 		     </td>
       </tr>
       <tr>
         <th scope="row">
            <?php esc_html_e('Select Shipment Status to send email Notification', 'wpcargo'); ?>
          </th>
         <td>
            <ul id="wpcargo_edit_history_role">
              <?php
              if( !empty( $wpcargo->status ) ){
                foreach ( $wpcargo->status as $status ) {
                  ?><li><input type="checkbox" name="wpcargo_mail_status[]" value="<?php echo $status; ?>" <?php echo ( in_array( $status, $mail_status) ) ? 'checked="checked"' : '' ; ?> /> <?php echo $status; ?></li><?php
                }
              }
              ?>
            </ul>
            <p class="description"><?php esc_html_e('Note: If no Shipment status is selected, Email Notify all types of shipment status', 'wpcargo'); ?></p>
         </td>
       </tr>
       <tr>
         <th scope="row"><?php esc_html_e('Domain Email', 'wpcargo'); ?>:</th>
         <td><input type="text" placeholder="info@wpcargo.com" name="wpcargo_mail_domain" value="<?php echo $wpcargo_mail_domain; ?>" >
           <p class="description">
             <?php esc_html_e('Edit this if you want to change the header of your email automation. Default will be','wpcargo'); ?> <?php echo get_option('admin_email'); ?>
           </p></td>
       </tr>
       <tr>
         <th scope="row"><?php esc_html_e('Mail To', 'wpcargo'); ?>:</th>
         <td><input type="text" name="wpcargo_mail_settings[wpcargo_mail_to]" placeholder="{shipper_email}, {receiver_email}, {admin_email}" value="<?php echo !empty($options['wpcargo_mail_to']) ? $options['wpcargo_mail_to'] : ''; ?>">
           <p class="description"><?php esc_html_e('Add emails with comma separated.(You can add WPCargo Merge Tags)<br>
             sample_1@mail.com, @sample_2@mail.com', 'wpcargo'); ?></p></td>
       </tr>
       <tr>
         <th scope="row"><?php esc_html_e('Cc', 'wpcargo'); ?>:</th>
         <td><input type="text" name="wpcargo_email_cc" placeholder="Cc" value="<?php echo get_option('wpcargo_email_cc'); ?>">
           <p class="description"><?php esc_html_e('Add emails with comma separated. ( sample_1@mail.com, @sample_2@mail.com )','wpcargo'); ?></p></td>
       </tr>
       <tr>
         <th scope="row"><?php esc_html_e('Bcc', 'wpcargo'); ?>:</th>
         <td><input type="text" name="wpcargo_email_bcc" placeholder="Bcc" value="<?php echo get_option('wpcargo_email_bcc'); ?>">
           <p class="description"><?php esc_html_e('Add emails with comma separated. ( sample_1@mail.com, @sample_2@mail.com )','wpcargo'); ?> </p></td>
       </tr>
       <tr>
         <th scope="row"><?php esc_html_e('Subject:','wpcargo'); ?></th>
         <td><input type="text" name="wpcargo_mail_settings[wpcargo_mail_subject]" value="<?php echo !empty($options['wpcargo_mail_subject']) ? $options['wpcargo_mail_subject'] : ''; ?>">
           <p class="description">
             <?php esc_html_e('Email Subject','wpcargo'); ?>
           </p>
 		</td>
       </tr>
       <tr>
         <th scope="row"><?php esc_html_e('Message Content:','wpcargo'); ?></th>
         <td><textarea cols="40" rows="12" placeholder='<p>Dear {shipper_name},</p>
 		<p>We are pleased to inform you that your shipment has now cleared customs and is now {status}.</p>
 		<br />
 		<h4 style="font-size: 25px; color: #00a924;">Tracking Information</h4>
 		<p>Tracking Number - {wpcargo_tracking_number}</p>
 		<p>Latest International Scan: Customs status updated</p>
 		<p>We hope this meets with your approval. Please do not hesitate to get in touch if we can be of any further assistance.</p>
 		<br />
 		<p>Yours sincerely</p>
 		<p><a href="{site_url}">{site_name}</a></p>' name='wpcargo_mail_settings[wpcargo_mail_message]'><?php echo !empty($options['wpcargo_mail_message']) ? $options['wpcargo_mail_message'] : ''; ?></textarea></td>
       </tr>
       <tr>
         <th scope="row"><?php esc_html_e('Footer:','wpcargo'); ?></th>
         <td><textarea cols="40" rows="12" placeholder='
 		<div class="wpc-contact-info" style="margin-top: 10px;">
 			<p>Your Address Here...</p>
 			<p>Email: <a href="mailto:{admin_email}">{admin_email}</a> - Web: <a href="{site_url}">{site_name}</a></p>
 			<p>Phone: <a href="tel:">Your Phone Number Here</a>, <a href="tel:">Your Phone Number Here</a></p>
 		</div>
 		<div class="wpc-contact-bottom" style="margin-top: 20px; padding: 5px; border-top: 1px solid #000;">
 			<p>This message is intended solely for the use of the individual or organisation to whom it is addressed. It may contain privileged or confidential information. If you have received this message in error, please notify the originator immediately. If you are not the intended recipient, you should not use, copy, alter or disclose the contents of this message. All information or opinions expressed in this message and/or any attachments are those of the author and are not necessarily those of {site_name} or its affiliates. {site_name} accepts no responsibility for loss or damage arising from its use, including damage from virus.</p>
 		</div>' name='wpcargo_mail_settings[wpcargo_mail_footer]'><?php echo !empty($options['wpcargo_mail_footer']) ? $options['wpcargo_mail_footer'] : ''; ?></textarea></td>
       </tr>
 	  <tr>
 	  	<td><a href="http://www.wpcargo.com/email-settings/#wpc-email-output" target="_blank"><?php esc_html_e('View sample email output', 'wpcargo'); ?></a></td>
 	  </tr>
     </tbody>
   </table>
   <?php submit_button(); ?>
 </div><!-- #form-fields-wrapper -->
</form>