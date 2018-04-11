ls
pwd
sudo yum -y update
sudo yum -y install git
git clone https://github.com/dotinstallres/centos6.git
ls
cd centos6/
ls
./run.sh 
pwd
ls
cd ../php_lessons/
ls
php -S 192.168.33.10:8000
ls
exit
ls
cd php_lessons/
s
ls
ls
cd ruby_lessons/
ls
ruby hello.rb 
ruby hello.rb
pwd
cd ../
ls
cd php_lessons/
ls
rm index.php 
ls
php -v
ip a
php -S 192.168.33.10:8000
ls
pwd
cd ../
mkdir mysql_lessons
ls
cd mysql_lessons/
ls
sudo service mysqld status
sudo service mysqld start
ls
exec $SHELL -l
sudo service mysqld start
pwd
cd ../
ls
cd centos6/
ls
./run.sh 
pwd
sudo service mysqld status
ls
pwd
cd ../
ls
cd unix_lessons/
ls
pwd
cp description.txt aaa.txt
ls
rm aaa.txt 
ls
cat description.txt 
less description.txt 
history
!
ls
pwd
ls
less description.txt 
exit
ls
pwd
cd php_lessons/practice_php_db/
ls
mysql -uroot
mysql -u dbuser -p dotinstall_db
ls
pwd
cd unix_lessons/
ls
mkdir -p myapp/config/production/database
ls
cd myapp/config/production/database/
ls
cd ../../../
ls
pwd
ln -s config/production/database/ dbconfig
ls
ls -l
touch dbconfig/commands.sal
ls
ls dbconfig/
ls config/production/database/commands.sal 
ls config/production/database/
rm dbconfig/commands.sal 
ls
ls dbconfig/
ls config/production/database/
unlink dbconfig/
ls
unlink dbconfig
ls
ls -l
cat /etc/passwd
cat /etc/group
group
groups
ls
pwd
type ls
type hi
pwd
vi hi
ls -hi
ls -l
chmod u+x hi
ls -l
ls
hi
./hi 
echo $PATH
printenv
export -p
export PATH=/home/vagrant/unix_lessons/myapp:$PATH
ls -l
echo $PATH
pwd
hi
which hi
pwd
cd ../
ls
cat /var/log/messages 
ls -l
ls -l /var/log/messages 
echo /var/log/messages
ls -l
cat -l
ls -l /var/log/messages 
cat /var/log/messages
su -
sudo cat /var/log/messages 
pwd
su -
ls
pwd
sudo /var/log/messages 
sudo cat /var/log/messages 
pwd
ls
sudo cp /var/log/messages .
ls
ls -l
sudo chown vagrant:vagrant messages 
ls -l
cat messages 
wc messages 
wc -l messages 
head messages 
tail messages 
head -n 3 messages 
head -3
head -3 messages 
tail -n 3 messages 
tail -3 messages 
grep 'etc' messges
grep 'etc' messages 
echo "data"
echo "data" > cmd.txt
ls
cat cmd.txt 
echo "free" >> cmd.txt 
ls
cat cmd.txt 
date
free
bash cmd.txt 
vi cmd.txt 
bash cmd.txt 
ls -l
ls -l /etc
ls
ls /etc
/var
ls /var
ls -l /var
ls -l /var | grep 'php'
ls -l /etc | grep 'php'
ls -l /etc | grep 'php' | wc -l
ls
ls /etc/
ls /etc/c??.*
find /etc
find /etc -name "http"
find /etc -name "http*"
sudo "http*"
find /etc -name "http*"
sudo find /etc -name "http*"
sudo find /etc -name "http*" -type f
sudo find /etc -name "http*" -type f -exec wc -l {} +
echo {a,b,c}
echo a
echo {1..10}
echo {1..3}{a..c}
ls
pwd
mkdir test && cd test
ls
pwd
mkdir app{1..5}
ls
touch app{1..5}/test{1..3}{.txt,.jpg,.gif}
ls
pwd
ls app1
pwd
ls
touch test{1..3}{.txt,.jpg}
ls
rm test1*
ls
rm test*
ls
sudo cat /etc/passwd
pwd
cd ../
ls
sudo find /etc -name "http*" -type f | xargs wc -l
sudo find /etc -name "http*" -type f | wc -l
pwd
cd ../
ls
sudo service mysqld status
mysql -uroot
ls
pwd
cd mysql_lessons/
ls
mysql -uroot
mysql -u dbuser01 -p masamasa
mysql -u dbuser01 -pmasamasa
mysql -uroot
mysql -uroot -p myapp
mysql -uroot < create_myapp.sql 
mysql -uroot -p myapp
mysql -u myapp_user -p myapp
mysql -uroot
mysql -uroot < create_myapp.sql 
mysql -u myapp_user -p myapp
mysqldump -u myapp_user -p myapp > myapp.backup.sql
ls
less myapp.backup.sql 
mysql -u myapp_user -p myapp
mysql -uroot
mysql -u myapp_user -p myapp
ls
pwd
cd ../
ls
cd php_lessons/
ls
cd practice_database/
ls
pwd
cd ../
ls
cd practice_php_db/
ls
php -v
mysql -v
mysql --version
ip
ip a
php -S 192.168.33.10:8000
ls
pwd
cd ../
ls
cd bingo_php/
ls
php -S 192.168.33.10:8000
pwd
cd ../
ls
cd calendar_php/
s
ls
php -S 192.168.33.10:8000
date
ls
exit
vagrant up
ls
date
exit
date
exit
