#!/bin/bash
RESULT=~/.dynamic-dns-result.log
# replace DOMAIN, PATH and TOKEN with the logical values
wget --output-document=$RESULT 'http://DOMAIN.com/PATH/ping/TOKEN/'$(hostname)
exit 0