#!/bin/bash
find src -depth -exec rename 's/(.*)\/([^\/]*)/$1\/\L$2/' {} \;
egrep -ro '`\w+`' ./ | cut -d '`' -f2 | sort | uniq | grep -v ^Binary
