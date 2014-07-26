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
CREATE TABLE IF NOT EXISTS `post` (     
  `id` int(11) PRIMARY KEY AUTO_INCREMENT, -- Unique ID
  `title` text NOT NULL,      -- Title  
  `content` text,             -- Text description
  `tags` text,                -- Comma-separated list of tags
  `status` int(11) NOT NULL,  -- Status  
  `date_created` timestamp NOT NULL, -- Creation date  
  `date_modified` timestamp NOT NULL, -- Last modification date  
  
  KEY `title_key` (`title`),
  KEY `content_key` (`content`),
  KEY `status_key` (`status`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- Comment
CREATE TABLE IF NOT EXISTS `comment` (     
  `id` int(11) PRIMARY KEY AUTO_INCREMENT, -- Unique ID  
  `post_id` int(11) NOT NULL, -- Post ID this comment belongs to  
  `comment` text,                -- Text description
  `author` varchar(128) NOT NULL, -- Author's name who created the comment
  `status` int(11) NOT NULL,  -- Status  
  `date_created` timestamp NOT NULL -- Creation date        
  UNIQUE KEY `date_created_key` (`date_created`),          -- Tag names must be unique.
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- Tag
CREATE TABLE IF NOT EXISTS `tag` (     
  `id` int(11) PRIMARY KEY AUTO_INCREMENT, -- Unique ID.  
  `name` VARCHAR(128) NOT NULL,            -- Tag name.  
  UNIQUE KEY `name_key` (`name`),          -- Tag names must be unique.
      
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- Post-To-Tag
CREATE TABLE IF NOT EXISTS `post_to_tag` (     
  `id` int(11) PRIMARY KEY AUTO_INCREMENT, -- Unique ID  
  `post_id` int(11),                      -- Post id
  `tag_id` int(11),                      -- Tag id
   KEY `post_id_key` (`post_id`),
   KEY `tag_key` (`tag_id`)      
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';