#!/usr/bin/env bash

set -e # Exit if any errors

# Helpers
# -------

exitWithMessageOnError() {
    if [ ! $? -eq 0 ]; then
        echo "An error occurred during web site deployment."
        echo $1
        exit 1
    fi
}

initialEnv() {
    hash node 2>/dev/null
    exitWithMessageOnError "Missing node.js"

    echo "Node version"
    eval node -v

    hash php 2>/dev/null
    exitWithMessageOnError "Missing PHP"

    echo "PHP information"
    eval php -v
}

# Variables
# ---------
NGINX_CONFIG=/home/site/wwwroot/infra/appservice/default

if [ -f "$NGINX_CONFIG" ]; then
    echo "Copying custom default over to /etc/nginx/sites-available/default"
    cp $NGINX_CONFIG /etc/nginx/sites-available/default
    service nginx reload
else
    exitWithMessageOnError "File dose not exist, skipping copy nginx config file"
fi
