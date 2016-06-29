#!/bin/bash

cd /workspace/
# Backend
composer update
# Frontend
npm install
bower --allow-root install
gulp
#Copie all assets at the end
php bin/console assets:install
