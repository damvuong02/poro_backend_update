<?php

use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('create-order', function () {
    return true;
});

Broadcast::channel('delete-order', function () {
    return true;
});

Broadcast::channel('update-order', function () {
    return true;
});

Broadcast::channel('create-notification', function () {
    return true;
});

Broadcast::channel('delete-notification', function () {
    return true;
});

Broadcast::channel('update-table', function () {
    return true;
});

Broadcast::channel('update-food', function () {
    return true;
});

Broadcast::channel('number-notification', function () {
    return true;
});