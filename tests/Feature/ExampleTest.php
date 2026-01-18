<?php

test('home page redirects to events list', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('events.index'));
});
