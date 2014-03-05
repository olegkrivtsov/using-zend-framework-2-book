-- To create new database, execute the following command sqlite3:
--   sqlite3 < schema.slqite.sql

-- Post
CREATE TABLE IF NOT EXISTS post (     
  id INTEGER PRIMARY KEY AUTOINCREMENT, 
  title TEXT NOT NULL,                
  content TEXT,                     -- Text description
  tags TEXT,                        -- Comma-separated list of tags
  status INTEGER NOT NULL,              -- Status  
  date_created timestamp NOT NULL,  -- Publication date  
  date_modified timestamp NOT NULL, -- Publication date  
  
  KEY title_key (title),
  KEY content_key (content)
);

-- Comment
CREATE TABLE IF NOT EXISTS comment (     
  id INTEGER PRIMARY KEY AUTOINCREMENT, -- Unique ID  
  comment text,                     -- Text description
  username timestamp NOT NULL,      -- User's name who created the post
  status int NOT NULL,              -- Status  
  date_created timestamp NOT NULL   -- Publication date        
  
);

-- Tag
CREATE TABLE IF NOT EXISTS tag (     
  id INTEGER PRIMARY KEY AUTOINCREMENT, -- Unique ID  
  name VARCHAR(128),                -- Tag name
  frequency INTEGER DEFAULT 1       -- Frequency      
);
