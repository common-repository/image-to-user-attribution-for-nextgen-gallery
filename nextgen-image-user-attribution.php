<?php
    /*
    Plugin Name: Image-to-user attribution for Nextgen Gallery
    Description: Saves the image's author (uploader) name along with the uploaded image information.
    Version: 1.0
    Author: Aimbox
    Author URI: http://aimbox.com
    Depends: NextGEN Gallery
    */


    class NggImageUserAttribution
    {
        private static $instance;



        public static function instance()
        {
            if (!isset(self::$instance))
            {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public function __construct()
        {
            add_action('ngg_added_new_image', array($this, 'saveImageAuthor'));
        }

        public function saveImageAuthor($image)
        {
            /** @var wpdb $wpdb */
            global $wpdb;

            $wpdb->query($wpdb->prepare
            ("
                UPDATE {$wpdb->nggpictures}
                SET imp_user_id = %s
                WHERE pid = %s
            ", array(
                wp_get_current_user()->ID,
                $image['id']
            )));
        }
    }

    NggImageUserAttribution::instance();
?>