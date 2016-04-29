#!/bin/bash                     
#VIEWFILE="viewfile.txt";
#storepids=();
inputfile="";
set -f 
#trap 'rm -rf $TEMP $MAILFILE $MAILFILEA $MAILFILEA1 $MAILFILEA2 $VIEWFILE' 0 1 2 5 15
echo "Make sure you run it as root"
#Check the internet connection
ping -c1 8.8.8.8 > /dev/null
if [ $? == 0 ]; then 
echo "OK.Internet connection is fine"
else
echo "Problem with your internet connection."
exit 1
fi        

echo "Do you have sshpass installed"
sshpass > /dev/null && { echo "Installed . good ....."  || { echo " not installed bad ... installing it be patient" ; apt-get install --force-yes --yes sshpass >/dev/null || { yum install -y sshpass >/dev/null || echo "failed to install sshpass , try installing manually exiting the script"; exit 1 ;}  } }
# now parsing the files in input.txt
rm -f ~/.ssh/known_hosts
if [[ $# -ne 1 ]]; then 
    echo "One input file must be provided" 
      exit 1
        fi 
inputfile="$1"
#read inputfile
#while read line;do
  IFS=$'\n'       # make newlines the only separator
  for line in $(cat $inputfile)
    do
  echo "Checking"
serverip=$(echo "$line" | cut -d ' ' -f1)
username=$(echo "$line" | cut -d ' ' -s -f2)
password=$(echo "$line" | cut -d ' ' -s -f3)
devname=$(echo "$line" | cut -d ' ' -s -f4)
appname=$(echo "$line" | cut -d ' ' -s -f5)
certname=$(echo "$line" | cut -d ' ' -s -f6)
tokenname=$(echo "$line" | cut -d ' ' -s -f7) 
accountname=$(echo "$line" | cut -d ' ' -s -f8) 
#if [ ! "$serverip" -o ! "$username" -o  ! "$password" -o  ! "$devname" -o ! "$appname" -o ! "$certname" -o ! "$tokenname" -o ! "$accountname" ]; then 
#  echo "Missing entries in input.txt"
#  echo "Check this row $line.Continuing with the next entry  in input.txt file"
#  continue
#fi
 if [ ! "$serverip" -o ! "$username" -o  ! "$password" ]; then
  echo "Missing entries in input.txt"
 echo "Check this row $line.Continuing with the next entry  in input.txt file"
  continue
fi
 

if [ "$username" != "root" ] ;then 
  echo "Try login as root . Continuing with then next server .."
  continue
fi
# first copy my local script to remote destination
echo "  \"$serverip\""
#ssh-keygen -R $serverip
#ssh-keyscan -H $serverip >> ~/.ssh/known_hosts
echo "Connecting the remote vps server and executing the script............."
sshpass  -p "$password" scp -oStrictHostKeyChecking=no -r myphpfiles "$username@$serverip:." 
retval=$?
#echo  $retval
if [ "$retval" != "0" ]; then 
  echo "Error:test.sh cannot copy the file to server $serverip(Reasons :Invalid password or server is down).Trying next server ..."
 continue
fi
#connect sshpass to serverip
unset SESSION_MANAGER 
xterm  -font -*-fixed-medium-r-*-*-22-*-*-*-*-*-iso8859-* -bg black -fg green -maximized -hold -e "expect expect-login.exp $serverip $username $password \"$devname\" \"$appname\" \"$certname\" \"$tokenname\" \"$accountname\" " & 
 done
#if [ "$?" != "0" ]; then 
#  echo "Error:Failed to execute the script test.sh on server $serverip.Trying next server ..."
#  continue
#fi

