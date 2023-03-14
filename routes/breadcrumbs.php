<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('admin.dashboard'));
});

// Bank Data
Breadcrumbs::for('bank', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Bank Data', route('admin.bank.index'));
});

// Bank Data > Tambah Bank
Breadcrumbs::for('bank.create', function (BreadcrumbTrail $trail) {
    $trail->parent('bank');
    $trail->push('Tambah Bank', route('admin.bank.create'));
});

// Bank Data > Detail Bank
Breadcrumbs::for('bank.show', function (BreadcrumbTrail $trail, $sample) {
    $trail->parent('bank');
    $trail->push($sample->sample_code, route('admin.bank.show', $sample->id));
});

// Bank Data > Edit Bank,
Breadcrumbs::for('bank.edit', function (BreadcrumbTrail $trail, $sample) {
    $trail->parent('bank');
    $trail->push($sample->sample_code, route('admin.bank.show', $sample->id));
    $trail->push('Edit Bank', route('admin.bank.edit', $sample->id));
});


// Penulis
Breadcrumbs::for('author', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Penulis', route('admin.author.index'));
});

// Penulis > Tambah Penulis
Breadcrumbs::for('author.create', function (BreadcrumbTrail $trail) {
    $trail->parent('author');
    $trail->push('Tambah Penulis', route('admin.author.create'));
});

// Penulis > Detail Penulis
Breadcrumbs::for('author.show', function (BreadcrumbTrail $trail, $author) {
    $trail->parent('author');
    $trail->push($author->name, route('admin.author.show', $author->id));
});

// Penulis > Edit Penulis
Breadcrumbs::for('author.edit', function (BreadcrumbTrail $trail, $author) {
    $trail->parent('author', $author);
    $trail->push('Edit Penulis', route('admin.author.edit', $author->id));
});

// Virus
Breadcrumbs::for('virus', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Virus', route('admin.virus.index'));
});

// Virus > Tambah Virus
Breadcrumbs::for('virus.create', function (BreadcrumbTrail $trail) {
    $trail->parent('virus');
    $trail->push('Tambah Virus', route('admin.virus.create'));
});

// Virus > Detail
Breadcrumbs::for('virus.show', function (BreadcrumbTrail $trail, $virus) {
    $trail->parent('virus');
    $trail->push($virus->name, route('admin.virus.show', $virus->id));
});

// Virus > Edit
Breadcrumbs::for('virus.edit', function (BreadcrumbTrail $trail, $virus) {
    $trail->parent('virus', $virus);
    $trail->push('Edit', route('admin.virus.edit', $virus->id));
});

// Genotipe
Breadcrumbs::for('genotipe', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Genotipe', route('admin.genotipe.index'));
});

// Genotipe > create
Breadcrumbs::for('genotipe.create', function (BreadcrumbTrail $trail) {
    $trail->parent('genotipe');
    $trail->push('Tambah Genotipe', route('admin.genotipe.create'));
});

// Genotipe > detail
Breadcrumbs::for('genotipe.show', function (BreadcrumbTrail $trail, $genotipe) {
    $trail->parent('genotipe');
    $trail->push($genotipe->genotipe_code, route('admin.genotipe.show', $genotipe->id));
});

// Genotipe > edit
Breadcrumbs::for('genotipe.edit', function (BreadcrumbTrail $trail, $genotipe) {
    $trail->parent('genotipe', $genotipe);
    $trail->push('Edit', route('admin.genotipe.edit', $genotipe->id));
});

// Transmission
Breadcrumbs::for('transmission', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Transmisi', route('admin.transmission.index'));
});

// Transmission > Create
Breadcrumbs::for('transmission.create', function (BreadcrumbTrail $trail) {
    $trail->parent('transmission');
    $trail->push('Tambah Transmisi', route('admin.transmission.create'));
});

// Tranmission > Edit
Breadcrumbs::for('transmission.edit', function (BreadcrumbTrail $trail, $transmission) {
    $trail->parent('transmission', $transmission);
    $trail->push('Edit', route('admin.transmission.edit', $transmission->id));
});
