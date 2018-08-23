<?php

use Illuminate\Http\Request;

Route::namespace('Nhtsa')->group(function () {
    Route::get('vehicles/{model_year}/{manufacturer}/{model}', 'SafetyRatingsController@vehicles');
    Route::post('vehicles', 'SafetyRatingsController@vehiclesWithPost');
});
