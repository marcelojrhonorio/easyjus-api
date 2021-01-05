<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'API Easyjus');

// Project repository
set('repository', 'https://marcelojrhonorio@gitlab.com/easyjus1/api.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

set('use_relative_symlinks', false);

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);


// Hosts
host('167.71.51.57')
    ->user('easyjus')
    ->identityFile('~/.ssh/deployerkey.pub')
    ->set('deploy_path', '/var/www/html/api.easyjus.com');   
    
// Tasks

task('artisan:optimize', function () {
    // noop
});

task('build', function () {
    run('cd {{release_path}} && build');
});

task('reload:php-fpm', function () {
    run('sudo service php7.4-fpm restart');
    run('sudo service nginx restart');
    run('/usr/bin/recache_apps.sh');
});

task('deploy:done', [
    'artisan:migrate',
    'artisan:cache:clear',
    'artisan:queue:restart',
    'artisan:optimize',
    'reload:php-fpm',
]);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

// before('deploy:symlink', 'artisan:migrate');