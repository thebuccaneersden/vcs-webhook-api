<?php
namespace Deployer;

require __DIR__ . '/vendor/autoload.php';
use Symfony\Component\Yaml\Yaml;

date_default_timezone_set('UTC');

require 'recipe/common.php';
require 'recipe/composer.php';

$config = get_configuration_from('config/deployer/deploy.yml');

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
  writeln("<info>Deploying to</info> <fg=cyan>http://standup.api.public.phulse.com</fg=cyan>");
});

task( 'deploy:finish', function() {
  writeln("<info>Finished deployment to</info> <fg=cyan>http://standup.api.public.phulse.com</fg=cyan>");
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

function get_configuration_from( $file )
{
  if( !file_exists( $file ) )
  {
    echo "ERROR: Configuration file does not exist or this script does not have permissions to read it\n";
    exit(2);
  }
  try
  {
    $config = Yaml::parse( file_get_contents( $file ), false, false, true );
  } catch( Exception $e ) {
    echo "ERROR: This file does not contain valid YAML! Please fix it...\n";
    exit(3);
  }

  return $config;
}