set :application, "heladoslagrita"
set :domain,      "192.168.1.104"
set :deploy_to,   "/srv/cal.heladoslagrita.com"
set :app_path,    "app"
set :user,        "deployer"
set :use_sudo,    false

set :repository,  "ssh://hg@bitbucket.org/aecg/helados_lagrita"
set :scm,         :mercurial
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`
#set :ssh_options, { :forward_agent => true }
set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

#set :shared_files,      ["app/config/parameters.yml","app/config/parameters_dev.yml","app/config/parameters_staging.yml"]
#set :shared_children,     [app_path + "/logs", web_path + "/uploads", app_path + "/sessions"]
#set :use_composer, true
#set :update_vendors, true

set :writable_dirs,       ["app/cache", "app/logs"]
set :webserver_user,      "www-data"
set :permission_method,   :acl
set :use_set_permissions, true
set :password, "d3pl0y"

set :stages,        %w(production staging)
set :default_stage, "staging"
set :stage_dir,     "app/config"
require 'capistrano/ext/multistage'

set :symfony_env_prod, "staging"

set :deploy_via, :remote_cache
set  :keep_releases,  3

# Be more verbose by uncommenting the following line
 logger.level = Logger::MAX_LEVEL

namespace :symfony do
  namespace :project do
    desc "Clears all non production environment controllers"
    task :clear_controllers, :roles => :app, :except => { :no_release => true } do
      capifony_pretty_print "--> Clear controllers"

      command = "#{try_sudo} sh -c 'cd #{latest_release} && rm -f"
      controllers_to_clear.each do |link|
        command += " #{web_path}/" + link
      end
      #run command + "'"

      capifony_puts_ok
    end
  end
end
