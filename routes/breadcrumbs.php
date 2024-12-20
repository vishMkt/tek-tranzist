<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('forest_twin', function (BreadcrumbTrail $trail) {
    $trail->push('DroupUs', route('admin'));
});

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('admin'));
});

// Home > users
Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('Users', route('users.index'));
});

// Home > user > add
Breadcrumbs::for('user.create', function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push('Create', route('users.create'));
});
// Home > user > edit
Breadcrumbs::for('user.edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('user');
    $trail->push('Edit', route('users.update',$userid));
});
// Home > user > show
Breadcrumbs::for('user.show', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('user');
    $trail->push('Show', route('users.show',$userid));
});

// Home > projects
Breadcrumbs::for('projects', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('Projects', route('projects.index'));
});

// Home > projects > add
Breadcrumbs::for('projects.create', function (BreadcrumbTrail $trail) {
    $trail->parent('projects');
    $trail->push('Create', route('projects.create'));
});
// Home > projects > edit
Breadcrumbs::for('projects.edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('projects');
    $trail->push('Edit', route('projects.update',$userid));
});
// Home > projects > show
Breadcrumbs::for('projects.show', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('projects');
    $trail->push('Show', route('projects.show',$userid));
});
// Home > projects > status
Breadcrumbs::for('projects.status', function (BreadcrumbTrail $trail) {
    $trail->parent('projects');
    $trail->push('Status');
});



// Home > master_database
Breadcrumbs::for('master_database', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('Master Database', route('master_database'));
});

// Home > cct-dashboard
Breadcrumbs::for('cct-dashboard', function (BreadcrumbTrail $trail) {
    $trail->parent('projects');
    $trail->push('CCT Dashboard', route('projects.index'));
});

// Home > project_type
Breadcrumbs::for('project_type', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('ProjectType', route('project_type.index'));
});

// Home > projects > add
Breadcrumbs::for('project_type.create', function (BreadcrumbTrail $trail) {
    $trail->parent('project_type');
    $trail->push('Create', route('project_type.create'));
});
// Home > projects > edit
Breadcrumbs::for('project_type.edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('project_type');
    $trail->push('Edit', route('project_type.update',$userid));
});
// Home > projects > show
Breadcrumbs::for('project_type.show', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('project_type');
    $trail->push('Show', route('project_type.show',$userid));
});
// Home > projects > status
Breadcrumbs::for('project_type.status', function (BreadcrumbTrail $trail) {
    $trail->parent('project_type');
    $trail->push('Status');
});



// Home > registries
Breadcrumbs::for('registries', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('Registries', route('registries.index'));
});

// Home > registries > add
Breadcrumbs::for('registries.create', function (BreadcrumbTrail $trail) {
    $trail->parent('registries');
    $trail->push('Create', route('registries.create'));
});
// Home > registries > edit
Breadcrumbs::for('registries.edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('registries');
    $trail->push('Edit', route('registries.update',$userid));
});
// Home > registries > show
Breadcrumbs::for('registries.show', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('registries');
    $trail->push('Show', route('registries.show',$userid));
});
// Home > registries > status
Breadcrumbs::for('registries.status', function (BreadcrumbTrail $trail) {
    $trail->parent('registries');
    $trail->push('Status');
});


// Home > methodologies
Breadcrumbs::for('methodologies', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('Methodologies', route('methodologies.index'));
});
// Home > methodologies > add
Breadcrumbs::for('methodologies.create', function (BreadcrumbTrail $trail) {
    $trail->parent('methodologies');
    $trail->push('Create', route('methodologies.create'));
});
// Home > methodologies > edit
Breadcrumbs::for('methodologies.edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('methodologies');
    $trail->push('Edit', route('methodologies.update',$userid));
});
// Home > methodologies > show
Breadcrumbs::for('methodologies.show', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('methodologies');
    $trail->push('Show', route('methodologies.show',$userid));
});


// Home > treedata
Breadcrumbs::for('treedata', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('Trees', route('treedata.index'));
});
// Home > treedata > add
Breadcrumbs::for('treedata.create', function (BreadcrumbTrail $trail) {
    $trail->parent('treedata');
    $trail->push('Create', route('treedata.create'));
});
// Home > treedata > edit
Breadcrumbs::for('treedata.edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('treedata');
    $trail->push('Edit', route('treedata.update',$userid));
});
// Home > treedata > show
Breadcrumbs::for('treedata.show', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('treedata');
    $trail->push('Show', route('treedata.show',$userid));
});

// Home > forest
Breadcrumbs::for('forest', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('List', route('forest.index'));
});
// Home > forest > add
Breadcrumbs::for('forest.create', function (BreadcrumbTrail $trail) {
    $trail->parent('forest');
    $trail->push('Create', route('forest.create'));
});
// Home > forest > edit
Breadcrumbs::for('forest.edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('forest');
    $trail->push('Edit', route('forest.update',$userid));
});
// Home > forest > show
Breadcrumbs::for('forest.show', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('forest');
    $trail->push('Show', route('forest.show',$userid));
});


