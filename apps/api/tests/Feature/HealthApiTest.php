<?php

it('returns the health endpoint successfully', function () {

    $this->getJson('/api/v1/health')
        ->assertOk()
        ->assertJson([
            'success' => true,
        ]);

});
