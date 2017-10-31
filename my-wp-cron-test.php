<?php
/*
Plugin Name: My WP-Cron Test
*/

require_once 'vendor/autoload.php';

CONST TODOS_EVENT = 'todos_event';

register_activation_hook(__FILE__, 'my_activation');

function my_activation() {
    if (! wp_next_scheduled ( TODOS_EVENT )) {
        wp_schedule_event(time(), 'hourly', TODOS_EVENT);
    }
}

function do_this_hourly_todo() {
      $faker = Faker\Factory::create();

      for($i=0;$i<3;$i++) {

   //     file_put_contents('run.txt', 'run'. date('Y-m-d H:i:s'));

        wp_insert_post([
            'post_title' => $faker->sentence,
            'post_content' => $faker->text,
            'post_author' => $faker->name,
            'post_type' => 'todos',
            'post_status' => 'publish'
        ]);
    }
}
add_action(TODOS_EVENT, 'do_this_hourly_todo');



function deactivate() {
    wp_clear_scheduled_hook(TODOS_EVENT);
}