#!/usr/bin/env bash
rootCaKey="../docker/rootfs.local/etc/nginx/ssl/rootCA.key"
rootCaPem="../docker/rootfs.local/etc/nginx/ssl/rootCA.pem"

openssl genrsa -des3 -out ${rootCaKey} 2048
openssl req -x509 -new -nodes -key ${rootCaKey} -sha256 -days 3650 -out ${rootCaPem}
