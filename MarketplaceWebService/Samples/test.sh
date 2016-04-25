#!/bin/bash
#VIEWFILE="viewfile.txt";
set -f  
#declare -i choice
#declare -i counter=0
myarray=()
  red_echo() {
    echo -e "\e[1;31m[E] $SELF_NAME: $1\e[0m"
  }
green_echo() {
  echo -e "\e[1;32m[S] $SELF_NAME: $1\e[0m"
}
curl -h >& /dev/null
[ $? = 127 ] && red_echo "curl not installed .. Installing using apt-get ..." &&  { apt-get --force-yes --yes install curl >& /dev/null || { yum install -y curl >& /dev/null || red_echo "failed to install curl tool, try installing curl manually ....exiting " ; exit 1 ;} }  
#xmlstarlet >& /dev/null
#[ $? = 127 ] && red_echo "starlet not installed .. Installing using apt-get ..." &&  { apt-get --force-yes --yes install xmlstarlet >& /dev/null || { yum install -y xmlstarlet >& /dev/null || red_echo "failed to install xmlstarlet tool, try installing xmlstarlet manually ....exiting " ; exit 1 ;} }  
php -v >& /dev/null
[ $? = 127 ] && red_echo "php5 not installed .. Installing using apt-get ..." &&  { apt-get --force-yes --yes install php5 >& /dev/null || { yum install -y php >& /dev/null || red_echo "failed to install php tool, try installing php manually ....exiting " ; exit 1 ;} }  

php test13.php
