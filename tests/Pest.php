<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

// Semua tes di folder Feature memakai TestCase Laravel + database yang di-reset tiap tes.
pest()->extend(Tests\TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature');
