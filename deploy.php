<?php

namespace Deployer;

require 'recipe/symfony4.php';

// Project name
set('application', 'Job-Match-Portfolio');

// Project repository
set('repository', 'git@github.com:Vincent-Labarthe/symfony-job-match.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

host('209.182.238.36')
->multiplexing(false)
    ->user('deployer')
    ->port(22)
    ->identityFile('~/.ssh/id_rsa')
    ->set('deploy_path', '~/webapps/Job-Maych-Portfolio');
    

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');
