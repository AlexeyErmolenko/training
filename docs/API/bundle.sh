#!/usr/bin/env bash

SWAGGER=../../node_modules/.bin/swagger-cli

# Build mobile API
${SWAGGER} bundle -t=yaml -o swagger.yaml mobile.yaml
${SWAGGER} validate swagger.yaml

# Replace host with specified address
[[ ! -z $1 ]] && sed -i "s/^host:.*/host: ${1}/" swagger.yaml
