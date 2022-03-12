# config valid for current version and patch releases of Capistrano
lock "~> 3.12.0"

set :application, "pictures-galleries"

# If you want to use the git scheme (to access private repos) you have to setup a SSH key pair between the deployment server and github.
#set :repo_url, "git@github.com:CPNV-ES/CLD2-2022-pictures-galleries.git"
set :repo_url, "https://github.com/CPNV-ES/CLD2-2022-pictures-galleries.git"
set :branch, 'main'
