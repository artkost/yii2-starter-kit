
set :application, 'anidesu'
set :repo_url, 'git@bitbucket.org:JiLiZART/anidesu.app.git'

ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }

role :app, %w{anidesu.ru}
role :web, %w{anidesu.ru}
role :db,  %w{anidesu.ru}

set :scm, :git
set :scm_username, "JiLiZART"
set :branch, "master"
set :git_enable_submodules, 1

set :format, :pretty
#set :log_level, :debug
set :use_sudo, false
set :pty, true

set :user, 'anidesu'
set :cli, ->{ fetch(:yiic) }
server 'anidesu.ru', user: 'anidesu', roles: %w{web app}

set :linked_files, %w{app/config/db.php app/config/redis.php}
set :linked_dirs, %w{vendor app/runtime public/assets public/vendor node_modules}

set :keep_releases, 5

set :file_permissions_paths, ["app/runtime", "public/assets"]

set :npm_flags, ' --no-spin' # default --production

set :composer_install_flags, '--no-dev --no-interaction --optimize-autoloader'

namespace :deploy do
    desc 'composer install'
    task :composer_install do
        on roles(:web) do
            within release_path do
                execute 'composer', 'install', '--no-dev', '--no-interaction', '--optimize-autoloader'
            end
        end
    end
    #after :updated, 'deploy:composer_install'
    #after :starting, 'composer:install_executable'

    desc 'bower_install'
    task :bower_install do
        on roles(:web) do
            within release_path do
                execute 'bower', 'cache', 'clean'
                execute 'bower', 'install', '--force'
            end
        end
    end
    after :updated, 'deploy:bower_install'

    desc 'assets_build'
    task :assets_build do
        on roles(:web) do
            within release_path do
                execute 'gulp', 'build'
            end
        end
    end
    after :updated, 'deploy:assets_build'

    desc 'migrations'
    task :migrate do
        on roles(:web) do
            within release_path do
                execute 'php', fetch(:cli, nil), 'migrate', '--interactive=0'
            end
        end
    end
    after :updated, 'deploy:migrate'
end
