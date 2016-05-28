<?php

class NewTable extends Illuminate\Database\Eloquent\Model {
    protected $table = "newtable";

    public static function get_name($id) {
        $user = NewTable::find($id);
        return $user->name;
    }


    // public static function get_id($user) {
    //     $user = Users::where('username', '=', $user)->first();
    //     return $user->id;
    // }
}