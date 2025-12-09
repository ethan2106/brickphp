#!/bin/sh
# Wrapper PHPMD : exit 0 si code 2 (warnings seulement), sinon propage le code
phpmd "$@"
EXIT_CODE=$?
if [ $EXIT_CODE -eq 2 ]; then
    exit 0
fi
exit $EXIT_CODE
