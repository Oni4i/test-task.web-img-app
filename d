#!/usr/bin/env bash

DOCKER_COMPOSE_EXEC=docker-compose

if [ $# -gt 0 ]; then
    if [ "$1" == "console" ]; then
      shift 1
      $DOCKER_COMPOSE_EXEC exec -T php php bin/console "$@"
    elif [ "$1" == "composer" ]; then
      shift 1
      args="$@"
      $DOCKER_COMPOSE_EXEC exec php bash -c "composer $args"
    elif [ "$1" == "secret" ]; then
      SECRET=$(tr -dc A-Za-z0-9 </dev/urandom | head -c 32)
      echo -e "\nAPP_SECRET="$SECRET
    elif [ "$1" == "init" ]; then
      SECRET=""
      shift 1

      if [ "$1" != "--no-key" ]; then
        SECRET=$(./d secret)
      fi

      mkdir -m 777 public/img

      cp .env.dist .env &&
        echo $SECRET >> .env &&
        $DOCKER_COMPOSE_EXEC up -d &&
        ./d composer install
    fi
fi