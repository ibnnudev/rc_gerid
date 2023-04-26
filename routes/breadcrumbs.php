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

// Bank Data > Advanced Search
Breadcrumbs::for('bank.advanced-search', function (BreadcrumbTrail $trail) {
    $trail->parent('bank');
    $trail->push('Pencarian Data', route('admin.bank.advanced-search'));
});

// Bank Data > Daftar File Terimport
Breadcrumbs::for('bank.imported', function (BreadcrumbTrail $trail) {
    $trail->parent('bank');
    $trail->push('Daftar File Terimpor', route('admin.bank.imported'));
});
// Bank Data > Daftar Sekuen
Breadcrumbs::for('bank.imported.user', function (BreadcrumbTrail $trail) {
    $trail->parent('bank');
    $trail->push('Daftar Sekuen', route('admin.bank.imported'));
});

// Import Request
Breadcrumbs::for('import-request', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Daftar Permintaan', route('admin.import-request.index'));
});

// Import Request > Detail
Breadcrumbs::for('import-request.show', function (BreadcrumbTrail $trail, $importRequest) {
    $trail->parent('import-request');
    $trail->push($importRequest->file_code, route('admin.import-request.show', $importRequest->id));
});

// Import Request > Create
Breadcrumbs::for('import-request.create', function (BreadcrumbTrail $trail) {
    $trail->parent('import-request');
    $trail->push('Tambah Permintaan', route('admin.import-request.create'));
});

// Import Request > Create Single Data
Breadcrumbs::for('import-request.create-single', function (BreadcrumbTrail $trail, $fileCode) {
    $trail->parent('import-request');
    $trail->push($fileCode);
    $trail->push('Tambah Permintaan', route('admin.import-request.create-single', $fileCode));
});

// Import Request > Detail Single Data
Breadcrumbs::for('import-request.show-single', function (BreadcrumbTrail $trail, $sample) {
    $trail->parent('import-request');
    $trail->push($sample->sample_code, route('admin.import-request.show-single', $sample->id));
});

// Import Request > Edit Single Data
Breadcrumbs::for('import-request.edit-single', function (BreadcrumbTrail $trail, $sample) {
    $trail->parent('import-request');
    $trail->push($sample->file_code, route('admin.import-request.show-single', $sample->id));
    $trail->push('Edit Permintaan', route('admin.import-request.edit-single', $sample->id));
});

// Import Request > Edit
Breadcrumbs::for('import-request.edit', function (BreadcrumbTrail $trail, $importRequest) {
    $trail->parent('import-request');
    $trail->push('Edit Permintaan', route('admin.import-request.edit', $importRequest->id));
});

// Import Request (Admin)
Breadcrumbs::for('import-request.admin', function(BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Daftar Permintaan', route('admin.import-request.admin'));
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

// HIV Cases
Breadcrumbs::for('hiv-cases', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Kasus HIV', route('admin.hiv-case.index'));
});

// HIV Cases > Create
Breadcrumbs::for('hiv-cases.create', function (BreadcrumbTrail $trail) {
    $trail->parent('hiv-cases');
    $trail->push('Tambah Kasus HIV', route('admin.hiv-case.create'));
});

// HIV Cases > Show
Breadcrumbs::for('hiv-cases.show', function (BreadcrumbTrail $trail, $case) {
    $trail->parent('hiv-cases');
    $trail->push($case->idkd, route('admin.hiv-case.show', $case->id));
});

// HIV Cases > Edit
Breadcrumbs::for('hiv-cases.edit', function (BreadcrumbTrail $trail, $case) {
    $trail->parent('hiv-cases');
    $trail->push($case->idkd, route('admin.hiv-case.show', $case->id));
    $trail->push('Edit', route('admin.hiv-case.edit', $case->id));
});

// Citation
Breadcrumbs::for('citation', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Sitasi', route('admin.citation.index'));
});

// Citation > Create
Breadcrumbs::for('citation.create', function (BreadcrumbTrail $trail) {
    $trail->parent('citation');
    $trail->push('Tambah Sitasi', route('admin.citation.create'));
});

// Citation > Edit
Breadcrumbs::for('citation.edit', function (BreadcrumbTrail $trail, $citation) {
    $trail->parent('citation', $citation->title);
    $trail->push('Edit', route('admin.citation.edit', $citation->id));
});

// Citation > Show
Breadcrumbs::for('citation.show', function (BreadcrumbTrail $trail, $citation) {
    $trail->parent('citation', $citation->title);
    $trail->push('Detail', route('admin.citation.show', $citation->id));
});

// User Management
Breadcrumbs::for('user-management', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Manajemen Pengguna', route('admin.user-management.index'));
});
