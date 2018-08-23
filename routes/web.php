<?php


Route::namespace('Nhtsa')->group(function () {
    Route::get('vehicles/{model_year}/{manufacturer}/{model}', 'SafetyRatingsController@vehicles');
});
