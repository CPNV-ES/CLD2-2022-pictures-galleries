server "cld2-phi.mycpnv.ch", user: "cld2_phi", ssh_options: {
  keys: %w(./config/swisscenter_ssh_key),
  forward_agent: false,
  auth_methods: %w(publickey)
}

set :deploy_to, "/home/cld2_phi/cld2-phi.mycpnv.ch"

set :laravel_version, 9.0
set :laravel_upload_dotenv_file_on_deploy, false
set :laravel_set_acl_paths, false

after  'composer:run', 'copy_dotenv'
after  'composer:run', 'laravel:migrate'

# Copy .env in the current release
task :copy_dotenv do
  on roles(:all) do
    execute :cp, "#{shared_path}/.env #{release_path}/.env"
  end
end
