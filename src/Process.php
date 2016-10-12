<?php

class NF_Util_DuplicateFields_Process extends WP_Background_Process
{
    protected $action = 'NF_Util_DuplicateFields_Process';

    protected function task( $form )
    {
        $fields = Ninja_Forms()->form( $form->get_id() )->get_fields();

        usort( $fields, array( $this, 'sort_fields' ) );

        $unique_keys = array();
        $field_cache = array();
        foreach( $fields as $field ){

            $field_key = $field->get_setting( 'key' );

            if( ! in_array( $field_key, $unique_keys ) ){
                $unique_keys[] = $field_key;
                $field_cache[] = array(
                    'id' => $field->get_id(),
                    'settings' => $field->get_settings()
                );
            } else {
                $field->delete();
            }
        }

        if( $form_cache = get_option( 'nf_form_' . $form->get_id(), false ) ){
            $form_cache[ 'fields' ] = $field_cache;
            update_option( 'nf_form_' . $form->get_id(), $form_cache );
        }

        return false;
    }

    private function sort_fields( $a, $b )
    {
        return ( $a->get_id() < $b->get_id() ) ? -1 : 1;
    }

    protected function complete()
    {
        parent::complete();
        update_option( 'nf_util_remove_duplicate_fields', 'complete' );
    }
}
