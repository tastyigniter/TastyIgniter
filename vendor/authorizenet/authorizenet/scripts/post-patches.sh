# Shell file to do post-patches that
# Revert auto-generation (on masterupdate->generateObjectsFromXsd) changes to
#  - setStartDate() method in PaymentScheduleType.php
#  - CustomerProfileExType gets wrongfully replaced with 
#    CustomerProfileInfoExType in UpdateCustomerProfileRequest.php

#WORKING --- Remember to escape $ with \$ and replace ' with " and \ with \\ in the replacement expression
#Summary --- Replaces the setStartDate() method with the correct method. To be run in Git Bash or unix shell
#File affected - lib/net/authorize/api/contract/v1/PaymentScheduleType.php
#Run in Git Bash or unix shell like (file permission to be set to executable:
### sh post-patches.sh
#Assumption - No child code blocks (curly-brace pairs) within the setStartDate method
#Test file - testfile.txt
#Options used:
# -p is used to do replacements. Unlike -n which only traverses the file line by line, but doesn't replace.
# -0777 treats the entire file as a blob, instead of doing line by line
# -i is used only for the final files, when we are sure to do the replace.
# /s at the end of regex does the same thing, called the "single-line" mode
# /g at the end of regex does the replacements for entire file, not just first match
# /i is NOT used in the regex as we want our comparisons to be case-sensitive, not insensitive       return/gs' lib/net/authorize/api/contract/v1/testfile.txt
		
perl -0777 -i -pe 's/\bfunction setStartDate[^}]*return/function setStartDate(\\DateTime \$startDate)
    {
        \$strDateOnly = \$startDate->format("Y-m-d");
        \$this->startDate = \\DateTime::createFromFormat("!Y-m-d", \$strDateOnly);
        return/gs' lib/net/authorize/api/contract/v1/PaymentScheduleType.php
#git diff -- lib/net/authorize/api/contract/v1/PaymentScheduleType.php
		
#WORKING --- Remember to escape $ with \$ and replace ' with " and \ with \\
#Summary --- Replaces the CustomerProfileInfoExType with CustomerProfileExType
#Files affected - UpdateCustomerProfileRequest.php and UpdateCustomerProfileRequest.yml
#Run in Git Bash or unix shell
#Assumption - CustomerProfileInfoExType present as a whole word or at starting of a word
#perl -0777 -pe 's/\bCustomerProfileInfoExType/CustomerProfileExType/gs' lib/net/authorize/api/contract/v1/testfile.txt

perl -0777 -i -pe 's/\bCustomerProfileInfoExType/CustomerProfileExType/gs' lib/net/authorize/api/contract/v1/UpdateCustomerProfileRequest.php
#git diff -- lib/net/authorize/api/contract/v1/UpdateCustomerProfileRequest.php

perl -0777 -i -pe 's/\bCustomerProfileInfoExType/CustomerProfileExType/gs' lib/net/authorize/api/yml/v1/UpdateCustomerProfileRequest.yml
#git diff -- lib/net/authorize/api/yml/v1/UpdateCustomerProfileRequest.yml

##References
# - http://www.rexegg.com/regex-perl-one-liners.html