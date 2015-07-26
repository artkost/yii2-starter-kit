set :stage_config_path, 'app/config/deploy'
set :deploy_config_path, 'app/config/deploy.rb'

# Load DSL and Setup Up Stages
require 'capistrano/setup'

# Includes default deployment tasks
require 'capistrano/deploy'
require 'capistrano/composer'
require 'capistrano/npm'

# Loads custom tasks from `lib/capistrano/tasks' if you have any defined.
Dir.glob('config/tasks/*.cap').each { |r| import r }
