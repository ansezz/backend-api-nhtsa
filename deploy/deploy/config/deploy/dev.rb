
#set :user, "#{`whoami`.strip}"

set :user, "root"

set :branch, "master"

set :domain, "nhtsa.laravel-vuejs.com"

server '209.97.189.26', user: fetch(:user), roles: %w{app}

role :server, %w{209.97.189.26}

set :deploy_to, "/var/www/backend-api-nhtsa"

#set :tmp_dir, "/var/www/tmp"

set :linked_files, %w{.env}
