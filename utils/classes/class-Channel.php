<?php
class Channel {

    public $post_id;
    public $name;
    public $moderator;

    public function __construct( $post_id ) {
        $this->post_id = $post_id;
        $this->moderator = esc_html( get_post_meta( get_the_ID(), 'chatpress_channel_moderator', true ) );
    }

    public function print() {
        return '';
    }

}