<?php

namespace Pedestal\PedestalBeforeAfterGallery\Internals\Base;

use ICanBoogie\Inflector;
use Pedestal\PedestalBeforeAfterGallery\Internals\Config;
use Pedestal\PedestalBeforeAfterGallery\Internals\Facades\Strng;
use ReflectionClass;

abstract class PostType
{
    protected $post_type_name;
    protected $post_type_slug;
    protected $post_type_args = [];
    protected $menu_icon = 'dashicons-admin-post';
    protected $labels = [];

    public function register()
    {
        $data = wp_parse_args($this->get_post_type_args(), [
            'labels' => $this->get_post_type_labels(),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => $this->get_menu_icon(),
            'rewrite' => ['slug' => $this->get_post_type_slug()],
            'supports' => ['title', 'editor', 'thumbnail'],
        ]);

        register_post_type($this->get_post_type_slug(), $data);
    }

    protected function get_menu_icon(): string
    {
        return $this->menu_icon;
    }

    protected function get_post_type_args(): array
    {
        return $this->post_type_args;
    }

    protected function get_post_type_slug(): string
    {
        $slug = !!$this->post_type_slug ? $this->post_type_slug : $this->get_post_type_name();

        return sanitize_title($slug);
    }

    protected function get_post_type_name(): string
    {
        $name = !!$this->post_type_name ? $this->post_type_name : (new ReflectionClass($this))->getShortName();

        return Strng::inflector()->titleize($name);
    }

    /**
     * Get post type labels, usefull if we want to override the default labels
     *
     * @param   array  $labels  Labels to override
     *
     * @return  array           List of labels
     */
    protected function get_post_type_labels(): array
    {
        $current_labels = wp_parse_args($this->labels, array(
            'name'                  => _x($this->get_label_plural(), 'Post type general name', Config::get('TEXT_DOMAIN')),
            'singular_name'         => _x($this->get_label_singular(), 'Post type singular name', Config::get('TEXT_DOMAIN')),
            'menu_name'             => _x($this->get_label_plural(), 'Admin Menu text', Config::get('TEXT_DOMAIN')),
            'name_admin_bar'        => _x("{$this->get_label_singular()}", 'Add New on Toolbar', Config::get('TEXT_DOMAIN')),
            'add_new'               => __("Add New {$this->get_label_singular()}", Config::get('TEXT_DOMAIN')),
            'add_new_item'          => __("Add New {$this->get_label_singular()}", Config::get('TEXT_DOMAIN')),
            'new_item'              => __("New {$this->get_label_singular()}", Config::get('TEXT_DOMAIN')),
            'edit_item'             => __("Edit {$this->get_label_singular()}", Config::get('TEXT_DOMAIN')),
            'view_item'             => __("View {$this->get_label_singular()}", Config::get('TEXT_DOMAIN')),
            'all_items'             => __("All {$this->get_label_plural()}", Config::get('TEXT_DOMAIN')),
            'search_items'          => __("Search {$this->get_label_plural()}", Config::get('TEXT_DOMAIN')),
            'parent_item_colon'     => __("Parent {$this->get_label_plural()}:", Config::get('TEXT_DOMAIN')),
            'not_found'             => __("No {$this->get_label_plural()} found.", Config::get('TEXT_DOMAIN')),
            'not_found_in_trash'    => __("No {$this->get_label_plural()} found in Trash.", Config::get('TEXT_DOMAIN')),
            'featured_image'        => _x("{$this->get_label_singular()} Cover Image", 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', Config::get('TEXT_DOMAIN')),
            'set_featured_image'    => _x("Set cover image", 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', Config::get('TEXT_DOMAIN')),
            'remove_featured_image' => _x("Remove cover image", 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', Config::get('TEXT_DOMAIN')),
            'use_featured_image'    => _x("Use as cover image", 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', Config::get('TEXT_DOMAIN')),
            'archives'              => _x("{$this->get_label_singular()} archives", 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', Config::get('TEXT_DOMAIN')),
            'insert_into_item'      => _x("Insert into {$this->get_label_singular()}", 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', Config::get('TEXT_DOMAIN')),
            'uploaded_to_this_item' => _x("Uploaded to this {$this->get_label_singular()}", 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', Config::get('TEXT_DOMAIN')),
            'filter_items_list'     => _x("Filter {$this->get_label_plural()} list", 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', Config::get('TEXT_DOMAIN')),
            'items_list_navigation' => _x("{$this->get_label_plural()} list navigation", 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', Config::get('TEXT_DOMAIN')),
            'items_list'            => _x("{$this->get_label_plural()} list", 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', Config::get('TEXT_DOMAIN')),
        ));

        return $current_labels;
    }

    protected function get_label_singular()
    {
        $inflector = Inflector::get(Config::get('LANGUAGE'));

        return $inflector->singularize($this->get_post_type_name());
    }

    protected function get_label_plural()
    {
        $inflector = Inflector::get(Config::get('LANGUAGE'));

        return $inflector->pluralize($this->get_post_type_name());
    }

    public function get_all()
    {
        $query = new \WP_Query([
            'post_type' => $this->get_post_type_slug(),
            'posts_per_page' => -1,
        ]);

        return $query->posts;
    }

    public function get($id)
    {
        return get_post($id);
    }

    public function create($data)
    {
        $post_id = wp_insert_post([
            'post_title' => $data['title'],
            'post_content' => $data['content'],
            'post_type' => $this->get_post_type_slug(),
            'post_status' => 'publish',
        ]);

        if (isset($data['thumbnail'])) {
            set_post_thumbnail($post_id, $data['thumbnail']);
        }

        return $post_id;
    }

    public function update($id, $data)
    {
        wp_update_post([
            'ID' => $id,
            'post_title' => $data['title'],
            'post_content' => $data['content'],
        ]);

        if (isset($data['thumbnail'])) {
            set_post_thumbnail($id, $data['thumbnail']);
        }
    }

    public function delete($id)
    {
        wp_delete_post($id, true);
    }

    public function get_thumbnail_url($id)
    {
        return get_the_post_thumbnail_url($id);
    }

    public function get_permalink($id)
    {
        return get_permalink($id);
    }

    public function get_title($id)
    {
        return get_the_title($id);
    }

    public function get_content($id)
    {
        return get_post_field('post_content', $id);
    }

    public function get_excerpt($id)
    {
        return get_the_excerpt($id);
    }

    public function get_thumbnail($id)
    {
        return get_the_post_thumbnail($id);
    }

    public function get_all_meta($id)
    {
        return get_post_meta($id);
    }

    public function get_meta($id, $key)
    {
        return get_post_meta($id, $key, true);
    }

    public function update_meta($id, $key, $value)
    {
        update_post_meta($id, $key, $value);
    }

    public function delete_meta($id, $key)
    {
        delete_post_meta($id, $key);
    }

    public function get_all_taxonomies($id, $taxonomy = 'category')
    {
        return get_the_terms($id, $taxonomy);
    }

    public function get_taxonomy($id, $taxonomy)
    {
        return get_the_terms($id, $taxonomy);
    }

    public function update_taxonomy($id, $taxonomy, $terms)
    {
        wp_set_post_terms($id, $terms, $taxonomy);
    }

    public function delete_taxonomy($id, $taxonomy)
    {
        wp_delete_object_term_relationships($id, $taxonomy);
    }
}
