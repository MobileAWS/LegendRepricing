#  check gthe system is ubuntt type 
apt-get -y install php5-gearman
apt-get -y install gearman-tools
apt-get -y install gearman-job-server
apt-get -y install gearman-server
# for fedoire 
yum install gearmand
#  for mac pc 
brew install gearman


ps -aef  | grep  gearman 
$?

