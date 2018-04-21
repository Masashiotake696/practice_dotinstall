drop table if exists users;
create table users (
  id int unsigned primary key auto_increment,
  name varchar(20) unique,
  score float default 0.0,
  -- rank enum('gold', 'silver', 'bronze')
  coins set('gold', 'silver', 'bronze')
);
# primary keyの確認
-- desc users;

-- insert into users (id, name, score) values (1, 'taguchi', 5.8);
-- insert into users (id, name, score) values (2, 'fkoji', 8.2);
-- insert into users (id, name, score) values (3, 'dotinstall', 6.1);
-- insert into users (id, name, score) values (4, 'yamada', null);

# まとめて記述
-- insert into users (id, name, score) values
--   (1, 'taguchi', 5.8),
--   (2, 'fkoji', 8.2),
--   (3, 'dotinstall', 6.1),
--   (4, 'yamada', null);
# uniqueの確認
-- insert into users (id, name) values (5, 'tanaka');
-- insert into users (id, name) values (6, 'tanaka');

# auto_incrementの確認
-- insert into users (name, score) values ('taguchi', 5.8);
-- insert into users (name, score) values ('fkoji', 8.2);
-- insert into users (name, score) values ('dotinstall', 6.1);

-- select * from users;


-- alter table users add column email varchar(255);
# after nameでnameカラムの次に新しいカラムを追加する
-- alter table users add column email varchar(255) after name;
-- alter table users drop column score;
# カラム名をuserからuser_nameに変更。さらにvarchar(80)にし、デフォルトを設定する
-- alter table users change name user_name varchar(80) default 'nobody';
# テーブル名をusersからpersonsに変更
-- alter table users rename persons;

-- show tables;
-- drop table if exists persons;


-- insert into users (name, score) values
--   ('taguchi', 5.8),
--   ('fkoji', 8.2),
--   ('dotinstall', 6.1),
--   ('Tanaka', 4.2),
--   ('yamada', null),
--   ('tashiro', 7.9);

-- select * from users;
-- select id, name from users;
# and条件
-- select * from users where score >= 3.0 and score <= 6.0;
# betweenによるand条件
-- select * from users where score between 3.0 and 6.0;
# or条件
-- select * from users where name = 'taguchi' or name = 'fkoji';
# inによるor条件
-- select * from users where name in ('taguchi', 'fkoji');

-- select * from where name = 'taguchi';
# likeを使ったパーンマッチ(nameがtから始まるレコード)
-- select * from users where name like 't%';
# likeを使ったパーンマッチ(nameにaを含むレコード)
-- select * from users where name like '%a%';
# likeを使ったパーンマッチ(nameがaで終わるレコード)
-- select * from users where name like '%a';
# likeを使ったパーンマッチ(nameが大文字のTで始まるレコード)
-- select * from users where name like binary 'T%';
-- # likeを使ったパーンマッチ(nameが6文字のレコード)
-- select * from users where name like binary '______';
# likeを使ったパーンマッチ(nameの2文字目がaのレコード)
-- select * from users where name like binary '_a%';


# scoreの昇順に並び替え
-- select * from users order by score;
# scoreがnullのレコードを除いてscoreの降順に並び替え
-- select * from users where score is not null order by score desc;
# 最初の3件を表示
-- select * from users limit 3;
# 最初の3件を除いた3件を表示
-- select * from users limit 3 offset 3;
# scoreの上位3名を表示
-- select * from users order by score desc limit 3;

# usersテーブルにある全てのレコードのscoreの値を5.9にする
-- update users set score = 5.9;
# usersテーブルにあるidが1のレコードのscoreの値を5.9にする
-- update users set score = 5.9 where id = 1;
# 複数のフィールドを一気に更新
-- update users set name = 'sasaki', score= 2.9 where name = 'tanaka';
# usersテーブルにあるレコードを全件削除
-- delete from users;
# usersテーブルにあるscoreが5.0より小さいレコードを全件削除
-- delete from users where score < 5.0;;
-- select * from users;


