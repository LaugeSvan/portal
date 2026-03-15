-- Admin users
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) UNIQUE NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('sudoadmin', 'admin', 'editor') DEFAULT 'editor',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Page content blocks (for editable static pages)
CREATE TABLE IF NOT EXISTS page_content (
  id INT AUTO_INCREMENT PRIMARY KEY,
  page_slug VARCHAR(100) NOT NULL,
  section_key VARCHAR(100) NOT NULL,
  content_type ENUM('text', 'html', 'image') DEFAULT 'text',
  content LONGTEXT,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY unique_section (page_slug, section_key)
);

-- Events (Det sker)
CREATE TABLE IF NOT EXISTS events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  event_date DATE,
  recurring ENUM('none','daily','weekly','monthly','yearly') DEFAULT 'none',
  location VARCHAR(255),
  external_url VARCHAR(500),
  image_path VARCHAR(500),
  is_published BOOLEAN DEFAULT FALSE,
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- News (Nyheder)
CREATE TABLE IF NOT EXISTS news (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  body LONGTEXT,
  author VARCHAR(255),
  image_path VARCHAR(500),
  is_published BOOLEAN DEFAULT FALSE,
  published_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Associations (Bogøs foreninger)
CREATE TABLE IF NOT EXISTS associations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  contact_email VARCHAR(255),
  contact_phone VARCHAR(50),
  website_url VARCHAR(500),
  logo_path VARCHAR(500),
  is_published BOOLEAN DEFAULT FALSE,
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admin activity log
CREATE TABLE IF NOT EXISTS admin_activity_log (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  action VARCHAR(100) NOT NULL,
  entity_type VARCHAR(100) DEFAULT NULL,
  entity_id INT NULL,
  description TEXT,
  ip_address VARCHAR(45) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  KEY idx_user_created (user_id, created_at),
  CONSTRAINT fk_admin_activity_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);