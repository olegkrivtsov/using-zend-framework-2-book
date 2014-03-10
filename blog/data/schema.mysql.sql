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
  `date_created` timestamp NOT NULL, -- Publication date  
  `date_modified` timestamp NOT NULL, -- Publication date  
  
  FULLTEXT KEY `title_key` (`title`),
  FULLTEXT KEY `content_key` (`content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- Comment
CREATE TABLE IF NOT EXISTS `comment` (     
  `id` int(11) PRIMARY KEY AUTO_INCREMENT, -- Unique ID  
  `comment` text,                -- Text description
  `username` timestamp NOT NULL, -- User's name who created the post
  `status` int(11) NOT NULL,  -- Status  
  `date_created` timestamp NOT NULL -- Publication date        
  
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- Tag
CREATE TABLE IF NOT EXISTS `tag` (     
  `id` int(11) PRIMARY KEY AUTO_INCREMENT, -- Unique ID  
  `name` VARCHAR(128),                     -- Tag name
  `frequency` INTEGER DEFAULT 1            -- Frequency
      
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';