# usersテーブルにあるidが偶数のレコードのスコアを1.2倍にする
-- update users set score = score * 1.2 where id % 2 = 0;
-- select round(5.355); -- 5
-- select round(5.355, 1); -- 5.4
-- select floor(5.355); -- 5
-- select ceil(5.355); -- 6
-- select rand();
# ランダムな値をもとに並び替え、一番上のレコードだけを抽出する
-- select * from users order by rand() limit 1;


-- select length('Hello'); -- 5
-- select substr('Hello', 2); -- ello
-- select substr('Hello', 2, 3); -- ell
-- select upper('Hello'); -- HELLO
-- select lower('Hello'); -- hello
-- select concat('Hello', ',', 'world'); -- Hello,world
# 名前の文字数順で並び替え
-- select length(name), name from users order by length(name);
# カラムに別名をつけて上と同様の処理を行う
-- select length(name) as len, name from users order by len;

# enum型
-- insert into users (name, score, rank) values ('taguchi', 5.8, 'silver');
-- insert into users (name, score, rank) values ('fkoji', 8.2, 'gold');
# rankに文字列redを入れようとするとenumの設定に反するため無視されデータが空になる
-- insert into users (name, score, rank) values ('dotinstall', 6.1, 'red');
-- select * from users;
-- select * from users where rank = 'silver';
# 上と同じ処理をenumの連番を用いて記述
-- select * from users where rank = 2;


# set型
-- insert into users (name, score, coins) values ('taguchi', 5.8, 'gold,silver');
# 挿入時にsetで定義した文字列の順番を変えても、create tableで定義した順番に戻る
-- insert into users (name, score, coins) values ('fkoji', 8.2, 'bronze,gold');
# coinsに文字列redを入れようとするとsetの設定に反するため無視されデータが空になる
-- insert into users (name, score, coins) values ('dotinstall', 6.1, 'red');
-- select * from users;
# coinsにgoldとsilverを持つレコードを抽出
-- select * from users where coins = 'gold,silver';
# coinsにgoleを持つレコードを抽出
-- select * from users where coins like '%gold%';
# set型の1番目と2番目が含まれるレコードを抽出(内部的数値を使用)
-- select * from users where coins = 3; -- 1番目は2の0乗で1, 2番目は2の1乗で2なので、1+2=3


-- insert into users (name, score) values ('taguchi', 5.8);
-- insert into users (name, score) values ('fkoji', 8.2);
-- insert into users (name, score) values ('dotinstall', 6.1);
-- insert into users (name, score) values ('Tanaka', 4.2);
-- insert into users (name, score) values ('yamada', null);
-- insert into users (name, score) values ('tashiro', 7.9);
# if文
-- select
--   name,
--   score,
--   if (score > 5.0, 'OK', 'NG') as result -- if(条件, trueの時の値, falseの時の値)
-- from
-- users;
# case文(書き方①)
-- select
--   name,
--   score,
--   -- scoreの整数部分を2で割った余りに応じてそれが偶数か奇数かを表示する
--   case floor(score) % 2
--     when 0 then 'even'
--     when 1 then 'odd'
--     else null
--   end as type
-- from
--   users;
# case文(書き方②)
-- select
--   name,
--   score,
--   case
--     when score > 8.0 then 'Team-A'
--     when score > 6.0 then 'Team-B'
--     else 'Team-C'
--   end as team
-- from
--   users;


# 抽出結果をテーブルにする
-- create table users_with_team as
--   select
--     id,
--     name,
--     score,
--     case
--       when score > 8.0 then 'Team-A'
--       when score > 6.0 then 'Team-B'
--       else 'Team-C'
--     end as team
--   from users;
-- select * from users_with_team;
# テーブルのコピーを作成する
-- create table users_copy as select * from users;
# テーブルの構造だけコピーしてデータはコピーしない
-- create table users_empty like users;


