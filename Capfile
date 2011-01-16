load 'deploy' if respond_to?(:namespace) # cap2 differentiator
Dir['vendor/plugins/*/recipes/*.rb'].each { |plugin| load(plugin) }

# Set up the stages so we deploy to the right place
set :stages, %w(staging production)
# Set the default to staging, so if anyone just types cap deploy, it will only push to dev
set :default_stage, "staging"
# Require the multistage library
require 'capistrano/ext/multistage'

# default_run_options[:pty] = true

# Set the server we're deploying to
server "nyarlathotep.dyndns.org", :app, :web, :primary => true

# Set the application as glyndebourne
set :application, "cultureapp"
set :repository, "https://github.com/markjames/#{application}.git"
set :scm, :git

set :user, "root"

namespace :deploy do
  desc "Add the cache file for the objects"
  task :fixcache do
    sudo "mkdir #{deploy_to}/fuel/packages/cultureapp/cache && chmod 777 #{deploy_to}/fuel/packages/cultureapp/cache";
  end
end