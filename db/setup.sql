
CREATE TABLE IF NOT EXISTS leads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone_number VARCHAR(20),
    ip VARCHAR(45),
    country VARCHAR(100),
    url TEXT,
    note TEXT,
    sub_1 TEXT,
    called BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO leads (first_name, last_name, email, phone_number, ip, country, url, note, sub_1, called, created_at)
VALUES 
('Leanne', 'Graham', 'Sincere@april.biz', '1-770-736-', '36.5.168.227', 'UK', 'arbitrary.com', 'Multi-layered client-server neural-net', 'from landing page', FALSE, CURDATE() - INTERVAL 3 DAY),
('Clementine', 'Bauch', 'Nathan@yesenia.net', '1-463-123-', '140.164.59.185', 'USA', 'arbitrary.com', 'Face to face bifurcated interface', 'from landing page', FALSE, CURDATE() - INTERVAL 2 DAY),
('Patricia', 'Lebsack', 'Julianne.OConner@kory.org', '493-170-96', '254.116.157.134', 'UK', 'arbitrary.com', 'Multi-tiered zero tolerance productivity', 'from landing page', FALSE, CURDATE() - INTERVAL 2 DAY),
('Chelsey', 'Dietrich', 'Lucio_Hettinger@annie.ca', '(254)954-1', '199.203.186.20', 'USA', 'arbitrary.com', 'User-centric fault-tolerant solution', 'from landing page', FALSE, CURDATE() - INTERVAL 1 DAY),
('Mrs.', 'Dennis', 'Karley_Dach@jasper.info', '1-477-935-', '5.111.96.154', 'Israel', 'arbitrary.com', 'Synchronised bottom-line interface', 'from landing page', FALSE, NOW()),
('Kurtis', 'Weissnat', 'Telly.Hoeger@billy.biz', '210.067.61', '30.52.249.23', 'Israel', 'arbitrary.com', 'Configurable multimedia task-force', 'from landing page', FALSE, NOW()),
('Nicholas', 'Runolfsdottir', 'Sherwood@rosamond.me', '586.493.69', '147.255.185.59', 'UK', 'arbitrary.com', 'Implemented secondary concept', 'from landing page', FALSE, NOW()),
('Glenna', 'Reichert', 'Chaim_McDermott@dana.io', '(775)976-6', '35.80.145.17', 'USA', 'arbitrary.com', 'Switchable contextually-based project', 'from landing page', FALSE, NOW()),
('Clementina', 'DuBuque', 'Rey.Padberg@karina.biz', '024-648-38', '146.213.6.197', 'Israel', 'arbitrary.com', 'Centralized empowering task-force', 'from landing page', FALSE, NOW());

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admins (username, password) VALUES ("username", "$2y$10$p3yWwPr30euvy83vRzfERunjko6JyITd/MqchnI3LNBGqIL.UwWdi");