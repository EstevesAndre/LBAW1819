#!/bin/bash

# Stop execution if a step fails
set -e

DOCKER_USERNAME=ciscofrisco # Replace by your docker hub username
IMAGE_NAME=lbaw1843

docker build -t $DOCKER_USERNAME/$IMAGE_NAME .
docker push $DOCKER_USERNAME/$IMAGE_NAME
