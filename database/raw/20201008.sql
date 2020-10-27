-- article_class
alter table article MODIFY COLUMN page int(3) UNSIGNED not null;
alter table article MODIFY COLUMN booklet_class_id int(3) UNSIGNED default null;
alter table article MODIFY COLUMN wb_book_seq int(11) not null  comment 'w_bookstoreの同項目。Wisebookの配信ブックのキーID';
alter table article MODIFY COLUMN letter_body text default null comment '検索用に使用';
-- topics
alter table topics MODIFY COLUMN display_order int(3) UNSIGNED not null;
alter table topics MODIFY COLUMN cutline int(3) UNSIGNED default null comment '論稿が該当のトピックスに属するかの閾値';

-- related_keywords
alter table related_keywords MODIFY COLUMN topics_id int(6) UNSIGNED not null;

-- account_lock
ALTER TABLE account_lock  ADD account_lock_id tinyint(1) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY  (account_lock_id);

-- committee_member

ALTER TABLE `committee_member`
	CHANGE COLUMN `committee_member_seq` `committee_member_seq` TINYINT(3) NOT NULL AUTO_INCREMENT FIRST;