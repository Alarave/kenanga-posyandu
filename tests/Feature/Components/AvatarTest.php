<?php

use Illuminate\Support\Facades\Blade;

test('avatar component renders image when src is provided', function () {
    $html = Blade::render('<x-avatar src="https://example.com/photo.jpg" alt="Ahmad" size="large" status="online" />');

    // Assert container sizes are large
    expect($html)->toContain('h-12 w-12');
    // Assert image tag is present
    expect($html)->toContain('src="https://example.com/photo.jpg"');
    expect($html)->toContain('alt="Ahmad"');
    // Assert status indicator is online (emerald) and has ping animation
    expect($html)->toContain('bg-emerald-500');
    expect($html)->toContain('animate-ping');
});

test('avatar component renders initials fallback when src is missing', function () {
    $html = Blade::render('<x-avatar name="Budi Santoso" size="medium" status="busy" />');

    // Assert container sizes are medium
    expect($html)->toContain('h-10 w-10');
    // Assert initials are generated correctly
    expect($html)->toContain('BS');
    // Assert no image tag is rendered
    expect($html)->not->toContain('<img');
    // Assert status indicator is busy (rose)
    expect($html)->toContain('bg-rose-500');
    expect($html)->not->toContain('animate-ping');
});
