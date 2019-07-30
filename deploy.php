<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'laravel-shop');

// Project repository
set('repository', 'git@github.com:yuuhao/laravel-shop.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false); 

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);


// Hosts

host('192.168.10.10')
	->user('deployer')
	->multiplexing(false)
	->identityFile('~/.ssh/deployerkey')
	->set('deploy_path', '/var/www/{{application}}')
	->set('use_relative_symlinks', false);    
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

