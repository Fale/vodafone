<?php

Route::get('help', array(function () { return View::make('help'); }));

Route::get('csv', array('uses' => 'CsvController@all'));
Route::get('csv/tra/{from}/{to}', array('uses' => 'CsvController@all'));
Route::get('csv/dal/{from}', array('uses' => 'CsvController@all'));
Route::get('csv/al/{to}', array('uses' => 'CsvController@to'));
Route::get('csv/number/{n}', array('uses' => 'CsvController@number'));

Route::get('/', array(function () { return View::make('index'); }));
Route::get('dal/{d}', array(function ($d) { return View::make('index')->with('d', $d); }));
Route::get('al/{a}', array(function ($a) { return View::make('index')->with('a', $a); }));
Route::get('tra/{d}/{a}', array(function ($d, $a) { return View::make('index')->with('d', $d)->with('a', $a); }));
Route::get('number/{n}', array(function ($n) { return View::make('index')->with('n', $n); }));