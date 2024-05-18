<?php
// Plugin Admin Page with ACF

//add_menu_page('Custom Admin Page', 'Custom Admin Page', 'manage_options', 'custom-admin-page', 'custom_admin_page_callback');

// Ensure ACF is active
if (!class_exists('ACF')) {
    add_action('admin_notices', 'acf_plugin_notice');

    function acf_plugin_notice() {
        echo '<div class="notice notice-error"><p>ACF plugin is required for this plugin to work. Please install and activate ACF.</p></div>';
    }

    return;
}

// Add ACF Options Page
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'    => 'Siam CM API Settings',
        'menu_title'    => 'Siam CM API Settings',
        'menu_slug'     => 'siam-cm-api-settings',
        'capability'    => 'manage_options',
        'redirect'      => false
    ));
}

// Add ACF Fields
add_action('acf/init', 'siam_cm_api_add_local_fields');
function siam_cm_api_add_local_fields() {
    if (function_exists('acf_add_local_field_group')) {

        acf_add_local_field_group(array(
            'key' => 'group_siam_cm_api_settings',
            'title' => 'Siam CM API Settings',
            'fields' => array(
                array(
                    'key' => 'field_siam_cm_api_example_text',
                    'label' => 'Example Text',
                    'name' => 'example_text',
                    'type' => 'text',
                    'instructions' => 'Enter some text',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                ),
                // Add more fields as needed
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'siam-cm-api-settings',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));
    }
}

// Display the ACF Options in a Custom Admin Page
/* add_action('admin_menu', 'custom_plugin_menu');

function custom_plugin_menu() {
    add_menu_page(
        'Custom Admin Page',
        'Custom Admin Page',
        'manage_options',
        'custom-admin-page',
        'custom_admin_page_callback',
        'dashicons-admin-generic',
        80
    );
}

function siam_cm_api_admin_page_callback() {
    ?>
    <div class="wrap">
        <h1>Siam CM API Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('acf-options-siam-cm-api-settings');
            do_settings_sections('acf-options-siam-cm-api-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
*/
