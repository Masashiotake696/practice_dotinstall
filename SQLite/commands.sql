-- 外部ファイルから読み込んでみる

/*
  ■if exists
    存在していたらと言う意味
  ■if not exists
    存在していなかったらと言う意味
*/
-- drop table if exists posts;
-- create table if not exists posts (
--   id integer primary key,
--   title text,
--   body text
-- );

-- テーブル名の変更
-- alter table posts rename to articles;

-- テーブルにカラムを追加
-- alter table articles add column email text;

-- テーブルにレコードを追加
-- insert into posts (title, body) values ('title1', 'body1');
-- insert into posts (id, title, body) values (null, 'title2', 'body2');
-- insert into posts (title, body) values ('title3', 'body3');
-- insert into posts (title, body) values ('title4', 'it''s body4');
-- insert into posts (title, body) values ('title4', 'it''s
-- bod
-- y5');

-- レコードの表示
-- select * from posts;


-- drop table if exists users;
-- create table if not exists users (
--   id integer primary key,
--   name text not null,
--   score integer default 10 check (score >= 0),
--   email text unique
-- );
-- insert into users (email) values ('otake@gmail.com');
-- insert into users (email) values ('otake@gmail.com');
-- insert into users (name) values ('otake');
-- .mode line
-- insert into users (name, score) values ('user1', 100);
-- insert into users (name, score) values ('user2', 90);
-- insert into users (name, score) values ('user3', 80);
-- insert into users (name, score) values ('user4', 70);
-- insert into users (name, score) values ('user5', 60);
-- insert into users (name, score) values ('user6', 50);
-- select * from users;


drop table if exists users;
CREATE table users (
  id integer primary key,
  name text,
  score integer,
  team text
);
insert into users (name, score, team) values ('taguchi', 43, 'team-A');
insert into users (name, score, team) values ('fkoji',   80, 'team-B');
insert into users (name, score, team) values ('tashiro', 65, 'team-B');
insert into users (name, score, team) values ('hayashi', 54, 'team-A');
insert into users (name, score, team) values ('sato',    74, 'team-C');
.headers on
.mode column
-- トリガー
-- create table messages (message);
-- usersテーブルがupdateされた時に誰かのscoreが100点を超えたらmessagesテーブルにメッセージを挿入する
-- create trigger new_winner update of score on users when new.score > 100
-- begin
--   insert into messages (message) values (
--     'name: ' || new.name ||
--     ' ' || old.score ||
--     ' -> ' || new.score
--   );
-- end;
-- update users set score = score + 30;
-- select * from messages;

-- インデックス
create index score_index on users(score);
create unique index name_index on users(name);


-- テーブルの一覧を表示
-- .tables

-- テーブルの構造を表示
-- .schema
