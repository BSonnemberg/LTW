DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Wishlist;
DROP TABLE IF EXISTS ShoppingCart;
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Photo;
DROP TABLE IF EXISTS Condition;
DROP TABLE IF EXISTS Size;
DROP TABLE IF EXISTS Proposals;

CREATE TABLE User (
    user_id VARCHAR(23) PRIMARY KEY,
    email VARCHAR(50) NOT NULL,
    name VARCHAR(25)  NOT NULL,
    username TEXT NOT NULL,
    password VARCHAR(50) NOT NULL, 
    city VARCHAR(50),
    phone VARCHAR(20) NOT NULL,
    bio VARCHAR(100),
    photo VARCHAR(300) DEFAULT '',
    admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE Product (
    id VARCHAR(23) PRIMARY KEY,
    userId VARCHAR(23),
    category VARCHAR(50) NOT NULL,
    name VARCHAR(50),
    description VARCHAR(100),
    price REAL,
    model VARCHAR(50),
    brand VARCHAR(25),
    size VARCHAR(20),
    condition VARCHAR(30),
    isPurchased BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (size) REFERENCES Size(name),
    FOREIGN KEY (condition) REFERENCES Condition(name),
    FOREIGN KEY (category) REFERENCES Category(name),
    FOREIGN KEY (userId) REFERENCES User(user_id) ON DELETE NO ACTION
);

CREATE TABLE Wishlist (
    userId VARCHAR(23),
    product_id VARCHAR(23),
    FOREIGN KEY (userId) REFERENCES User(user_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES Product(id) ON DELETE CASCADE,
    PRIMARY KEY (userId, product_id)
);

CREATE TABLE ShoppingCart (
    user_id VARCHAR(23),
    product_id VARCHAR(23),
    FOREIGN KEY (user_id) REFERENCES User(user_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES Product(id) ON DELETE CASCADE,
    PRIMARY KEY (user_id, product_id)
);

CREATE TABLE Comment (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    userId VARCHAR(23),
    productId VARCHAR(23),
    comment TEXT,
    dateTime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES User(user_id),
    FOREIGN KEY (productId) REFERENCES Product(id) ON DELETE CASCADE
);

CREATE TABLE Size (
    name VARCHAR(20) PRIMARY KEY
);

CREATE TABLE Category (
    name VARCHAR(50) PRIMARY KEY
);

CREATE TABLE Condition (
    name VARCHAR(50) PRIMARY KEY
);


CREATE TABLE Photo (
    photo_id INTEGER PRIMARY KEY AUTOINCREMENT,
    url_photo VARCHAR(300),
    product_id VARCHAR(23),
    UNIQUE (url_photo, product_id),
    FOREIGN KEY (product_id) REFERENCES Product(id) ON DELETE CASCADE
);

CREATE TABLE Proposals (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    productId VARCHAR(23),
    userId VARCHAR(23),
    amount REAL,
    dateTime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (productId) REFERENCES Product(id) ON DELETE CASCADE,
    FOREIGN KEY (userId) REFERENCES User(user_id) ON DELETE CASCADE
);



INSERT INTO User (user_id, email, name, username, password, city, phone, bio, photo, admin) VALUES
('ana.silva@example.com664a81c32be104.32447335', 'ana.silva@example.com', 'Ana Silva', 'anasilva', '$2y$10$dMJS7NOKJqw1sZxdpjvTdeyN.xwXfPeTkAzRW3R146/hZv7mml4Iq', 'Lisboa', '912345678', 'Apaixonada por moda e viagens.', '../uploads/664aacf00568d6.01638496.jpg' ,FALSE),
('jose.martins@example.com664a8295e4f5b8.78673743', 'jose.martins@example.com', 'José Martins', 'jmartins', '$2y$10$TvZymXk9tMwRAuU9Q58oY.es0GjkXdFLiJg6vGcusEeDBTigTHVcq', 'Porto', '923456789', 'Entusiasta de tecnologia e música.','../uploads/664aa8eeb7b288.32658316.jpg' ,FALSE),
('maria.sousa@example.com664a83407e8741.29136245', 'maria.sousa@example.com', 'Maria Sousa', 'mariasousa', '$2y$10$4TvZ1./9wUQfuyYS.r.kqOU0LCnLpCurIXTMmzGmL33WGUhSWEFdy', 'Coimbra', '934567890', 'Amante da natureza e animais.','../uploads/664aa989b64444.42622122.jpeg' ,FALSE),
('joao.pereira@example.com664a83feebe909.03671563', 'joao.pereira@example.com', 'João Pereira', 'joaop', '$2y$10$Zf1.zVhQieJ9EvYwyiD6guXVrfQ0k4QmiTzuEdiQO.uPxZTIbNw6m', 'Braga', '945678901', 'Fotógrafo amador e aventureiro.', '../uploads/664aae1423e742.53977181.jpg' ,FALSE),
('sofia.goncalves@example.com664a84780937f5.57456369', 'sofia.goncalves@example.com', 'Sofia Gonçalves', 'sofiag', '$2y$10$yZhN08.PAvrwjYN8zUhBoe5V.EuKYt917uWMYTge2DJn0nJR7yAdC', 'Faro', '956789012', 'Adora cozinhar e ler livros.','../uploads/664aa524a3d596.51165216.jpg' ,TRUE);

INSERT INTO Category (name) VALUES
('Mobília'),
('Entretenimento'),
('Roupa'),
('Animais'),
('Criança');

INSERT INTO Size (name) VALUES
('M'),
('S'),
('L'),
('XL'),
('NONE'),
('XXL');

INSERT INTO Condition (name) VALUES
('Usado poucas vezes'),
('Usado muitas vezes'),
('Novo com etiqueta'),
('Novo sem etiqueta'),
('Mau estado');

INSERT INTO Product (id, userId, category,name, description, price, model, brand, size, condition, isPurchased) VALUES
('sofia.goncalves@example.com664a84780937f5.57456369Calças664aa56f903699.78597944', 'sofia.goncalves@example.com664a84780937f5.57456369', 'Roupa', 'Calças', 'Usado poucas vezes e confortáveis', 25, NULL, NULL, 'M', 'Usado poucas vezes', FALSE),
('jose.martins@example.com664a8295e4f5b8.78673743Playstation 4 e jogos664aa864bc3205.81854987', 'jose.martins@example.com664a8295e4f5b8.78673743', 'Entretenimento', 'Playstation 4 e jogos', 'Playstation 4 mais 3 jogos a funcionar muito bem', 350, NULL, 'Sony', 'NONE', 'Usado muitas vezes', FALSE),
('maria.sousa@example.com664a83407e8741.29136245Playmobil bonecos664aa9fbd76250.19392139', 'maria.sousa@example.com664a83407e8741.29136245', 'Criança', 'Playmobil bonecos', 'Bonecos playmobil em boas condições', 15, NULL, NULL, 'NONE', 'Usado muitas vezes', FALSE),
('maria.sousa@example.com664a83407e8741.29136245Peluche cão664aabe5b1b465.61150674', 'maria.sousa@example.com664a83407e8741.29136245', 'Criança', 'Peluche cão', 'Peluche comprado à pouco tempo em excelente estado', 10, NULL, NULL, 'NONE', 'Novo sem etiqueta', FALSE),
('joao.pereira@example.com664a83feebe909.03671563Mesa664aadf3ef6d70.09465849', 'joao.pereira@example.com664a83feebe909.03671563', 'Mobília', 'Mesa', 'mesa castanha usada em bom estado', 20, NULL, NULL, 'NONE', 'Usado poucas vezes', FALSE);

INSERT INTO Photo (photo_id, url_photo, product_id) VALUES 
(1, '../uploads/664aa56f9e0c45.94482523.jpeg', 'sofia.goncalves@example.com664a84780937f5.57456369Calças664aa56f903699.78597944'),
(2, '../uploads/664aa56fb48060.39818631.jpeg', 'sofia.goncalves@example.com664a84780937f5.57456369Calças664aa56f903699.78597944'),
(3, '../uploads/664aa864cab691.63329771.jpeg', 'jose.martins@example.com664a8295e4f5b8.78673743Playstation 4 e jogos664aa864bc3205.81854987'),
(4, '../uploads/664aa9fbe10c29.68565863.jpeg', 'maria.sousa@example.com664a83407e8741.29136245Playmobil bonecos664aa9fbd76250.19392139'),
(5, '../uploads/664aabe5bc6ce0.49717542.jpeg', 'maria.sousa@example.com664a83407e8741.29136245Peluche cão664aabe5b1b465.61150674'),
(6, '../uploads/664aadf406cbe3.45583643.jpeg', 'joao.pereira@example.com664a83feebe909.03671563Mesa664aadf3ef6d70.09465849');

INSERT INTO Comment (id, userId, productId, comment, dateTime) VALUES 
(1, 'jose.martins@example.com664a8295e4f5b8.78673743', 'maria.sousa@example.com664a83407e8741.29136245Peluche cão664aabe5b1b465.61150674', 'Tou interessado', '2024-05-20 03:06:28'),
(2, 'sofia.goncalves@example.com664a84780937f5.57456369', 'joao.pereira@example.com664a83feebe909.03671563Mesa664aadf3ef6d70.09465849', 'Não parece em bom estado...', '2024-05-20 03:07:17');
