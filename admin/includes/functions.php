<?php
if (!defined('ABSPATH')){
    exit; // Exit if accessed directly
}
function wpcargo_include_template( $file_name, $shipment ){
    $custom_template_path   = get_stylesheet_directory().'/wpcargo/'.$file_name.'.php';
    if( file_exists( $custom_template_path ) ){
        $template_path = $custom_template_path;
    }else{
        $template_path  = WPCARGO_PLUGIN_PATH.'templates/'.$file_name.'.php';
    }
    include_once( $template_path ); 
}
function wpcargo_admin_include_template( $file_name, $shipment ){
    $custom_template_path   = get_stylesheet_directory().'/wpcargo/admin/'.$file_name.'.php';
    if( file_exists( $custom_template_path ) ){
        $template_path = $custom_template_path;
    }else{
        $template_path  = WPCARGO_PLUGIN_PATH.'admin/templates/'.$file_name.'.php';
    }
    include_once( $template_path ); 
}
function wpcargo_trackform_shipment_number( $shipment_number ) {
    global $wpdb;
    $shipment_number = esc_sql( $shipment_number );
    $sql = apply_filters( 'wpcargo_trackform_shipment_number_query', "SELECT `ID` FROM `{$wpdb->prefix}posts` WHERE post_title = '{$shipment_number}' AND `post_status` = 'publish' AND `post_type` = 'wpcargo_shipment' LIMIT 1", $shipment_number );
    $results = $wpdb->get_var($sql);
    return $results;
}
function wpcargo_get_postmeta( $post_id = '' , $metakey = '', $type = '' ){
	global $wpcargo;
    $result = '';
    if( !empty( $post_id ) && !empty( $metakey ) ){
        $result                    = maybe_unserialize( get_post_meta( $post_id, $metakey, true) );
        if( is_array( $result ) ){
            $result = array_filter( array_map( 'trim', $result ) );
            if( !empty( $result ) ){
                $result = implode(', ',$result);
            } 
            if( $type == 'url' ){
                $url_data = array_values( maybe_unserialize( get_post_meta( $post_id, $metakey, true) ) );
                $target   = count( $url_data ) > 2 ? '_blank' : '' ;
                $url      = $url_data[1] ? $url_data[1] : '#' ;
                $label    = $url_data[0];
                $result   = '<a href="'.$url.'" target="'.$target.'">'.$label.'</a>';
            }       
        }
    }
    return $result;
}
function wpcargo_to_slug( $string = '' ){
    $string = strtolower( preg_replace('/\s+/', '_', trim( $string ) ) );
    return substr( preg_replace('/[^A-Za-z0-9_\-]/', '', $string ), 0, 60 );
}
function wpcargo_html_value( $string, $htmltag = 'span', $attr = 'class' ){
    $string    = trim( $string );
    $attrvalue = strtolower( str_replace(" ", '-', $string ) );
    $attrvalue = preg_replace("/[^A-Za-z0-9 -]/", '', $attrvalue);
    return '<'.$htmltag.' '.$attr.' ="'.$attrvalue.'" >'.$string.'</'.$htmltag.'>';
}
function wpcargo_user_roles_list(){
    $wpcargo_user_roles_list = apply_filters( 'wpcargo_user_roles_list', array(
        'administrator', 'wpc_shipment_manager', 'wpcargo_branch_manager', 'wpcargo_driver', 'wpcargo_client', 'cargo_agent'
    ) );
    return $wpcargo_user_roles_list;
}
function wpcargo_has_registered_shipper(){
    global $wpdb;
    $sql = "SELECT tbl2.meta_value FROM `{$wpdb->prefix}posts` AS tbl1 INNER JOIN `{$wpdb->prefix}postmeta` AS tbl2 ON tbl1.ID = tbl2.post_id WHERE tbl1.post_status LIKE 'publish' AND tbl1.post_type LIKE 'wpcargo_shipment' AND tbl2.meta_key LIKE 'registered_shipper' AND ( tbl2.meta_value IS NOT NULL AND tbl2.meta_value <> '' ) GROUP BY tbl2.meta_value";
    $result = $wpdb->get_col($sql);
    return $result;
}
function wpcargo_email_shortcodes_list(){
    $tags = array(
        '{wpcargo_tracking_number}' => esc_html__('Tracking Number','wpcargo'),
        '{wpcargo_shipper_email}'   => esc_html__('Shipper Email','wpcargo'),
        '{wpcargo_receiver_email}'  => esc_html__('Receiver Email','wpcargo'),
        '{wpcargo_shipper_phone}'   => esc_html__('Shipper Phone','wpcargo'),
        '{wpcargo_receiver_phone}'  => esc_html__('Receiver Phone','wpcargo'),
        '{admin_email}'             => esc_html__('Admin Email','wpcargo'),
        '{wpcargo_shipper_name}'    => esc_html__('Name of the Shipper','wpcargo'),
        '{wpcargo_receiver_name}'   => esc_html__('Name of the Receiver','wpcargo'),
        '{status}'                  => esc_html__('Shipment Status','wpcargo'),
        '{site_name}'               => esc_html__('Website Name','wpcargo'),
        '{site_url}'                => esc_html__('Website URL','wpcargo'),
    );
    $tags   = apply_filters( 'wpc_email_meta_tags', $tags );
    return $tags;
}
function wpcargo_defualt_status(){
    $status = array(
        esc_html__( 'Pending', 'wpcargo' ),
        esc_html__( 'Picked up', 'wpcargo' ),
        esc_html__( 'On Hold', 'wpcargo' ),
        esc_html__( 'Out for delivery', 'wpcargo' ),
        esc_html__( 'In Transit', 'wpcargo' ),
        esc_html__( 'Enroute', 'wpcargo' ),
        esc_html__( 'Cancelled', 'wpcargo' ),
        esc_html__( 'Delivered', 'wpcargo' ),
        esc_html__( 'Returned', 'wpcargo' )
    );
    return apply_filters( 'wpcargo_defualt_status', $status );
}
function wpcargo_field_generator( $field_data, $field_meta, $value = '', $class='' ){
	$required = $field_data['required'] == 'true' ? 'required' : '';
	if( $field_data['field'] == 'textarea' ){
		$field = '<textarea class="'.$class.'" name="'.$field_meta.'" '.$required.'>'.$value.'</textarea>';
	}elseif( $field_data['field'] == 'select' ){
		$field = '<select class="'.$class.'" name="'.$field_meta.'" '.$required.'>';
		$field .= '<option value="">'.esc_html__('-- Select Type --','wpcargo').'</option>';
		if( !empty( $field_data['options'] ) ){
			foreach ( $field_data['options'] as $_value) {
				$field .= '<option value="'.trim($_value).'" '.selected( $value, trim($_value), false ).'>'.trim($_value).'</option>';
			}
		}
		$field .= '</select>';
	}elseif( $field_data['field'] == 'radio' ){
		if( !empty( $field_data['options'] ) ){
			$field = '';
			foreach ( $field_data['options'] as $_value) {
				$field .= '<p><input class="'.$class.'" id="'.$field_meta.'_'.$_value.'" type="'.$field_data['field'].'" name="'.$field_meta.'" value="'.$_value.'" '.$required.'>';
				$field .= '<label for="'.$field_meta.'_'.$_value.'">'.$_value.'</label></p>';
			}
		}
	}elseif( $field_data['field'] == 'checkbox' ){
		if( !empty( $field_data['options'] ) ){
			$field = '';
			foreach ( $field_data['options'] as $_value) {
				$field .= '<p><input class="'.$class.'" id="'.$field_meta.'_'.$_value.'" type="'.$field_data['field'].'" name="'.$field_meta.'[]" value="'.$_value.'" '.$required.'>';
				$field .= '<label for="'.$field_meta.'_'.$_value.'">'.$_value.'</label></p>';
			}
		}
	}else{
		$field = '<input class="'.$class.'" type="'.$field_data['field'].'" name="'.$field_meta.'" value="'.$value.'" '.$required.'>';
	}
	return $field;
}
function wpcargo_email_replace_shortcodes_list( $post_id ){
    $delimiter = array("{", "}");
    $replace_shortcodes = array();
    if( !empty( wpcargo_email_shortcodes_list() ) ){
        foreach ( wpcargo_email_shortcodes_list() as $shortcode => $shortcode_label ) {
            $shortcode = trim( str_replace( $delimiter, '', $shortcode ) );
            if( $shortcode == 'wpcargo_tracking_number' ){
                $replace_shortcodes[] = get_the_title($post_id);
            }elseif( $shortcode == 'admin_email' ){
                $replace_shortcodes[] = apply_filters( 'wpcargo_admin_notification_email_address', get_option('admin_email') );
            }elseif( $shortcode == 'site_name' ){
                $replace_shortcodes[] = get_bloginfo('name');
            }elseif( $shortcode == 'site_url' ){
                $replace_shortcodes[] = get_bloginfo('url');
            }elseif( $shortcode == 'status' ){
                $replace_shortcodes[] = get_post_meta( $post_id, 'wpcargo_status', true );
            }else{
                $meta_value = maybe_unserialize( get_post_meta( $post_id, $shortcode, true ) );
                if( is_array( $meta_value ) ){
                    $meta_value = implode(', ',$meta_value );
                }
                $replace_shortcodes[] = $meta_value;
            }
        }
    }
    return $replace_shortcodes;
}  
function wpcargo_shipper_meta_filter(){
    return apply_filters( 'wpcargo_shipper_meta_filter', 'wpcargo_shipper_name');
} 
function wpcargo_shipper_label_filter(){
    return apply_filters( 'wpcargo_shipper_label_filter', esc_html__('Shipper Name', 'wpcargo' ) );
} 
function wpcargo_receiver_meta_filter(){
    return apply_filters( 'wpcargo_receiver_meta_filter', 'wpcargo_receiver_name' );
} 
function wpcargo_receiver_label_filter(){
    return apply_filters( 'wpcargo_receiver_label_filter', esc_html__('Receiver Name', 'wpcargo' ) );
} 
function wpcargo_default_client_email_body(){
    ob_start();
    ?>
    <p>Dear {wpcargo_shipper_name},</p>
    <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">We are pleased to inform you that your shipment has now cleared customs and is now {status}.</p>
    <br />
    <h4 style="font-size: 1.2em;">Tracking Information</h4>
    <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">Tracking Number - {wpcargo_tracking_number}</p>
    <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">Latest International Scan: Customs status updated</p>
    <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">We hope this meets with your approval. Please do not hesitate to get in touch if we can be of any further assistance.</p>
    <br />
    <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">Yours sincerely</p>
    <p style="font-size: 1em;margin:.5em 0px;line-height: initial;"><a href="{site_url}">{site_name}</a></p>
    <?php
    $output = ob_get_clean();
    return $output;
}
function wpcargo_default_admin_email_body(){
    ob_start();
    ?>
    <p>Dear Admin,</p>
    <p>Shipment number {wpcargo_tracking_number} has been updated to {status}.</p>
    <br />
    <p>Yours sincerely</p>
    <p><a href="{site_url}">{site_name}</a></p>
    <?php
    $output = ob_get_clean();
    return $output;
}
function wpcargo_default_email_footer(){
    ob_start();
    ?>
    <div class="wpc-contact-info" style="margin-top: 10px;">
        <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">Your Address Here...</p>
        <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">Email: <a href="mailto:{admin_email}">{admin_email}</a> - Web: <a href="{site_url}">{site_name}</a></p>
        <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">Phone: <a href="tel:">Your Phone Number Here</a>, <a href="tel:">Your Phone Number Here</a></p>
    </div>
    <div class="wpc-contact-bottom" style="margin-top: 2em; padding: 1em; border-top: 1px solid #000;">
        <p style="font-size: 1em;margin:.5em 0px;line-height: initial;">This message is intended solely for the use of the individual or organisation to whom it is addressed. It may contain privileged or confidential information. If you have received this message in error, please notify the originator immediately. If you are not the intended recipient, you should not use, copy, alter or disclose the contents of this message. All information or opinions expressed in this message and/or any attachments are those of the author and are not necessarily those of {site_name} or its affiliates. {site_name} accepts no responsibility for loss or damage arising from its use, including damage from virus.</p>
    </div>
    <?php
    $output = ob_get_clean();
    return $output;
}
function wpcargo_email_body_container( $email_body = '', $email_footer = '' ){
    global $wpcargo;
    $default_logo       = WPCARGO_PLUGIN_URL.'admin/assets/images/wpcargo-logo-email.png';
    $brand_logo         = !empty( $wpcargo->logo ) ? $wpcargo->logo : $default_logo;
    ob_start();
    ?>
    <div class="wpc-email-notification-wrap" style="width: 100%; font-family: sans-serif;">
        <div class="wpc-email-notification" style="padding: 3em; background: #efefef;">
            <div class="wpc-email-template" style="background: #fff; width: 95%; margin: 0 auto;">
                <div class="wpc-email-notification-logo" style="padding: 2em 2em 0px 2em;">
                    <table width="100%" style="max-width:210px;"><tr><td><img src="<?php echo $brand_logo; ?>" width="100%"/></td></tr></table>
                </div>
                <div class="wpc-email-notification-content" style="padding: 2em 2em 1em 2em; font-size: 18px;">
                    <?php echo $email_body; ?>
                </div>
                <div class="wpc-email-notification-footer" style="font-size: 10px; text-align: center; margin: 0 auto;">
                    <?php do_action( 'wpcargo_email_footer_divider' ); ?>
                    <?php echo $email_footer; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    $output = ob_get_clean();
    return $output;
}
function wpcargo_send_email_notificatio( $post_id, $status = '' ){
    wpcargo_client_mail_notification( $post_id, $status );
    wpcargo_admin_mail_notification( $post_id, $status );
}
function wpcargo_client_mail_notification( $post_id, $status = '' ){
    global $wpcargo;
    $wpcargo_mail_domain = !empty( trim( get_option('wpcargo_mail_domain') ) ) ? get_option('wpcargo_mail_domain') : get_option( 'admin_email' ) ;
    if ( $wpcargo->client_mail_active ) {
        $old_status     = get_post_meta($post_id, 'wpcargo_status', true);
        $str_find       = array_keys( wpcargo_email_shortcodes_list() );
        $str_replce     = wpcargo_email_replace_shortcodes_list( $post_id );
        $mail_content   = $wpcargo->client_mail_body;
        $mail_footer    = $wpcargo->client_mail_footer;
        $headers        = array();
        $headers[]      = 'From: ' . get_bloginfo('name') .' <'.$wpcargo_mail_domain.'>';
        if( $wpcargo->mail_cc ){
            $headers[]      = 'cc: '.str_replace($str_find, $str_replce, $wpcargo->mail_cc )."\r\n";
        }
        if( $wpcargo->mail_bcc ){
            $headers[]      = 'Bcc: '.str_replace($str_find, $str_replce, $wpcargo->mail_bcc )."\r\n";
        }
        $subject        = str_replace($str_find, $str_replce, $wpcargo->client_mail_subject );
        $send_to        = str_replace($str_find, $str_replce, $wpcargo->client_mail_to );
        $message        = str_replace($str_find, $str_replce, wpcargo_email_body_container( $mail_content, $mail_footer ) );     
        if( empty( $wpcargo->mail_status ) ){
            wp_mail( $send_to, $subject, $message, $headers );
        }elseif( !empty( $wpcargo->mail_status ) && in_array( $status, $wpcargo->mail_status) ){
            wp_mail( $send_to, $subject, $message, $headers );
        }   
    }
}
function wpcargo_admin_mail_notification( $post_id, $status = ''){
    global $wpcargo;
    $wpcargo_mail_domain = !empty( trim( get_option('wpcargo_admin_mail_domain') ) ) ? get_option('wpcargo_admin_mail_domain') : get_option( 'admin_email' ) ;
    if ( $wpcargo->admin_mail_active ) {
        $str_find       = array_keys( wpcargo_email_shortcodes_list() );
        $str_replce     = wpcargo_email_replace_shortcodes_list( $post_id );
        $mail_content   = $wpcargo->admin_mail_body;
        $mail_footer    = $wpcargo->admin_mail_footer;
        $headers        = array();
        $headers[]      = 'From: ' . get_bloginfo('name') .' <'.$wpcargo_mail_domain.'>';
        $subject        = str_replace($str_find, $str_replce, $wpcargo->admin_mail_subject );
        $send_to        = str_replace($str_find, $str_replce, $wpcargo->admin_mail_to );
        $message        = str_replace($str_find, $str_replce, wpcargo_email_body_container( $mail_content, $mail_footer ) );      
        if( empty( $wpcargo->admin_mail_status ) ){
            wp_mail( $send_to, $subject, $message, $headers );
        }elseif( !empty( $wpcargo->admin_mail_status ) && in_array( $status, $wpcargo->admin_mail_status) ){
            wp_mail( $send_to, $subject, $message, $headers );
        }   
    }
}
function wpcargo_pagination( $args = array() ) {    
    $defaults = array(
        'range'           => 4,
        'custom_query'    => FALSE,
        'previous_string' => esc_html__( 'Previous', 'wpcargo' ),
        'next_string'     => esc_html__( 'Next', 'wpcargo' ),
        'before_output'   => '<div id="wpcargo-pagination-wrapper"><nav class="wpcargo-pagination post-nav" aria-label="'.esc_html__('Shipments', 'wpcargo').'"><ul class="wpcargo-pagination pg-blue justify-content-center">',
        'after_output'    => '</ul></nav</div>'
    );    
    $args = wp_parse_args( 
        $args, 
        apply_filters( 'wpcargo_pagination_defaults', $defaults )
    );    
    $args['range'] = (int) $args['range'] - 1;
    if ( !$args['custom_query'] )
        $args['custom_query'] = @$GLOBALS['wp_query'];
    $count = (int) $args['custom_query']->max_num_pages;
    $page  = intval( get_query_var( 'paged' ) );
    $ceil  = ceil( $args['range'] / 2 );    
    if ( $count <= 1 )
        return FALSE;    
    if ( !$page )
        $page = 1;    
    if ( $count > $args['range'] ) {
        if ( $page <= $args['range'] ) {
            $min = 1;
            $max = $args['range'] + 1;
        } elseif ( $page >= ($count - $ceil) ) {
            $min = $count - $args['range'];
            $max = $count;
        } elseif ( $page >= $args['range'] && $page < ($count - $ceil) ) {
            $min = $page - $ceil;
            $max = $page + $ceil;
        }
    } else {
        $min = 1;
        $max = $count;
    }    
    $echo = '';
    $previous = intval($page) - 1;
    $previous = esc_attr( get_pagenum_link($previous) );    
    $firstpage = esc_attr( get_pagenum_link(1) );
    if ( $firstpage && (1 != $page) )
        $echo .= '<li class="previous wpcargo-page-item"><a class="wpcargo-page-link waves-effect waves-effect" href="' . $firstpage . '">' . esc_html__( 'First', 'wpcargo' ) . '</a></li>';
    if ( $previous && (1 != $page) )
        $echo .= '<li class="wpcargo-page-item" ><a class="wpcargo-page-link waves-effect waves-effect" href="' . $previous . '" title="' . esc_html__( 'previous', 'wpcargo') . '">' . $args['previous_string'] . '</a></li>';    
    if ( !empty($min) && !empty($max) ) {
        for( $i = $min; $i <= $max; $i++ ) {
            if ($page == $i) {
                $echo .= '<li class="wpcargo-page-item active"><span class="wpcargo-page-link waves-effect waves-effect">' . str_pad( (int)$i, 2, '0', STR_PAD_LEFT ) . '</span></li>';
            } else {
                $echo .= sprintf( '<li class="wpcargo-page-item"><a class="wpcargo-page-link waves-effect waves-effect" href="%s">%002d</a></li>', esc_attr( get_pagenum_link($i) ), $i );
            }
        }
    }    
    $next = intval($page) + 1;
    $next = esc_attr( get_pagenum_link($next) );
    if ($next && ($count != $page) )
        $echo .= '<li class="wpcargo-page-item"><a class="wpcargo-page-link waves-effect waves-effect" href="' . $next . '" title="' . esc_html__( 'next', 'wpcargo') . '">' . $args['next_string'] . '</a></li>';    
    $lastpage = esc_attr( get_pagenum_link($count) );
    if ( $lastpage ) {
        $echo .= '<li class="next wpcargo-page-item"><a class="wpcargo-page-link waves-effect waves-effect" href="' . $lastpage . '">' . esc_html__( 'Last', 'wpcargo' ) . '</a></li>';
    }
    if ( isset($echo) ){
        echo $args['before_output'] . $echo . $args['after_output'];
    }
}
if( !function_exists( 'wpcargo_country_list' )){
    function wpcargo_country_list(){
        return "Afghanistan, Albania, Algeria, American Samoa, Andorra, Angola, Anguilla, Antigua & Barbuda, Argentina, Armenia, Aruba, Australia, Austria, Azerbaijan, Bahamas, The, Bahrain, Bangladesh, Barbados, Belarus, Belgium, Belize, Benin, Bermuda, Bhutan, Bolivia, Bosnia & Herzegovina, Botswana, Brazil, British Virgin Is., Brunei, Bulgaria, Burkina Faso, Burma, Burundi, Cambodia, Cameroon, Canada, Cape Verde, Cayman Islands, Central African Rep., Chad, Chile, China, Colombia, Comoros, Congo, Dem. Rep., Congo, Repub. of the, Cook Islands, Costa Rica, Cote d'Ivoire, Croatia, Cuba, Cyprus, Czech Republic, Denmark, Djibouti, Dominica, Dominican Republic, East Timor, Ecuador, Egypt, El Salvador, Equatorial Guinea, Eritrea, Estonia, Ethiopia, Faroe Islands, Fiji, Finland, France, French Guiana, French Polynesia, Gabon, Gambia, The, Gaza Strip, Georgia, Germany, Ghana, Gibraltar, Greece, Greenland, Grenada, Guadeloupe, Guam, Guatemala, Guernsey, Guinea, Guinea-Bissau, Guyana, Haiti, Honduras, Hong Kong, Hungary, Iceland, India, Indonesia, Iran, Iraq, Ireland, Isle of Man, Israel, Italy, Jamaica, Japan, Jersey, Jordan, Kazakhstan, Kenya, Kiribati, Korea, North, Korea, South, Kuwait, Kyrgyzstan, Laos, Latvia, Lebanon, Lesotho, Liberia, Libya, Liechtenstein, Lithuania, Luxembourg, Macau, Macedonia, Madagascar, Malawi, Malaysia, Maldives, Mali, Malta, Marshall Islands, Martinique, Mauritania, Mauritius, Mayotte, Mexico, Micronesia, Fed. St., Moldova, Monaco, Mongolia, Montserrat, Morocco, Mozambique, Namibia, Nauru, Nepal, Netherlands, Netherlands Antilles, New Caledonia, New Zealand, Nicaragua, Niger, Nigeria, N. Mariana Islands, Norway, Oman, Pakistan, Palau, Panama, Papua New Guinea, Paraguay, Peru, Philippines, Poland, Portugal, Puerto Rico, Qatar, Reunion, Romania, Russia, Rwanda, Saint Helena, Saint Kitts & Nevis, Saint Lucia, St Pierre & Miquelon, Saint Vincent and the Grenadines, Samoa, San Marino, Sao Tome & Principe, Saudi Arabia, Senegal, Serbia, Seychelles, Sierra Leone, Singapore, Slovakia, Slovenia, Solomon Islands, Somalia, South Africa, Spain, Sri Lanka, Sudan, Suriname, Swaziland, Sweden, Switzerland, Syria, Taiwan, Tajikistan, Tanzania, Thailand, Togo, Tonga, Trinidad & Tobago, Tunisia, Turkey, Turkmenistan, Turks & Caicos Is, Tuvalu, Uganda, Ukraine, United Arab Emirates, United Kingdom, United States, Uruguay, Uzbekistan, Vanuatu, Venezuela, Vietnam, Virgin Islands, Wallis and Futuna, West Bank, Western Sahara, Yemen, Zambia, Zimbabwe";
    }
}
function wpcargo_map_script( $callback ){
	$shmap_api = get_option('shmap_api');
	return '<script async defer src="https://maps.googleapis.com/maps/api/js?libraries=geometry,places,visualization&key='.$shmap_api.'&callback='.$callback.'"></script>';
}
function wpcargo_brand_name(){
	return apply_filters('wpcargo_brand_name', esc_html__('WPCargo', 'wpcargo' ) );
}
function wpcargo_general_settings_label(){
	return apply_filters('wpcargo_general_settings_label', esc_html__('General Settings', 'wpcargo' ) );
}
function wpcargo_client_email_settings_label(){
	return apply_filters('wpcargo_email_settings_label', esc_html__('Client Email Settings', 'wpcargo' ) );
}
function wpcargo_admin_email_settings_label(){
    return apply_filters('wpcargo_admin_email_settings_label', esc_html__('Admin Email Settings', 'wpcargo' ) );
}
function wpcargo_shipment_settings_label(){
	return apply_filters('wpcargo_shipment_settings_label', esc_html__('Shipment Settings', 'wpcargo' ) );
}
function wpcargo_report_settings_label(){
	return apply_filters('wpcargo_report_settings_label', esc_html__('Reports', 'wpcargo' ) );
}
function wpcargo_map_settings_label(){
	return apply_filters('wpcargo_map_settings_label', esc_html__('Map Settings', 'wpcargo' ) );
}
function wpcargo_print_layout_label(){
	return apply_filters('wpcargo_print_layout_label', esc_html__('Print Layout', 'wpcargo' ) );
}
function wpcargo_shipment_label(){
	return apply_filters('wpcargo_shipment_label', esc_html__('Shipment Label', 'wpcargo' ) );
}
function wpcargo_shipment_details_label(){
    return apply_filters('wpcargo_shipment_details_label', esc_html__('Shipment Details', 'wpcargo' ) );
}
function wpcargo_history_fields(){
	global $wpcargo;
    $history_fields = array(
        'date' => array(
            'label' => esc_html__('Date', 'wpcargo'),
            'field' => 'text',
            'required' => 'false',
            'options' => array()
        ),
        'time' => array(
            'label' => esc_html__('Time', 'wpcargo'),
            'field' => 'text',
            'required' => 'false',
            'options' => array()
        ),
        'location' => array(
            'label' => esc_html__('Location', 'wpcargo'),
            'field' => 'text',
            'required' => 'false',
            'options' => array()
        ),
        'status' => array(
            'label' => esc_html__('Status', 'wpcargo'),
            'field' => 'select',
            'required' => 'false',
            'options' => $wpcargo->status
        ),
        'updated-name' => array(
            'label' => esc_html__('Updated By', 'wpcargo'),
            'field' => 'text',
            'required' => 'false',
            'options' => array()
        ),
        'remarks' => array(
            'label' => esc_html__('Remarks', 'wpcargo'),
            'field' => 'textarea',
            'required' => 'false',
            'options' => array()
        ),
    );
    return apply_filters( 'wpcargo_history_fields', $history_fields );
}
function wpcargo_default_shipment_info(){
	$shipment_info = array(
						'wpcargo_type_of_shipment'	=> esc_html__('Type of Shipment', 'wpcargo'),
						'wpcargo_courier'			=> esc_html__('Courier', 'wpcargo'),
						'wpcargo_carrier_ref_number'	=> esc_html__('Carrier Reference No.', 'wpcargo'),
						'wpcargo_mode_field'			=> esc_html__('Mode', 'wpcargo'),
						'wpcargo_carrier_field'			=> esc_html__('Carrier', 'wpcargo'),
						'wpcargo_packages'				=> esc_html__('Packages', 'wpcargo'),
						'wpcargo_product'				=> esc_html__('Product', 'wpcargo'),
						'wpcargo_weight'				=> esc_html__('Weight', 'wpcargo'),
						'wpcargo_qty'					=> esc_html__('Quantity', 'wpcargo'),
						'wpcargo_total_freight'			=> esc_html__('Total Freight', 'wpcargo'),
						'payment_wpcargo_mode_field'	=> esc_html__('Payment Mode', 'wpcargo'),
						'wpcargo_origin_field'			=> esc_html__('Origin', 'wpcargo'),
						'wpcargo_pickup_date_picker'	=> esc_html__('Pickup Date', 'wpcargo'),
						'wpcargo_destination'			=> esc_html__('Destination', 'wpcargo'),
						'wpcargo_departure_time_picker' => esc_html__('Departure Time', 'wpcargo'),
						'wpcargo_pickup_time_picker'	=> esc_html__('Pickup Time', 'wpcargo'),
						'wpcargo_expected_delivery_date_picker' => esc_html__('Expected Delivery Date', 'wpcargo'),
					);
	return apply_filters( 'wpcargo_default_shipment_info', $history_fields );
}
function wpcargo_assign_shipment_email( $post_id, $user_id, $designation ){
    global  $wpcargo;
    $user_info      = get_userdata( $user_id );
    // Check if user exist 
    if( !$user_info ){
        return false;
    }
	$str_find       = array_keys( wpcargo_email_shortcodes_list() );
	$str_replce     = wpcargo_email_replace_shortcodes_list( $post_id );
	$wpcargo_mail_domain = !empty( trim( get_option('wpcargo_admin_mail_domain') ) ) ? get_option('wpcargo_admin_mail_domain') : get_option( 'admin_email' ) ;
    $user_email     = $user_info->user_email;
	$headers        = array('Content-Type: text/html; charset=UTF-8');
    $headers[]      = esc_html__('From: ', 'wpcargo' ) . get_bloginfo('name') .' <'.$wpcargo_mail_domain.'>';
    $mail_footer    = $wpcargo->client_mail_footer;
	ob_start();
		?>
		<p><?php esc_html_e( 'Dear', 'wpcargo' ); ?> <?php echo $wpcargo->user_fullname( $user_id ); ?>,</p>
        <p><?php echo esc_html__( 'Shipment number ', 'wpcargo' ).get_the_title( $post_id ).esc_html__( ' has been assigned to you.', 'wpcargo' ); ?></p>
		<?php
	$mail_content = ob_get_clean();
    $message        = str_replace($str_find, $str_replce, wpcargo_email_body_container( $mail_content, $mail_footer ) ); 
    $subject        = esc_html__( 'Assign Shipment Notification', 'wpcargo' ).' ['.$designation.']';
	wp_mail( $user_email, $subject, $message, $headers );
}
function wpc_can_send_email_agent(){
	$gen_settings = get_option( 'wpcargo_option_settings' );
	$email_agent = !array_key_exists('wpcargo_email_agent', $gen_settings ) ? true : false;
	return $email_agent;
}
function wpc_can_send_email_employee(){
	$gen_settings = get_option( 'wpcargo_option_settings' );
	$email_employee = !array_key_exists('wpcargo_email_employee', $gen_settings ) ? true : false;
	return $email_employee;
}
function wpc_can_send_email_client(){
	$gen_settings = get_option( 'wpcargo_option_settings' );
	$email_client = !array_key_exists('wpcargo_email_client', $gen_settings ) ? true : false;
	return $email_client;
}
