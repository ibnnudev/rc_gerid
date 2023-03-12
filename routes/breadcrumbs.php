<?php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function(BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('admin.dashboard'));
});

// Bank Data
Breadcrumbs::for('bank', function(BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Bank Data', route('admin.bank.index'));
});

// Bank Data > Tambah Bank
Breadcrumbs::for('bank.create', function(BreadcrumbTrail $trail) {
    $trail->parent('bank');
    $trail->push('Tambah Bank', route('admin.bank.create'));
});

// Penulis
Breadcrumbs::for('author', function(BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Penulis', route('admin.author.index'));
});

// Penulis > Tambah Penulis
Breadcrumbs::for('author.create', function(BreadcrumbTrail $trail) {
    $trail->parent('author');
    $trail->push('Tambah Penulis', route('admin.author.create'));
});

// Penulis > Detail Penulis
Breadcrumbs::for('author.show', function(BreadcrumbTrail $trail, $author) {
    $trail->parent('author');
    $trail->push($author->name, route('admin.author.show', $author->id));
});

// Penulis > Edit Penulis
Breadcrumbs::for('author.edit', function(BreadcrumbTrail $trail, $author) {
    $trail->parent('author.show', $author);
    $trail->push('Edit Penulis', route('admin.author.edit', $author->id));
});
