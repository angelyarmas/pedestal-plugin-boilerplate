<?php

namespace Pedestal\PedestalBeforeAfterGallery\Routes;

use WP_REST_Request;
use Pedestal\PedestalBeforeAfterGallery\Internals\Base\Route;
use Pedestal\PedestalBeforeAfterGallery\Internals\Config;

class Create_Post extends Route
{
    protected $route = '/create-post';

    /**
     * The route action callback.
     */
    public function handle(WP_REST_Request $data)
    {
        $response = [
            'status' => 'error',
            'message' => __('An error occurred while creating the post.', Config::get('TEXT_DOMAIN')),
        ];

        $post_title = $data->get_param('post_title');
        $post_content = $data->get_param('post_content');
        $post_status = $data->get_param('post_status');

        if (empty($post_title) || empty($post_content)) {
            $response['message'] = 'Post title and content are required.';
            return rest_ensure_response($response);
        }

        $post_id = wp_insert_post([
            'post_title' => $post_title,
            'post_content' => $post_content,
            'post_status' => $post_status,
        ]);

        if ($post_id) {
            $response['status'] = 'success';
            $response['message'] = 'Post created successfully.';
            $response['post_id'] = $post_id;
        }

        return rest_ensure_response($response);
    }
}
