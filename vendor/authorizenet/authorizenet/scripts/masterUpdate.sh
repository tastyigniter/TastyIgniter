#!/bin/bash

echo Started at `date`
echo This script will update the generated code
echo

currdir=`pwd`
cmdlist="prepare.sh generateObjectsFromXsd.sh generateControllersFromTemplate.sh appender.sh post-patches.sh finish.sh"
# cmdlist="generateObjectsFromXsd.sh generateControllersFromTemplate.sh appender.sh finish.sh"
for cmd in $cmdlist ; do 
    echo Executing Script "$cmd"
    if [ ! -f $currdir/scripts/$cmd ];then
        echo "Script $currdir/scripts/$cmd not found"
        exit 1
    fi
    $currdir/scripts/$cmd
    # echo ***FIXME*** $currdir/scripts/$cmd
    ERRORCODE=$?
    if [ $ERRORCODE -ne 0 ];then
        echo "########################################################################"
        echo "Encountered error during execution of $cmd"
        echo "See logs or output above."
        echo "Exiting, Update ***NOT*** complete."
        exit $ERRORCODE
    fi
done

# Removing non-printable UTF-8 character (Non-breakable space)
echo Removing non-printable UTF-8 character
grep --null -lr $'\xC2\xA0' $currdir/lib/net/authorize/api/contract/v1/ | xargs --null sed -i $'s/\xC2\xA0/ /g'

echo Exiting, Update completed successfully.
echo Compile, run tests and commit to git-hub.
echo Completed at `date`

