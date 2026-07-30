#!/bin/bash

echo "Start appending : `date`"

# List filenames with request, response and type and remove the file path upto v1 i.e. 38 characters
find lib/net/authorize/api/contract/v1 -print | grep -i -e "request\.php"   | cut -c 35-  > scripts/requestList.txt
find lib/net/authorize/api/contract/v1 -print | grep -i -e "response\.php"  | cut -c 35-  > scripts/responseList.txt
find lib/net/authorize/api/contract/v1 -print | grep -i -e "type\.php"      | cut -c 35-  > scripts/typeList.txt
find lib/net/authorize/api/contract/v1 -print | grep -i -e "type\.php"    > scripts/typeList2.txt

#mkdir -p ../lib/net/authorize/api/contract/v1/backup

#appendJsonSeralizeCode=`cat appendJsonSeralizeCode.txt`
#appendSetCode=`cat appendSetCode.txt`

echo "Taking backup of Types"
perl scripts/backup.pl scripts/typeList.txt
echo "Appending JsonSerialize code to Types"
perl scripts/appendJsonSerializeCode.pl scripts/typeList.txt
echo "Appending Set code to Types"
perl scripts/appendSetCode.pl scripts/typeList.txt


echo "Taking backup of Requests"
perl scripts/backup.pl scripts/requestList.txt
echo "Appending JsonSerialize code to Requests"
perl scripts/appendJsonSerializeCode.pl scripts/requestList.txt
#echo "Appending Set code to Requests"
#perl appendSetCode.pl requestList.txt

echo "Taking backup of Responses"
perl scripts/backup.pl scripts/responseList.txt
#echo "Appending JsonSerialize code to Responses"
#perl appendJsonSeralizeCode.pl responseList.txt
echo "Appending Set code to Responses"
perl scripts/appendSetCode.pl scripts/responseList.txt

echo "Appending implements JsonSerializable to Types"
list="scripts/typeList2.txt"
while read -r filename
do
    filename=$(echo "$filename" | sed -e "s/^\.\///g")
    # echo "Appending implements JsonSerializable to - $filename"
    sed -i.bak '/^class/ s/$/ implements \\JsonSerializable/' "$filename"

done < "$list"

php lib/net/authorize/util/MapperGen.php

git clean -fdq lib/net/authorize/api/contract/v1 -e "*.php"

echo "Completed!"

