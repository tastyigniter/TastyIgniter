#!/bin/bash

logfile=./xsdgen.log
echo `date` > $logfile
# sudo apt-get install php5-curl
# composer install

# echo Getting latest XSD
# XSDURL=https://apitest.authorize.net/xml/v1/schema/AnetApiSchema.xsd
# if [ -f AnetApiSchema.xsd ]; then
    # echo "Renaming existing schema file"
    # mv AnetApiSchema.xsd AnetApiSchema.xsd.old
# fi
# wget $XSDURL 1>> $logfile 2>&1
# ERRORCODE=$?
# if [ $ERRORCODE -ne 0 ];then
    # echo "Unable to download XSD from $XSDURL"
    # exit $ERRORCODE
# fi
if [ ! -f AnetApiSchema.xsd ]; then
    echo "SchemaFile not found"
    exit 1
else
	echo "SchemaFile Found!!!"
fi

#create directories that do not exist
apidir=lib/net/authorize/api/contract/v1
#net.authorize.api.contract.v1.
if [ -d "$apidir" ]; then
	rm -r "$apidir"
fi
mkdir -p "$apidir"
echo Make sure the ns-dest uses destination as: $apidir
echo Generating PHP Classes >> $logfile
vendor/goetas/xsd2php/bin/xsd2php  convert:php \
	--ns-dest='net.authorize.api.contract.v1.;lib/net/authorize/api/contract/v1' \
	--ns-map='http://www.w3.org/2001/XMLSchema;W3/XMLSchema/2001/' \
	--ns-map='AnetApi/xml/v1/schema/AnetApiSchema.xsd;net.authorize.api.contract.v1' \
	./AnetApiSchema.xsd  >> $logfile 2>> $logfile
echo Generation of PHP Classes complete >> $logfile

jmsdir=lib/net/authorize/api/yml/v1
if [ -d "$jmsdir" ]; then
	rm -r "$jmsdir"
fi
mkdir -p "$jmsdir"
echo Generating Serializers for Classes >> $logfile
vendor/goetas/xsd2php/bin/xsd2php  convert:jms-yaml \
	--ns-dest='net.authorize.api.contract.v1.;lib/net/authorize/api/yml/v1' \
	--ns-map='http://www.w3.org/2001/XMLSchema;W3/XMLSchema/2001/' \
	--ns-map='AnetApi/xml/v1/schema/AnetApiSchema.xsd;net.authorize.api.contract.v1' \
	./AnetApiSchema.xsd  >> $logfile
echo Generator output is in file: $logfile

