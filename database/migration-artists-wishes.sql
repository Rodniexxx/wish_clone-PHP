CREATE TABLE IF NOT EXISTS artists (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  slug VARCHAR(255) NOT NULL UNIQUE,
  bio TEXT,
  image VARCHAR(255),
  genre VARCHAR(100),
  social_facebook VARCHAR(255),
  social_instagram VARCHAR(255),
  social_twitter VARCHAR(255),
  social_spotify VARCHAR(255),
  featured TINYINT(1) DEFAULT 0,
  status ENUM('draft', 'published') DEFAULT 'published',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS artist_videos (
  artist_id INT NOT NULL,
  video_id INT NOT NULL,
  PRIMARY KEY (artist_id, video_id),
  FOREIGN KEY (artist_id) REFERENCES artists(id) ON DELETE CASCADE,
  FOREIGN KEY (video_id) REFERENCES videos(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS wishes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255),
  wish_type ENUM('song', 'wish') DEFAULT 'song',
  song_artist VARCHAR(255),
  song_title VARCHAR(255),
  message TEXT NOT NULL,
  status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  approved_at TIMESTAMP NULL
);