# データの集計処理
-- insert into users (name, score) values ('taguchi', 5.8);
-- insert into users (name, score) values ('fkoji', 8.2);
-- insert into users (name, score) values ('dotinstall', 6.1);
-- insert into users (name, score) values ('Tanaka', 4.2);
-- insert into users (name, score) values ('yamada', null);
-- insert into users (name, score) values ('tashiro', 7.9);
-- drop table if exists users_with_team;
-- create table users_with_team as
-- select
--   id,
--   name,
--   score,
--   case
--     when score > 8.0 then 'Team-A'
--     when score > 6.0 then 'Team-B'
--     else 'Team-C'
--   end as team
-- from users;
# nullを除いたデータ個数を調べる
-- select count(score) from users_with_team; -- count()はnullを除いてカウントする
# 全体のデータ個数を調べる
-- select count(*) from users_with_team;
-- select sum(score) from users_with_team;
-- select min(score) from users_with_team;
-- select max(score) from users_with_team;
-- select avg(score) from users_with_team;
# ユニークな値(チーム名)だけを表示
-- select distinct team from users_with_team;
# ユニークな値の個数(チーム数)だけを表示
-- select count(distinct team) from users_with_team;
# チームごとの合計スコアを表示
-- select sum(score), team from users_with_team group by team;
# チームの合計スコアが10より大きいチームを表示
-- select sum(score), team from users_with_team group by team having sum(score) > 10.0;


#サブクエリ
-- insert into users (name, score) values ('taguchi', 5.8);
-- insert into users (name, score) values ('fkoji', 8.2);
-- insert into users (name, score) values ('dotinstall', 6.1);
-- insert into users (name, score) values ('Tanaka', 4.2);
-- insert into users (name, score) values ('yamada', null);
-- insert into users (name, score) values ('tashiro', 7.9);
-- select
--   sum(t.score),
--   t.team
-- from
--   (select
--     id,
--     name,
--     score,
--     case
--       when score > 8.0 then 'Team-A'
--       when score > 6.0 then 'Team-B'
--       else 'Team-C'
--     end as team
--   from users) as t -- users_with_teamテーブルを使わずにサブクエリで書く
-- group by t.team;


#ビュー
-- insert into users (name, score) values ('taguchi', 5.8);
-- insert into users (name, score) values ('fkoji', 8.2);
-- insert into users (name, score) values ('dotinstall', 6.1);
-- insert into users (name, score) values ('Tanaka', 4.2);
-- insert into users (name, score) values ('yamada', null);
-- insert into users (name, score) values ('tashiro', 7.9);
-- drop view if exists top3;
-- create view top3 as select * from users order by score desc limit 3;
-- select * from top3;


# トランザクション
-- insert into users (name, score) values ('taguchi', 5.8);
-- insert into users (name, score) values ('fkoji', 8.2);
-- insert into users (name, score) values ('dotinstall', 6.1);
-- insert into users (name, score) values ('Tanaka', 4.2);
-- insert into users (name, score) values ('yamada', null);
-- insert into users (name, score) values ('tashiro', 7.9);
-- fkojiからtaguchiに1.2点scoreを渡す
-- start transaction;
-- update users set score = score - 1.2 where name = 'fkoji';
-- update users set score = score + 1.2 where name = 'taguchi';
-- commit;
-- rollback;


# 索引を設定
-- alter table users add index index_score (score); -- scoreカラムにインデックスを追加
-- show index from users; -- usersテーブルのインデックスを表示
-- explain select * from users where score > 5.0; -- usersテーブルのscoreカラムでインデックスが使われているか調べる
-- explain select * from users where name = 'taguchi'; -- nameカラムにはインデックスが貼られていない
-- alter table users drop index index_score; -- scoreカラムのインデックスを削除