// Home > methodologies
Breadcrumbs::for('categories', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('Categories', route('categories.index'));
});
// Home > methodologies > add
Breadcrumbs::for('categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('categories');
    $trail->push('Create', route('categories.create'));
});
// Home > methodologies > edit
Breadcrumbs::for('categories.edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('categories');
    $trail->push('Edit', route('categories.update',$userid));
});
// Home > methodologies > show
Breadcrumbs::for('categories.show', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('categories');
    $trail->push('Show', route('categories.show',$userid));
});

// Home > methodologies
Breadcrumbs::for('vehicletype', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('Vehicletype', route('vehicletype.index'));
});
// Home > methodologies > add
Breadcrumbs::for('vehicletype.create', function (BreadcrumbTrail $trail) {
    $trail->parent('vehicletype');
    $trail->push('Create', route('vehicletype.create'));
});

// Home > methodologies > edit
Breadcrumbs::for('vehicletype.edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('vehicletype');
    $trail->push('Edit', route('vehicletype.update',$userid));
});
// Home > methodologies > show
Breadcrumbs::for('vehicletype.show', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('vehicletype');
    $trail->push('Show', route('vehicletype.show',$userid));
});
//cancelreason

Breadcrumbs::for('cancelreason', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('cancelreason', route('cancelreason.index'));
});
// Home > methodologies > add
Breadcrumbs::for('cancelreason.create', function (BreadcrumbTrail $trail) {
    $trail->parent('cancelreason');
    $trail->push('Create', route('cancelreason.create'));
});
Breadcrumbs::for('cancelreason.edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('cancelreason');
    $trail->push('Edit', route('cancelreason.update',$userid));
});
// Home > methodologies > show
Breadcrumbs::for('cancelreason.show', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('cancelreason');
    $trail->push('Show', route('cancelreason.show',$userid));
});

//driver
Breadcrumbs::for('driver', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('driver', route('driver.index'));
});
Breadcrumbs::for('driver.withdraw', function (BreadcrumbTrail $trail) {
    $trail->parent('driver');
    $trail->push('Create', route('driver.withdraw'));
});
// Home > methodologies > add
Breadcrumbs::for('driver.create', function (BreadcrumbTrail $trail) {
    $trail->parent('driver');
    $trail->push('Create', route('driver.create'));
});
// Home > methodologies > edit
Breadcrumbs::for('driver.edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('driver');
    $trail->push('Edit', route('driver.update',$userid));
});
// Home > methodologies > show
Breadcrumbs::for('driver.show', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('driver');
    $trail->push('Show', route('driver.show',$userid));
});



// Home > methodologies
Breadcrumbs::for('sub-categories', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('Sub Categories', route('sub-categories.index'));
});
// Home > methodologies > add
Breadcrumbs::for('sub-categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('sub-categories');
    $trail->push('Create', route('sub-categories.create'));
});
// Home > methodologies > edit
Breadcrumbs::for('sub-categories.edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('sub-categories');
    $trail->push('Edit', route('sub-categories.update',$userid));
});
// Home > methodologies > show
Breadcrumbs::for('sub-categories.show', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('sub-categories');
    $trail->push('Show', route('sub-categories.show',$userid));
});

// Home > biocharhub
Breadcrumbs::for('biocharhub', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('BioChar Hub', route('biocharhub.index'));
});
// Home > biocharhub > add
Breadcrumbs::for('biocharhub.create', function (BreadcrumbTrail $trail) {
    $trail->parent('biocharhub');
    $trail->push('Create', route('biocharhub.create'));
});
// Home > biocharhub > edit
Breadcrumbs::for('biocharhub.edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('biocharhub');
    $trail->push('Edit', route('biocharhub.update',$userid));
});
// Home > biocharhub > show
Breadcrumbs::for('biocharhub.show', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('biocharhub');
    $trail->push('Show', route('biocharhub.show',$userid));
});

// Home > pyrolysis_biochars
Breadcrumbs::for('pyrolysis_biochars', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('Pyrolysis Biochars', route('pyrolysis_biochars.index'));
});
// Home > pyrolysis_biochars > add
Breadcrumbs::for('pyrolysis_biochars.create', function (BreadcrumbTrail $trail) {
    $trail->parent('pyrolysis_biochars');
    $trail->push('Create', route('pyrolysis_biochars.create'));
});
// Home > pyrolysis_biochars > edit
Breadcrumbs::for('pyrolysis_biochars.edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('pyrolysis_biochars');
    $trail->push('Edit', route('pyrolysis_biochars.update',$userid));
});
// Home > pyrolysis_biochars > show
Breadcrumbs::for('pyrolysis_biochars.show', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('pyrolysis_biochars');
    $trail->push('Show', route('pyrolysis_biochars.show',$userid));
});

