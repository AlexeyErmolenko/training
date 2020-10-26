#!/bin/bash

NC='\033[0m'
RED='\033[31m'
GREEN='\033[32m'
BLUE='\033[34m'
YELLOW='\033[33m'

if [ `which sudo` ]; then
  sudo="sudo"
fi

# Detect, which package manager is installed
if [ `which apt-get` ]; then
  PACKAGE_INSTALL="${sudo} apt-get install -y "
elif [ `which dnf` ]; then
  PACKAGE_INSTALL="${sudo} dnf install -y "
elif [ `which yum` ]; then
  PACKAGE_INSTALL="${sudo} yum install -y "
elif [ `which apk` ]; then
  PACKAGE_INSTALL="${sudo} apk add "
fi

# Install package $2 if command $1 not found
## Params: $command, $package
function ensureInstalled {
  if [ ! `which $1` ]; then
    if [ -z "${PACKAGE_INSTALL}" ]; then
      echo -e "${RED}ERROR: Package manager not found (apt-get, dnf, yum, apk supported)${NC}"
      exit 1
    fi

    package=${2:-$1}
    echo -e "${YELLOW} Installing ${package} ${NC}"
    ${PACKAGE_INSTALL} ${package}
  else
    echo -e "${GREEN}$1 is found, OK${NC}"
  fi
}

# Install required native packages
ensureInstalled node nodejs
ensureInstalled make

#locate NodeJS package manager (NPM) or it's improved alternative Yarn (preferred)
if [[ ! -f ./ci/yarn ]]; then
  echo -e "${RED}ERROR: Yarn not found${NC}"
  exit 1
fi
NPM_INSTALL='ci/yarn --emoji '

# Install local node packages
echo -e "${BLUE} Installing local NodeJS packages ${NC}"
${NPM_INSTALL}

# Install composer packages
if [ `which php` ]; then
  php -v | grep -q "PHP 7\.[123456789]"
  if [ $? -eq 0 ]; then
    echo -e "${BLUE} Installing PHP Composer packages ${NC}"
    TELESCOPE_ENABLED=false php composer.phar install --no-interaction --prefer-dist --no-suggest
  else
    echo -e "${YELLOW} You have PHP version lower, than 7.1. PHP Dependencies should be installed inside container ${NC}"
  fi
fi

VAGRANT_PLUGINS=''
function requireVagrantPlugin {
  plugin=$1
  if [[ -z ${VAGRANT_PLUGINS} ]]; then
    VAGRANT_PLUGINS=`vagrant plugin list`
  fi
  echo ${VAGRANT_PLUGINS} | grep -q ${plugin}
  if [ $? -ne 0 ]; then
    vagrant plugin install ${plugin}
  fi
}
# Install vagrant plugin, that registers a VM's hostname in /etc/hosts file
if [ `which vagrant` ]; then
  requireVagrantPlugin vagrant-hostsupdater
fi
