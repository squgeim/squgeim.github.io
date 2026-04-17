#!/usr/bin/env sh

ALL_FILES_IN_DIR=$(find . -not -path '*/\.*' -not -path './vendor/*' -type f);

# Cross-platform checksum: md5sum on Linux, md5 on macOS
if command -v md5sum >/dev/null 2>&1; then
    NEW_CHECKSUM=$(md5sum $ALL_FILES_IN_DIR | md5sum | cut -d' ' -f1);
else
    NEW_CHECKSUM=$(md5 $ALL_FILES_IN_DIR | md5 -p | tail -n 1);
fi
CURRENT_CHECKSUM=$(head -n 1 sw.js | cut -d ' ' -f4 | cut -d "'" -f2);

if [ "$NEW_CHECKSUM" = "$CURRENT_CHECKSUM" ]; then
    exit 0;
fi

ALL_FILES=$(echo $@ | sed -r "s/ /','/g" | sed -r "s/^/\['/g" | sed -r "s/$/'\]/g");
SECOND_LINE="const\ FILES\ =\ $ALL_FILES;";

cat sw.js |
    sed -r "1s/$CURRENT_CHECKSUM/$NEW_CHECKSUM/" |
    sed -r "2s#.*#$SECOND_LINE#" |
    tee sw.js 1> /dev/null;
