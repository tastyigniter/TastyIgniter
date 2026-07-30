#!/bin/bash

echo "Starting Controller Generation `date`"
CDIR=`pwd`
SRCDIR=lib
GENFOLDER=net/authorize/api/contract/v1
CONTROLLERFOLDER=net/authorize/api/controller
CNTNAMESPACE=${CONTROLLERFOLDER//\//\\}
CLASSMAP=./ControllerClassMap.php
echo "Using CNTNAMESPACE: ${CNTNAMESPACE}"

GENLOG=$CDIR/log/generator.log
SRCLOG=$CDIR/log/Sources
CNTLOG=$CDIR/log/Controllers
if [ -d $CDIR/log ];then
    rm -r $CDIR/log/*.* 1> /dev/null 2>&1
else
    mkdir $CDIR/log
fi
if [ ! -d $SRCDIR ]; then
    echo "Unable to find $SRCDIR"
    exit 1
fi
if [ -f ${CLASSMAP} ];then
    rm ${CLASSMAP}
fi
GENFULL=${SRCDIR}/${GENFOLDER}
CNTFULL=${SRCDIR}/${CONTROLLERFOLDER}
echo "Generated Controller load map for Controllers on `date`" > ${CLASSMAP} | tee > ${GENLOG}
if [ ! -d ${CNTFULL} ]; then
    mkdir ${CNTFULL}
fi

echo "Identifying Request/Responses to process from $SRCDIR" | tee >> ${GENLOG}
touch ${SRCLOG}0.log
touch ${CNTLOG}0.log
ls ${GENFULL}/*.php  | grep -i -e "[A-Za-z]*request\.php" -e "[A-Za-z]*response\.php" > ${SRCLOG}0.log
ls ${CNTFULL}/*Controller.php > ${CNTLOG}0.log 2>/dev/null

echo "Cleaning up paths in Sources and Controllers" | tee >> ${GENLOG}
GENLEN=${#GENFULL} 
CNTLEN=${#CNTFULL} 
GENLEN=$(( $GENLEN + 2 ))
CNTLEN=$(( $CNTLEN + 2 ))
cut -c${GENLEN}- ${SRCLOG}0.log | cut -d. -f1 | sort -u > ${SRCLOG}1.log
cut -c${CNTLEN}- ${CNTLOG}0.log | cut -d. -f1 | sort -u > ${CNTLOG}.log

echo "Getting Unique Requests/Responses" | tee >> ${GENLOG}
grep -i -e "request *$" -e "response *$" ${SRCLOG}1.log > ${SRCLOG}2.log

echo "Identifying Object names" | tee >> ${GENLOG}
perl -pi -w -e "s/Request *$//g;" ${SRCLOG}2.log
perl -pi -w -e "s/Response *$//g;" ${SRCLOG}2.log
sort -u ${SRCLOG}2.log > ${SRCLOG}3.log

echo "Fixing Controllers" | tee >> ${GENLOG}
perl -pi -w -e "s/Controller *$//g;" ${CNTLOG}.log
perl -pi -w -e 's/^ *\n//g;' ${CNTLOG}.log

echo "Creating backup for later comparison" | tee >> ${GENLOG}
cp ${SRCLOG}3.log ${SRCLOG}4.log > /dev/null
cp ${CNTLOG}.log  ${CNTLOG}9.log > /dev/null

echo "Removing ExistingControllers From Request/Response List" | tee >> ${GENLOG}
# echo "From File" | tee >> ${GENLOG}
# while read aLine; do
    # echo Processing removal of existing controller "${aLine}" >> ${GENLOG}
    # perl -pi -w -e "s/^\b${aLine}\b *$//g;" ${SRCLOG}3.log
# done < ${CNTLOG}.log

echo From BlackList | tee >> ${GENLOG}
 blackList="ANetApi Error Ids XXDoNotUseDummy"
for blackLine in $blackList ; do
    echo Processing removal of Blacklisted controllers "$blackLine" | tee >> ${GENLOG}
    perl -pi -w -e "s/^\b${blackLine}\b *$//g;" ${SRCLOG}3.log
done
perl -pi -w -e 's/^ *\n//g;' ${SRCLOG}3.log

echo Creating Final List of Request/Response to generate code | tee >> ${GENLOG}
sort -u ${SRCLOG}3.log > ${SRCLOG}.log

while read aLine; do
    CNTNAME=${CNTFULL}/${aLine}Controller.php
    echo  "'${CNTNAMESPACE}\\${aLine}Controller' => \$libDir . '${CONTROLLERFOLDER}/${aLine}Controller.php'," | tee >> ${CLASSMAP}

    echo "Processing Controller for Request/Respose: ${aLine}, Controller=${CNTNAME}" | tee >> ${GENLOG}
    if [ -f ${CNTNAME} ]; then
        echo "${CNTNAME} exists, Creating New" | tee >> ${GENLOG}
        cp resources/ControllerTemplate.phpt "${CNTNAME}.new"
        perl -pi -w -e "s/APICONTROLLERNAME/${aLine}/g;" "${CNTNAME}.new"
    #else
    fi
    if [ ! -f ${CNTNAME} ]; then
        echo "Generating Code for ${CNTNAME}" | tee >> ${GENLOG}
        cp resources/ControllerTemplate.phpt "${CNTNAME}"
        perl -pi -w -e "s/APICONTROLLERNAME/${aLine}/g;" "${CNTNAME}"
    fi

done < ${SRCLOG}.log
echo "Controller generated ClassMap is in file: ${CLASSMAP}" | tee >> ${GENLOG}

echo "Identify Obsolete Controllers, from request/response list" | tee >> ${GENLOG}
while read aLine; do
    echo "Processing obsolete Controller ${aLine}" | tee >> ${GENLOG}
    perl -pi -w -e "s/${aLine} *$//g;" "${CNTLOG}9.log"
done < ${SRCLOG}.log
sort -u "${CNTLOG}9.log" > /dev/null
rm -r *.bak 2> /dev/null

echo "Finished `date`"
