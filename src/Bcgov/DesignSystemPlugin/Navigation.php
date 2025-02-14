<?php

namespace Bcgov\DesignSystemPlugin;

/**
 * Class Navigation
 * 
 * Handles the custom navigation post type and its restrictions
 */
class Navigation {

    /**
     * Initialize the navigation functionality
     */
    public function init() {
        add_action('init', [$this, 'register_navigation_post_type']);
        add_action('admin_menu', [$this, 'add_menu'], 20);
        add_filter('allowed_block_types_all', [$this, 'restrict_allowed_blocks'], 10, 2);
        add_filter('post_row_actions', [$this, 'remove_quick_edit_actions'], 10, 2);
        add_action('admin_head', [$this, 'restrict_editor_modifications']);
    }

    /**
     * Register the custom navigation post type
     */
    public function register_navigation_post_type() {
        register_post_type('dswp_navigation', [
            'labels' => [
                'name' => __('Navigation', 'dswp'),
                'singular_name' => __('Navigation', 'dswp'),
                'menu_name' => __('Navigation', 'dswp'),
                'edit_item' => __('Edit Navigation', 'dswp'),
                'view_item' => __('View Navigation', 'dswp'),
                'all_items' => __('All Navigations', 'dswp'),
            ],
            'public' => true,
            'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'show_in_rest' => true,
            'supports' => ['editor', 'title'],
            'capabilities' => [
                'edit_post' => 'manage_options',
                'read_post' => 'manage_options',
                'delete_post' => 'do_not_allow',
                'edit_posts' => 'manage_options',
                'edit_others_posts' => 'manage_options',
                'delete_posts' => 'do_not_allow',
                'publish_posts' => 'manage_options',
                'read_private_posts' => 'manage_options'
            ],
            'map_meta_cap' => false,
        ]);
    }

    /**
     * Restrict blocks to only allow the custom navigation block
     */
    public function restrict_allowed_blocks($allowed_blocks, $context) {
        if (!empty($context->post) && $context->post->post_type === 'dswp_navigation') {
            return ['design-system-wordpress-plugin/navigation'];
        }
        return $allowed_blocks;
    }

    /**
     * Remove quick edit and other actions
     */
    public function remove_quick_edit_actions($actions, $post) {
        if ($post->post_type === 'dswp_navigation') {
            unset($actions['inline hide-if-no-js']);
            unset($actions['trash']);
            unset($actions['delete']);
        }
        return $actions;
    }

    /**
     * Add CSS to restrict editor modifications
     */
    public function restrict_editor_modifications() {
        if (get_post_type() === 'dswp_navigation') {
            echo '<style>
                .editor-post-trash,
                .editor-post-switch-to-draft,
                .components-button.editor-post-last-revision__title {
                    display: none !important;
                }
            </style>';
        }
    }

    /**
     * Add the navigation menu item
     */
    public function add_menu() {
        add_submenu_page(
            'dswp-admin-menu',           // Parent slug
            __('Navigation', 'dswp'),    // Page title
            __('Navigation', 'dswp'),    // Menu title
            'manage_options',            // Capability
            'edit.php?post_type=dswp_navigation', // Menu slug
            null                         // Callback function
        );
    }
}