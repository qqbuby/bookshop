#!/bin/bash
work_path="."

#find "$work_path" -depth -exec rename 's/(.*)\/([^\/]*)/$1\/\L$2/' {} \;

function tolowercase() {
for word in $@
do
    echo "Process, $word ..."
    word=$(echo $word | tr '.' '\.')
    grep -rl "$word" $work_path | xargs sed -i "s/$word/$(echo $word | tr 'A-Z' 'a-z')/g"
done
}

#words=$(egrep -ro '`\w+`' $work_path | cut -d '`' -f2 | sort | uniq | grep -v ^Binary)

#tolowercase $words

words=$(cat /tmp/words.txt | grep -v '\.')
tolowercase $words
