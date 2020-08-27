<?php

if (!class_exists('PHP_TOOLBOX')) {
    class PHP_TOOLBOX
    {
        public function get_custom_field_values($key, $post_id)
        {
            $output = '';
            $value_array = get_post_custom_values($key, $post_id);
            foreach ($value_array as $value) {
                $output .= $value;
            }
            return $output;
        }
    }
}
