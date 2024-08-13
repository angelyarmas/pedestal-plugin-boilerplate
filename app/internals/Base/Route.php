<?php

namespace Pedestal\PedestalBeforeAfterGallery\Internals\Base;

use Pedestal\PedestalBeforeAfterGallery\Internals\Config;
use WP_REST_Request;

abstract class Route
{
    protected $route;
    protected $method = 'GET';
    protected $namespace;
    protected $args = [];
    protected $override = false;
    protected $enabled = true;

    public function register()
    {
        $this->args = [
            'methods' => $this->method,
            'callback' => [$this, 'handle'],
            'permission_callback' => [$this, 'permission_callback'],
        ];

        register_rest_route($this->get_namespace(), $this->route, $this->args, $this->override);
    }

    public function permission_callback(): bool
    {
        return current_user_can('edit_posts');
    }

    private function get_namespace(): string
    {
        return Config::get('REST_NAMESPACE') ?? $this->namespace;
    }

    abstract public function handle(WP_REST_Request $data);
}
