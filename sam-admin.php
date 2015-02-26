<?php

function sam_admin() {
    global $sam_options;
    ?>
    
    <div class="wrap">
        <h2>SAM Donation Settings</h2>
        <p>Hello fellow SAM missionary!  This plugin is going to help you get a recurring donation form set up on your Wordpress site!<br>
        All we'll need is two simple bits of information: <strong>your full name(s)</strong> and <strong>your SAM account number.</strong></p>
        <p>You can find your account number by <a href="http://www.southamericamission.org/index.php?page=ABOUT+SAM&amp;content=12">going here</a> and clicking on your name.  You will then be able to find your account number by looking at the very bottom of the far right column.</p>
        
        <form method="POST" action="options.php">
        <?php settings_fields( 'sam_options_group' ); ?>
            Name(s):<br>
            <input type="text" style="width:300px;" name="sam_setting[mname]" id="sam_setting[mname]" placeholder="John and Jane Doe" value="<?php echo $sam_options['mname'] ?>"><br><br>
            Account Number:<br>
            <input type="text" style="width:75px;" name="sam_setting[acctnum]" id="sam_setting[acctnum]" placeholder="12345" maxlength="5" value="<?php echo $sam_options['acctnum'] ?>">
            <?php submit_button();
            sam_validation($sam_options['mname'], $sam_options['acctnum']);
            update_option('sam_options_group', 'mname');
            update_option('sam_options_group', 'acctnum');
            ?>
        </form>

        <p>Once you've saved your settings, drop this shortcode into any post or page to add the SAM donation widget.</p>
        <code style="border: solid 1px #dadada; padding: 6px; background: #f5f7f8; font-size: 14px; border-radius: 3px;">[sam-donate]</code>
        <p>If you have access to your theme's files and would like to drop it into a .php template, use this WordPress function instead:</p>
        <code style="border: solid 1px #dadada; padding: 6px; background: #f5f7f8; font-size: 14px; border-radius: 3px;">do_shortcode('[sam-donate]')</code>
    </div>
<?php

}

add_action('admin_menu', 'sam_admin_actions');
function sam_admin_actions() {
    add_plugins_page('SAM Donate', 'SAM Donate', 'manage_options', 'sam-admin', 'sam_admin');
}
function sam_register_setting() {
    register_setting( 'sam_options_group', 'sam_setting' );
}
add_action('admin_init', 'sam_register_setting');

function sam_donation_form() {
    global $sam_options;
    
    if (!$sam_options['mname'] || !$sam_options['acctnum']) { ?>
        Please add your SAM name and account number in the plugin options page.
    <?php } else { ?>
        <form id="frmDonate" name="frmDonate" action="<?php echo plugins_url( 'sam-donation/donate.php', dirname(__FILE__) ); ?>" method="post">
            Amount: $<input name="amount" type="text" id="amount" style="width:110px;"/><br>
            Frequency:
            <select name="recur" id="recur">
                <option value="1" selected>Monthly</option>
                <option value="2">Quarterly</option>
                <option value="3">Annually</option>
                <option value="4">One-time</option>
            </select>
            <input type="hidden" name="mname" value="<?php echo $sam_options['mname']; ?>">
            <input type="hidden" name="acctnum" value="<?php echo $sam_options['acctnum']; ?>">
            <br><br>
            <input type="submit" name="sam_submit" id="sam_submit" value="Donate">
            <span id="sam-response-text"></span>
        </form>
    <?php }

}

function sam_validation($mname, $acctnum) {
    
    global $reg_errors;
    $reg_errors = new WP_Error;

    if ( empty($mname) && empty($acctnum) ) {
        $reg_errors->add('field', 'Your name and account number are missing.');
    } else if ( empty($mname)) {
        $reg_errors->add('field', 'Your name is missing.');
    } else if ( empty($acctnum)) {
        $reg_errors->add('field', 'Your account number is missing.');
    }
    if (strip_tags(trim($mname)) !== $mname) {
        $reg_errors->add('field', 'Please remove special characters from your name.');
    }
    if ( 5 > strlen( $acctnum ) ) {
        $reg_errors->add( 'acctnum_length', 'Your account number too short.  Your number should be at least 5 digits long.' );
    }
    if (!is_numeric($acctnum)) {
        $reg_errors->add( 'acctnum_type', 'Your account number should not have letters in it.');
    }

    if ( is_wp_error( $reg_errors ) ) {
        foreach ( $reg_errors->get_error_messages() as $error ) {
            echo '<div style="color:#900000;">';
            echo '<strong>ERROR</strong>: ';
            echo $error . '<br/>';
            echo '</div>';
        }
    } else {
        update_option('sam_options_group', 'mname');
        update_option('sam_options_group', 'acctnum');
    }

}

// Register a new shortcode: [sam_donate]
add_shortcode( 'sam-donate', 'sam_donation_shortcode' );

function sam_donation_shortcode() {
    ob_start();
    sam_donation_form();
    return ob_get_clean();
}