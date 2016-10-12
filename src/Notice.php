<?php

final class NF_Util_DuplicateFields_Notice
{
    public function __construct()
    {
        add_action( 'admin_notices', array( $this, 'display' ) );
    }

    public function display()
    {
        $title = 'Ninja Forms - [Utility] Duplicate Fields';

        if( 'complete' == get_option( 'nf_util_remove_duplicate_fields' ) ){
            $classes = 'notice notice-success is-dismissible';
            $message = 'Duplicate fields have been removed.';
            $link = array(
                'href' => add_query_arg( array( 'nf_util_remove_duplicate_fields' => 'start' ), admin_url() ),
                'text' => 'Re-start Process',
                'classes' => 'button button-primary'
            );
        } elseif( 'started' == get_option( 'nf_util_remove_duplicate_fields' ) ) {
            $classes = 'notice notice-info is-dismissible';
            $message = 'Duplicate fields are being removed. You will be notified when the process is complete.';
        } else {
            $classes = 'notice notice-warning is-dismissible';
            $message = 'If you are experiencing duplicate field data, click the button below to fix it.';
            $link = array(
                'href' => add_query_arg( array( 'nf_util_remove_duplicate_fields' => 'start' ), admin_url() ),
                'text' => 'Remove Duplicate Fields',
                'classes' => 'button button-primary'
            );
        }

        include NF_Util_DuplicateFields_Plugin::dir( 'Templates/admin-notice.html.php' );
    }
}
