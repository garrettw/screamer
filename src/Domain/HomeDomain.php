<?php

namespace Screamer\Domain;

class HomeDomain
{
    private $payload;
    // private $posts;

    public function __construct(Payload $payload) // , \Maphper\Maphper $posts
    {
        $this->payload = $payload;
        // $this->posts = $posts;
    }

    public function fetchPage()
    {
        $output = 'Hello world';
        // foreach ($this->posts as $post) {
        //     $output .= '<p>#' . $post->id . ': ' . $post->body . '</p>';
        // }
        return $this->payload->withStatus(Payload::STATUS_FOUND)->withResult(['body' => $output]);
    }
}
