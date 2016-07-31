<?php
date_default_timezone_set('UTC');
require 'recipe/common.php';
require 'recipe/composer.php';
require 'config/deploy.php';

$config = new Deploy_Config();

server( 'droplet1', $config->deploy_host, 22 )
  ->user( $config->user )
  ->env( 'deploy_path', $config->deploy_path )
  ->identityFile( $config->id_rsa_pub, $config->id_rsa );

set( 'repository', 'git@github.com:thebuccaneersden/vcs-webhook-api.git' );

task( 'deploy:vendors_npm', function () {
  cd( env('release_path') );
  run('npm i');
});

task( 'deploy:vendors_bower', function () {
  cd( env('release_path') );
  run('bower install');
});

task( 'reload:nginx', function () {
  run('sudo service nginx reload');
});

task( 'deploy:start', function() {
  writeln("<info>Deploying to</info> <fg=cyan>http://full.im.phulse.com</fg=cyan>");
});

task( 'deploy:finish', function() {
  writeln("<info>Finished deployment to</info> <fg=cyan>http://full.im.phulse.com</fg=cyan>");
});

task('deploy', [
    'deploy:start',
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    // 'deploy:vendors',
    // 'deploy:vendors_npm',
    // 'deploy:vendors_bower',
    'deploy:symlink',
    'cleanup',
    'reload:nginx'
])->desc('Deploy your project');

after('deploy', 'deploy:finish');
