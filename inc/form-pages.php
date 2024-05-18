<?php

//  create a form page with Elementor on plugin activation.
 

// Hook for plugin activation
//register_activation_hook(__FILE__, 'create_elementor_form_page');

function create_elementor_form_page($title, $template_path) {
    
    // Check if Elementor is active
    if (!did_action('elementor/loaded')) {
        // Deactivate the plugin if Elementor is not active
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die('This plugin requires Elementor to be active.');
    }

    // Read the template file
    $template_content = file_get_contents($template_path);
    if (!$template_content) {
        wp_die('Failed to read the template file.');
    }

    // Decode the JSON template content
    $template_data = json_decode($template_content, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        wp_die('Invalid JSON in template file.');
    }

    // Create a new page with the imported template
    $page_id = wp_insert_post([
        'post_title'    => $title,
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_type'     => 'page',
    ]);

    if (is_wp_error($page_id)) {
        wp_die('Failed to create the form page.');
    }

    // Import the template data to the new page
    update_post_meta($page_id, '_elementor_data', $template_data['content']);
    update_post_meta($page_id, '_elementor_edit_mode', 'builder');
    update_post_meta($page_id, '_elementor_template_type', 'wp-page');
    update_post_meta($page_id, '_elementor_version', ELEMENTOR_VERSION);

    // Flush rewrite rules to ensure the new page's permalink works
    flush_rewrite_rules();
}

// Hook for plugin deactivation to clean up if necessary
//register_deactivation_hook(__FILE__, 'delete_elementor_form_page');

function delete_elementor_form_page($title) {
    // Find and delete the page created by the plugin
    $page = siam_get_page_by_title($title);
    if ($page) {
        wp_delete_post($page->ID, true);
    }
}
