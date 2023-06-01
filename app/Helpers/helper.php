<?php

if (!function_exists('havePermission')) {
    function havePermission($document_id,$permission)
    {
        return !is_null(\App\Models\Permission::where(['document_id'=> $document_id, 'permission'=> $permission, 'user_id'=> auth()->id()])->first());
    }
}
?>
