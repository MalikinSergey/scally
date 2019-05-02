<?php

Route::get('scally/scaffold/create', "\\Mlsg\\Scally\\ScaffoldController@create")->name("scally.scaffold.create");
Route::post('scally/scaffold/store', "\\Mlsg\\Scally\\ScaffoldController@store")->name("scally.scaffold.store");