// Home > biochar_usage
Breadcrumbs::for('biochar_usage', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('Biochar Usage', route('biochar_usage.index'));
});
// Home > biochar_usage > add
Breadcrumbs::for('biochar_usage.create', function (BreadcrumbTrail $trail) {
    $trail->parent('biochar_usage');
    $trail->push('Create', route('biochar_usage.create'));
});
// Home > biochar_usage > edit
Breadcrumbs::for('biochar_usage.edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('biochar_usage');
    $trail->push('Edit', route('biochar_usage.update',$userid));
});
// Home > biochar_usage > show
Breadcrumbs::for('biochar_usage.show', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('biochar_usage');
    $trail->push('Show', route('biochar_usage.show',$userid));
});

// Home > tree_alert
Breadcrumbs::for('tree_alert', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('Tree Alert', route('tree_alert.index'));
});
// Home > tree_alert > add
Breadcrumbs::for('tree_alert.create', function (BreadcrumbTrail $trail) {
    $trail->parent('tree_alert');
    $trail->push('Create', route('tree_alert.create'));
});
// Home > tree_alert > edit
Breadcrumbs::for('tree_alert.edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('tree_alert');
    $trail->push('Edit', route('tree_alert.update',$userid));
});
// Home > tree_alert > show
Breadcrumbs::for('tree_alert.show', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('tree_alert');
    $trail->push('Show', route('tree_alert.show',$userid));
});

Breadcrumbs::for('report', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('report', route('report.index'));
});
Breadcrumbs::for('report.booking', function (BreadcrumbTrail $trail) {
    $trail->parent('report');
    $trail->push('Report', route('report.booking'));
});

Breadcrumbs::for('notification', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('notification', route('notification.index'));
});
// Home > methodologies > add
Breadcrumbs::for('notification.create', function (BreadcrumbTrail $trail) {
    $trail->parent('notification');
    $trail->push('Create', route('notification.create'));
});

//user FAQ

Breadcrumbs::for('faq', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('faq', route('faq.index'));
});

Breadcrumbs::for('faq.user_faq', function (BreadcrumbTrail $trail) {
    $trail->parent('faq');
    $trail->push('user_faq', route('faq.user_faq'));
});

Breadcrumbs::for('faq.driver_faq', function (BreadcrumbTrail $trail) {
    $trail->parent('faq');
    $trail->push('driver_faq', route('faq.driver_faq'));
});
Breadcrumbs::for('faq.user_edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('faq');
    $trail->push('user_edit', route('admin.faq.user_edit',$userid));
});
// Breadcrumbs::for('faq.driver_edit', function (BreadcrumbTrail $trail) {
//     $trail->parent('faq');
//     $trail->push('driver_edit', route('admin.faq.driver_edit'));
// });
Breadcrumbs::for('faq.driver_edit', function (BreadcrumbTrail $trail,$userid) {
    $trail->parent('faq');
    $trail->push('Edit', route('admin.faq.driver_edit',$userid));
});

// Breadcrumbs::for('faq.user_faq', function (BreadcrumbTrail $trail,$userid) {
//     $trail->parent('faq');
//     $trail->push('user_destroy', route('admin.faq.user_faq',$userid));
// });

// terms and condition

Breadcrumbs::for('terms', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('terms', route('admin.terms.user_terms'));
});

// Breadcrumbs::for('terms.user_terms', function (BreadcrumbTrail $trail) {
//     $trail->parent('terms');
//     $trail->push('user_terms', route('terms.user_terms'));
// });
Breadcrumbs::for('terms.driver_terms', function (BreadcrumbTrail $trail) {
    $trail->parent('terms');
    $trail->push('driver_terms', route('admin.terms.driver_terms'));
});

/// proivacy

Breadcrumbs::for('privacy', function (BreadcrumbTrail $trail) {
    $trail->parent('forest_twin');
    $trail->push('privacy', route('admin.privacy.user_privacy'));
});
Breadcrumbs::for('privacy.driver_privacy', function (BreadcrumbTrail $trail) {
    $trail->parent('privacy');
    $trail->push('driver_privacy', route('admin.terms.driver_privacy'));
});
Breadcrumbs::for('privacy.user_privacy', function (BreadcrumbTrail $trail) {
    $trail->parent('privacy');
    $trail->push('user_privacy', route('admin.privacy.user_privacy'));
});

// support 

Breadcrumbs::for('support.user_support', function (BreadcrumbTrail $trail) {
    $trail->parent('faq');
    $trail->push('user_faq', route('faq.user_faq'));
});

// inquiry and about us

Breadcrumbs::for('support.inquiry', function (BreadcrumbTrail $trail) {
    $trail->parent('support');
    $trail->push('inquiry', route('support.inquiry'));
});
Breadcrumbs::for('support.about_us', function (BreadcrumbTrail $trail) {
    $trail->parent('support');
    $trail->push('about_us', route('support.about_us'));
});
