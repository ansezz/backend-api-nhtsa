lock '3.11.0'

set :application, 'app'
set :repo_url, 'git@github.com:ansezz/backend-api-nhtsa.git'

ask :branch, `git rev-parse --abbrev-ref master`.chomp
puts 'branch: ' + fetch(:branch)

set :format, :pretty
set :log_level, :debug
set :pty, true

set :ssh_options, {
#    verify_host_key: :never,
    port: 22
}

set :keep_releases, 3

# The version of laravel being deployed
set :laravel_version, 5.6

# Whether to upload the dotenv file on deploy
set :laravel_upload_dotenv_file_on_deploy, true

# Which dotenv file to transfer to the server
set :laravel_dotenv_file, './../config/dev/.env'

# The user that the server is running under (used for ACLs)
set :laravel_server_user, 'root'

# Ensure the dirs in :linked_dirs exist?
set :laravel_ensure_linked_dirs_exist, true

# Link the directores in laravel_linked_dirs?
set :laravel_set_linked_dirs, true

# Linked directories for a standard Laravel 5 application
set :laravel_5_linked_dirs, [
  'storage'
]

namespace :nginx do
 task :restart do
  on roles(:server) do
    print "Restaring nginx..."
    execute "sudo service nginx restart"
  end
 end
 task :reload do
  on roles(:server) do
    print "reload nginx..."
    execute "sudo /usr/sbin/service nginx reload"
  end
 end
 task :vhosts do
   on roles(:server) do
       upload! "../ops/nginx/sites-available/local.nhtsa.com", "/etc/nginx/sites-available/local.nhtsa.com"
   end
 end
end

namespace :php do
  task :restart do
    on roles(:server) do
      print "Restaring php fpm..."
      execute "sudo service php7.1-fpm restart"
    end
  end
end


after "deploy:finished", "nginx:restart"
after "deploy:finished", "php:restart"
