<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Models;

use Igniter\Local\Models\ReviewSettings;
use Igniter\System\Actions\SettingsModel;

it('returns true when reviews are allowed', function(): void {
    ReviewSettings::set('allow_reviews', true);

    $result = ReviewSettings::allowReviews();

    expect($result)->toBeTrue();
});

it('returns false when reviews are not allowed', function(): void {
    ReviewSettings::set('allow_reviews', false);

    $result = ReviewSettings::allowReviews();

    expect($result)->toBeFalse();
});

it('returns true when reviews are auto approved', function(): void {
    ReviewSettings::set('approve_reviews', true);

    $result = ReviewSettings::autoApproveReviews();

    expect($result)->toBeTrue();
});

it('returns false when reviews are not auto approved', function(): void {
    ReviewSettings::set('approve_reviews', false);

    $result = ReviewSettings::autoApproveReviews();

    expect($result)->toBeFalse();
});

it('returns default hints when no custom hints are set', function(): void {
    $result = ReviewSettings::getHints();

    expect($result)->toBeArray()
        ->and($result)->toContain('Poor')
        ->and($result)->toContain('Average')
        ->and($result)->toContain('Good')
        ->and($result)->toContain('Very Good')
        ->and($result)->toContain('Excellent');
});

it('returns custom hints when they are set', function(): void {
    $customHints = [
        ['value' => 'Bad'],
        ['value' => 'Okay'],
        ['value' => 'Great'],
    ];
    ReviewSettings::set('hints', $customHints);

    $result = ReviewSettings::getHints();

    expect($result)->toBeArray()
        ->and($result)->toContain('Bad')
        ->and($result)->toContain('Okay')
        ->and($result)->toContain('Great');
});

it('configures review settings model correctly', function(): void {
    $reviewSettings = new ReviewSettings;

    expect($reviewSettings->implement)->toContain(SettingsModel::class)
        ->and($reviewSettings->settingsCode)->toBe('igniter_review_settings')
        ->and($reviewSettings->settingsFieldsConfig)->toBe('reviewsettings')
        ->and(ReviewSettings::$defaultHints)->toEqual([
            ['value' => 'Poor'],
            ['value' => 'Average'],
            ['value' => 'Good'],
            ['value' => 'Very Good'],
            ['value' => 'Excellent'],
        ]);
});
