<?php

/*
Plugin Name: Click Tracking Plugin
Description: A plugin to track user clicks on specific button and display the count in user profile.
Version: 1.0
Author: Your Name
*/

// Handle AJAX request to update user click
function update_user_click() {
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $clicks = (int) get_user_meta($user_id, 'clicks', true);
        $clicks++;
        update_user_meta($user_id, 'clicks', $clicks);
        wp_send_json_success();
    } else {
        wp_send_json_error('User is not logged in');
    }
}
add_action('wp_ajax_update_user_click', 'update_user_click');
add_action('wp_ajax_nopriv_update_user_click', 'update_user_click');


// Enqueue the JavaScript code
function enqueue_click_script() {
    wp_enqueue_script(
        'click-script',
        plugin_dir_url(__FILE__) . 'js/click.js',
        array('jquery'),
        '1.0',
        true
    );

    $user_id = get_current_user_id();
    wp_localize_script(
        'click-script',
        'clickObject',
        array(
            'adminUrl' => admin_url('admin-ajax.php'), 
            'userId' => $user_id
        )
    );
    
}
add_action('wp_enqueue_scripts', 'enqueue_click_script');


// Function for displaying click count in user profile
function display_user_clicks($user) {
    $clicks = (int) get_user_meta($user->ID, 'clicks', true);

    ?>
    <h3>Click Count</h3>
    <table class="click-table">
        <tr>
            <th><label for="clicks">Total Clicks</label></th>
            <td>
                <input type="text" name="clicks" id="clicks" value="<?php echo $clicks; ?>" disabled>
            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'display_user_clicks');
add_action('edit_user_profile', 'display_user_clicks');
