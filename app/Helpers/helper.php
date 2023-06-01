<?php

if (!function_exists('havePermission')) {
    function havePermission($document,$permission)
    {
        if ($document->user_id == auth()->id()){
            return true;
        }
        return !is_null(\App\Models\Permission::where(['document_id'=> $document->id, 'permission'=> $permission, 'user_id'=> auth()->id()])->first());
    }
}
?>
