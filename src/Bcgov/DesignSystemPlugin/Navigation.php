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
        add_action('init', [$this, 'ensure_navigation_exists']);
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
    public function ensure_navigation_exists() {
        $existing_nav = get_posts([
            'post_type' => 'dswp_navigation',
            'posts_per_page' => 1,
            'post_status' => ['publish', 'draft'],
        ]);

        if (empty($existing_nav)) {
            // Create the default navigation block content with full markup
            $navigation_block = '<!-- wp:design-system-wordpress-plugin/navigation -->
<nav class="wp-block-design-system-wordpress-plugin-navigation dswp-block-navigation-is-never-overlay" data-dswp-mobile-breakpoint="768"><button class="dswp-nav-mobile-toggle-icon" aria-label="Toggle menu" aria-expanded="false"><span class="dswp-nav-mobile-menu-icon-text">Menu</span><svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path class="dswp-nav-mobile-bar dswp-nav-mobile-menu-top-bar" d="M3,6h13" stroke-width="1" stroke="currentColor"></path><path class="dswp-nav-mobile-bar dswp-nav-mobile-menu-middle-bar" d="M3,12h13" stroke-width="1" stroke="currentColor"></path><path class="dswp-nav-mobile-bar dswp-nav-mobile-menu-bottom-bar" d="M3,18h13" stroke-width="1" stroke="currentColor"></path></svg></button><ul class="dswp-block-navigation__container"></ul></nav>
<!-- /wp:design-system-wordpress-plugin/navigation -->';
            
            // Create the navigation post with the block
            wp_insert_post([
                'post_type' => 'dswp_navigation',
                'post_title' => __('Site Navigation', 'dswp'),
                'post_status' => 'publish',
                'post_content' => $navigation_block
            ]);
        }
    }

    /**
     * Ensure only one navigation post exists
     */
    public function ensure_single_navigation($post_id, $post, $update) {
        if (!$update) {
            $existing_nav = get_posts([
                'post_type' => 'dswp_navigation',
                'posts_per_page' => 1,
                'post_status' => ['publish', 'draft'],
                'exclude' => [$post_id]
            ]);

            if (!empty($existing_nav)) {
                wp_delete_post($post_id, true);
                wp_die(__('Only one navigation is allowed.', 'dswp'));
            }
        }
    }

    /**
     * Restrict blocks to only allow the custom navigation block
     */
    public function restrict_allowed_blocks($allowed_blocks, $context) {
        if (!empty($context->post) && $context->post->post_type === 'dswp_navigation') {
            return [
                'design-system-wordpress-plugin/navigation',
                'core/navigation-link',
                'core/navigation-submenu',
                'core/spacer'
            ];
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
                .editor-post-preview {
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
            'dswp-admin-menu',
            __('Navigation', 'dswp'),
            __('Navigation', 'dswp'),
            'manage_options',
            'post.php?post=' . $this->get_navigation_post_id() . '&action=edit'
        );
    }

    /**
     * Get the navigation post ID
     */
    private function get_navigation_post_id() {
        $navigation = get_posts([
            'post_type' => 'dswp_navigation',
            'posts_per_page' => 1,
            'post_status' => ['publish', 'draft'],
        ]);

        return !empty($navigation) ? $navigation[0]->ID : 0;
    }
}