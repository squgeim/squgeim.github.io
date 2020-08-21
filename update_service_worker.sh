#!/usr/bin/env sh

ALL_FILES_IN_DIR=$(find . -not -path '*/\.*' -not -path './vendor/*' -type f);
NEW_CHECKSUM=$(md5 $ALL_FILES_IN_DIR | md5 -p | tail -n 1);
CURRENT_CHECKSUM=$(head -n 1 sw.js | cut -d ' ' -f4 | cut -d "'" -f2);

if [ $NEW_CHECKSUM = $CURRENT_CHECKSUM ]; then
    exit 0;
fi

ALL_FILES=$(echo $@ | sed -r "s/ /','/g" | sed -r "s/^/\['/g" | sed -r "s/$/'\]/g");
SECOND_LINE="const\ FILES\ =\ $ALL_FILES;";

cat sw.js |
    sed -r "1s/$CURRENT_CHECKSUM/$NEW_CHECKSUM/" |
    sed -r "2s#.*#$SECOND_LINE#" |
    tee sw.js 1> /dev/null;
