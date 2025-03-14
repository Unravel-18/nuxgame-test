#TODO: feature 'salo' app that forwards common calls

# Set project name to the name of the project directory
_PNM="$(basename "$(realpath ../)")-api"

# Execute command from the app container by the current user
alias api='docker compose -p $_PNM -f docker-compose.dev.yml exec --user "$(id -u):$(id -g)" app'

# Execute command from specified container
alias from='docker compose -p $_PNM -f docker-compose.dev.yml exec'

# Execute command from specified container by the current user
alias owning='docker compose -p $_PNM -f docker-compose.dev.yml exec --user "$(id -u):$(id -g)"'

# Run artisan commands
alias artisan='docker compose -p $_PNM -f docker-compose.dev.yml exec --user "$(id -u):$(id -g)" app php artisan'

# Testing aliases
alias test='docker compose -p $_PNM -f docker-compose.dev.yml exec app vendor/bin/phpunit'
alias tf='docker compose -p $_PNM -f docker-compose.dev.yml exec app vendor/bin/phpunit --filter'
alias ts='docker compose -p $_PNM -f docker-compose.dev.yml exec app vendor/bin/phpunit --testsuite'
