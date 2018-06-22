<?php
namespace Deployer;

require 'recipe/laravel.php';
set_time_limit(0);

set('application', 'newblog');
set('repository', 'git@github.com:xudong7930/newblog.git');
set('git_tty', true); 
set('keep_releases', 5);
set('writable_use_sudo', true);
set('cleanup_use_sudo', true);

// 分享文件即目录，通常也不用改，默认包含了 storage 目录
add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts
// 生产用的主机
host('45.32.77.118')
	->stage('product')
	->user('deployer')
	->port('30011')
	->set('branch', 'master') // 最新的主分支部署到生产机
    ->set('deploy_path', '/usr/local/html/{{application}}')
    ->set('http_user', 'www-data') // 这个与 nginx 里的配置一致  
    ->identityFile('~/.ssh/id_rsa')
    ->forwardAgent(true)
    ->multiplexing(true)
    ->addSshOption('UserKnownHostsFile', '/dev/null')
    ->addSshOption('StrictHostKeyChecking', 'no');

// Tasks
// 任务：重置 opcache 缓存
task('reset_opcache', function() {
	run("pwd");
	// run('{{bin/php}} -r \'opcache_reset();\'');
});

// 任务：重启 php-fpm 服务
task('restart_phpfpm', function () {
    run('sudo /etc/init.d/php-fpm restart');
});

// 任务：supervisor reload
task('reload_supervisor', function () {
    run('sudo supervisorctl reload');
});

// 任务: 发送部署成功提醒
task('send_message', function () {
    run("pwd");
});

task('set_env', function () {
	within('{{release_path}}', function () {
		run("echo product > .env");
	});
});

task('clear_cache', function() {
	within('{{release_path}}', function () {
		run("php artisan view:clear");
		run("php artisan route:clear");
		run("php artisan cache:clear");
		run("php artisan config:clear");
		run("php artisan view:clear");
		run("php artisan clear-compiled");
	});
});

task('make_cache', function() {
	within('{{release_path}}', function () {
		run("php artisan route:cache");
		run("php artisan config:cache");
	});
});

// 执行自定义任务，注意时间点是 current 已经成功链向新部署的目录之后
after('deploy:symlink', 'clear_cache');
after('deploy:symlink', 'set_env');
after('deploy:symlink', 'make_cache');
after('deploy:symlink', 'restart_phpfpm');
after('deploy:symlink', 'reload_supervisor');
after('deploy:symlink', 'reset_opcache');

after('deploy:failed', 'deploy:unlock');
after('success', 'send_message');

// Migrate database before symlink new release.
// 执行数据库迁移，建议删掉，迁移虽好，但毕竟高风险，只推荐用于开发环境
// before('deploy:symlink', 'artisan:migrate');
