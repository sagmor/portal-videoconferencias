set :application, "portalvcs"
set :user, 'cc51ag2'

default_run_options[:pty] = true
set :scm, "git"
set :repository,  "git://github.com/sagmor/portal-videoconferencias.git"
set :branch, "master"
set :deploy_via, :remote_cache
set :deploy_to, '/u/c/cc51ag2/portalvcs'
set :use_sudo, false


# If you aren't deploying to /u/apps/#{application} on the target
# servers (which is the default), you can specify the actual location
# via the :deploy_to variable:
# set :deploy_to, "/var/www/#{application}"

# If you aren't using Subversion to manage your source code, specify
# your SCM below:
# set :scm, :subversion

role :app, "anakena.dcc.uchile.cl"

