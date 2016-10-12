<?php

final class NF_Util_DuplicateFields_Plugin
{
    private static $ver;
    private static $dir;
    private static $url;

    private $notice;
    private $process;

    public function __construct( $plugin_version, $plugin_file )
    {
        self::$ver = $plugin_version;
        self::$dir = plugin_dir_path($plugin_file);
        self::$url = plugin_dir_url($plugin_file);

        spl_autoload_register( array( $this, 'autoloader' ) );

        $this->notice = new NF_Util_DuplicateFields_Notice();
        $this->process = new NF_Util_DuplicateFields_Process();

        if( isset( $_GET[ 'nf_util_remove_duplicate_fields' ] ) && 'start' == $_GET[ 'nf_util_remove_duplicate_fields' ] ){
            $forms = Ninja_Forms()->form()->get_forms();

            foreach( $forms as $form ) {
                $this->process->push_to_queue( $form );
            }

            $this->process->save()->dispatch();
            update_option( 'nf_util_remove_duplicate_fields', 'started' );
            wp_redirect( admin_url() );
        }
    }

    public static function dir( $filename = '' )
    {
        return self::$dir . 'src/' . $filename;
    }

    public function autoloader( $class_name )
    {
        if (false !== strpos($class_name, 'NF_Util_DuplicateFields_')) {
            $class_name = str_replace('NF_Util_DuplicateFields_', '', $class_name);
            $classes_dir = realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR;
            $class_file = str_replace('_', DIRECTORY_SEPARATOR, $class_name) . '.php';
            if (file_exists($classes_dir . $class_file)) {
                require_once $classes_dir . $class_file;
            }
        }
    }
}
