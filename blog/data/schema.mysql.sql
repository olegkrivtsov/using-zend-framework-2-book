-- To create new database, run MySQL client:
--   mysql -u root -p
-- Then in MySQL client command line, type the following (replace <password> with password string):
--   create schema blog;
--   grant all privileges on blog.* to blog@localhost identified by '<password>';
--   quit
-- Then, in shell command line, type:
--   mysql -uroot -p<password> blog < schema.mysql.sql

set names 'utf8';

-- Post
CREATE TABLE `post` (     
  `id` int(11) PRIMARY KEY AUTO_INCREMENT, -- Unique ID
  `title` text NOT NULL,      -- Title  
  `content` text NOT NULL,    -- Text 
  `status` int(11) NOT NULL,  -- Status  
  `date_created` timestamp NOT NULL -- Creation date    
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- Comment
CREATE TABLE `comment` (     
  `id` int(11) PRIMARY KEY AUTO_INCREMENT, -- Unique ID  
  `post_id` int(11) NOT NULL,     -- Post ID this comment belongs to  
  `content` text NOT NULL,        -- Text
  `author` varchar(128) NOT NULL, -- Author's name who created the comment  
  `date_created` timestamp NOT NULL -- Creation date          
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- Tag
CREATE TABLE `tag` (     
  `id` int(11) PRIMARY KEY AUTO_INCREMENT, -- Unique ID.  
  `name` VARCHAR(128) NOT NULL,            -- Tag name.  
  UNIQUE KEY `name_key` (`name`)          -- Tag names must be unique.      
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- Post-To-Tag
CREATE TABLE `post_to_tag` (     
  `id` int(11) PRIMARY KEY AUTO_INCREMENT, -- Unique ID  
  `post_id` int(11),                      -- Post id
  `tag_id` int(11),                      -- Tag id
   UNIQUE KEY `unique_key` (`post_id`, `tag_id`), -- Tag names must be unique.
   KEY `post_id_key` (`post_id`),
   KEY `tag_id_key` (`tag_id`)      
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

INSERT INTO tag(`name`) VALUES('zf2');
INSERT INTO tag(`name`) VALUES('book');
INSERT INTO tag(`name`) VALUES('magento');

INSERT INTO post(`title`, `content`, `status`, `date_created`) VALUES(
   'Top 10+ Books about Zend Framework 2',
   'Post content', 2, '2014-08-09 18:49');

INSERT INTO post(`title`, `content`, `status`, `date_created`) VALUES(
   'Getting Started with Magento Extension Development – Book Review',
   'Post content 2', 2, '2014-08-09 18:51');

INSERT INTO post_to_tag(`post_id`, `tag_id`) VALUES(1, 1);
INSERT INTO post_to_tag(`post_id`, `tag_id`) VALUES(1, 2);
INSERT INTO post_to_tag(`post_id`, `tag_id`) VALUES(2, 2);
INSERT INTO post_to_tag(`post_id`, `tag_id`) VALUES(2, 3);

INSERT INTO comment(`post_id`, `content`, `author`, `date_created`) VALUES(
    1, 'Excellent post!', 'Oleg Krivtsov', '2014-08-09 19:20');