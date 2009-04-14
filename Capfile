load 'deploy' if respond_to?(:namespace) # cap2 differentiator
#Dir['vendor/plugins/*/recipes/*.rb'].each { |plugin| load(plugin) }
load 'app/config/deploy'

namespace :deploy do
  task :restart do
    
  end
  
  task :finalize_update do
    ['secret','database'].each do |config|
      run "ln -s #{shared_path}/config/#{config}.php #{release_path}/app/config/#{config}.php"      
    end
    run "chmod -R a+w #{release_path}/app/tmp"
  end
end
