drop database if exists myapp; -- create時にmyappが既にあるとエラーになるので、存在したら削除する
create database myapp;
grant all on myapp.* to myapp_user@localhost IDENTIFIED by 'masamasa'; -- 作業用ユーザーを作成して権限を与える
