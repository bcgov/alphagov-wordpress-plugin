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
        add_action('save_post_dswp_navigation', [$this, 'ensure_single_navigation'], 10, 3);
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
            ],
            'public' => true,
            'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'show_in_rest' => true,
            'supports' => ['editor', 'title'],
            'capability_type' => 'post',
            'capabilities' => [
                'edit_post' => 'manage_options',
                'edit_posts' => 'manage_options',
                'edit_others_posts' => 'manage_options',
                'publish_posts' => 'manage_options',
                'read_post' => 'manage_options',
                'read_private_posts' => 'manage_options',
                'delete_post' => 'do_not_allow'
            ],
            'map_meta_cap' => false,
        ]);

        // Create default navigation post if it doesn't exist
        $this->ensure_navigation_exists();
    }

    /**
     * Ensure navigation post exists
     */
    private function ensure_navigation_exists() {
        $existing_nav = get_posts([
            'post_type' => 'dswp_navigation',
            'posts_per_page' => 1,
            'post_status' => ['publish', 'draft'],
        ]);

        if (empty($existing_nav)) {
            wp_insert_post([
                'post_type' => 'dswp_navigation',
                'post_title' => __('Site Navigation', 'dswp'),
                'post_status' => 'publish',
            ]);
        }
    }

    /**
     * Ensure only one navigation post exists
     */
    public function ensure_single_navigation($post_id, $post, $update) {
        if (!$update) {
            wp_delete_post($post_id, true);
            wp_die(__('Only one navigation is allowed.', 'dswp'));
        }
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
     * Add CSS to restrict editor modifications
     */
    public function restrict_editor_modifications() {
        if (get_post_type() === 'dswp_navigation') {
            echo '<style>
                .editor-post-trash,
                .editor-post-switch-to-draft,
                .components-button.editor-post-last-revision__title,
                .editor-post-preview,
                .block-editor-block-list__layout .block-editor-block-list__block .block-editor-block-list__layout {
                    display: none !important;
                }
            </style>';
        }
    }

    /**
     * Add the navigation menu item
     */
    public function add_menu() {
        $nav_post = get_posts([
            'post_type' => 'dswp_navigation',
            'posts_per_page' => 1,
            'post_status' => ['publish', 'draft'],
        ]);

        if (!empty($nav_post)) {
            add_submenu_page(
                'dswp-admin-menu',
                __('Navigation', 'dswp'),
                __('Navigation', 'dswp'),
                'manage_options',
                'post.php?post=' . $nav_post[0]->ID . '&action=edit',
                null
            );
        }
    }
}