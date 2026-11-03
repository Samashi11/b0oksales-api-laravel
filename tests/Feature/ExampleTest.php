<?php

it('menampilkan halaman beranda', function () {
    $this->get('/')->assertOk()->assertSee('BookSales');
});
