drop table if exists posts;
create table posts (
  id int unsigned primary key auto_increment,
  title varchar(255),
  body text,
  created datetime default current_timestamp,
  updated datetime default current_timestamp on update current_timestamp
);
-- drop table if exists comments;
-- create table comments (
--   id int unsigned primary key auto_increment,
--   post_id int unsigned not null,
--   body text
-- );


# 挿入/更新時刻でレコードを更新
insert into posts (title, body) values ('title1', 'body1');
insert into posts (title, body) values ('title2', 'body2');
insert into posts (title, body) values ('title3', 'body3');
-- update posts set title = 'updated' where id = 2; -- 時刻が更新される(このクエリはターミナルで実行しないといけない。また、その後のselect文もターミナルで実行する)


# 日時の計算
-- update posts set created = '2016-12-31 10:00:00' where id = 2;
-- select * from posts where created > '2017-01-01';
-- select created, date_add(created, interval 14 day) from posts;
-- select created, date_add(created, interval 2 week) from posts;
-- select created, date_format(current_date(), '%W %M %Y') from posts;


# トリガー
-- drop table if exists logs;
-- create table logs (
--   id int unsigned primary key auto_increment,
--   msg varchar(255)
-- );
-- drop trigger if exists posts_update_trigger;
-- create trigger posts_insert_trigger after insert on posts for each row insert into logs (msg) values ('post added!');
-- delimiter //
-- create trigger posts_update_trigger after update on posts for each row
--   begin
--     insert into logs (msg) values ('post updated!');
--     insert into logs (msg) values (concat(old.title, ' -> ', new.title));
--   end
-- //
-- delimiter ;
-- insert into posts (title, body) values ('title1', 'body1');
-- insert into posts (title, body) values ('title2', 'body2');
-- insert into posts (title, body) values ('title3', 'body3');
-- update posts set title = 'title 2 updated' where id = 2;
-- show triggers \G

#外部キー制約
-- alter table comments add constraint fk_comments foreign key (post_id) references posts (id); -- 外部キー制約の追加
-- alter table comments drop foreign key fk_comments; -- 外部キー制約の削除

-- insert into posts (title, body) values ('title1', 'body1');
-- insert into posts (title, body) values ('title2', 'body2');
-- insert into posts (title, body) values ('title3', 'body3');
-- insert into comments (post_id, body) values (1, 'first comment for post 1');
-- insert into comments (post_id, body) values (1, 'second comment for post 1');
-- insert into comments (post_id, body) values (3, 'first comment for post 3');
-- insert into comments (post_id, body) values (4, 'first comment for post 4');

# last_insert_id()
-- delete from posts where id = 2;
-- insert into posts (title, body) values ('new title', 'new body');
-- insert into comments (post_id, body) values (last_insert_id(), 'first comment for post 1');


# 内部結合(inner join)
-- select * from posts inner join comments on posts.id = comments.post_id;
-- select * from posts join comments on posts.id = comments.post_id; -- innerは省略可能
-- select posts.id, posts.title, posts.body as posts_body, comments.body as comments_body from posts join comments on posts.id = comments.post_id; -- 特定のフィールドだけ取得


#外部結合(left outer join, right outer join)
-- select * from posts left outer join comments on posts.id = comments.post_id;
-- select * from posts left join comments on posts.id = comments.post_id; -- outerは省略可能
-- select * from posts right outer join comments on posts.id = comments.post_id;
-- select * from posts right join comments on posts.id = comments.post_id; -- outerは省略可能


# 表示は以下を使う
-- select * from posts;
-- select * from logs;
-- select * from comments;
