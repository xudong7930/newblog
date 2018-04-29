<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'newblog');

// Project repository
set('repository', 'https://github.com/xudong7930/newblog.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 
set('keep_releases', 5);
set('branch', 'master');
set('ssh_multiplexing', true);
set('http_user', 'www-data');
set('writable_mode', 'chmod');

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', ['storage', 'bootstrap']);


// Hosts

host('45.32.77.118')
	->stage('product')
	->port('30011')
	->user('www-data')
	->identityFile('~/.ssh2/id_rsa')
	->addSshOption('UserKnownHostsFile', '/dev/null')
	->addSshOption('StrictHostKeyChecking', 'no')
    ->set('deploy_path', '~/{{application}}');    
    
// Tasks
task('fix:env', function() {
	run("echo product > {{release_path}}/../../shared/.env");
});

task('fix:problem', function () {
    $cmd = <<<EOF
rm -fr {{release_path}}/bootstrap/cache/*
chmod -R 777 {{release_path}}/bootstrap/cache
chmod -R 777 {{release_path}}/../../shared/storage
EOF;
	run($cmd);
	within('{{release_path}}', function () {
        run("php artisan key:generate;"); 
    });
    writeln("fix laravel problem");
});

task('after:success', ['fix:problem']);

before('deploy:vendors', 'fix:env');
after('success', 'after:success');
after('deploy:failed', 'deploy:unlock');