<?php

test('health check returns success', function () {
    $response = $this->get('/up');

    $response->assertStatus(200);
});
