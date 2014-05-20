#!/bin/bash
# replace DOMAIN, PATH and TOKEN with the logical values
wget --output-document=~/.dynamic-dns-result.log 'http://DOMAIN.com/PATH/ping/TOKEN/'$(hostname)
exit 0