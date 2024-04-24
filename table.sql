create table if not exists user (
  first_name varchar(50) not null,
  last_name varchar(50) not null,
  email varchar(50) primary key,
  password varchar(255) not null,
  image varchar(255),
  is_admin boolean
  );
insert into user (first_name, last_name, email, password, image, is_admin)
values ('SK Faizan', 'Nasir', 'skfaizannasir21@gmail.com', 'admin', NULL, 1);

create table if not exists posts (
  post_id int auto_increment primary key,
  email varchar(255) not null,
  image varchar(255),
  content text not null,
  time datetime not null,
  foreign key (email) references user(email) on delete cascade
);

create table if not exists products (
  product_id int auto_increment primary key,
  name varchar (255) not null,
  description text,
  product_image varchar (255) not null,
  price float not null
)

insert into products (name, description, product_image, price)
values('Samsung Galaxy S24 Ultra', 'Octa core (3.39 GHz, Single Core + 3.1 GHz, Tri core + 2.9 GHz, Dual core + 2.2 GHz, Dual core) Snapdragon 8 Gen 3 12 GB RAM |6.8 inches (17.27 cm) HD+, Dynamic AMOLED 2x 120 Hz Refresh Rate |200 + 12 + 10 + 50 MP Quad Primary Cameras QLED Flash 12 MP Front Camera |5000 mAh Fast Charging USB Type-C Port', 'samsung-galaxy-s24-ultra.webp', 112280.00);

insert into products (name, description, product_image, price)
values(
'Apple iPhone 15 Pro Max',
'Hexa Core (3.78 GHz, Dual Core + 2.11 GHz, Quad core) Apple A17 Pro 8 GB RAM |6.7 inches (17.02 cm) FHD+, OLED 120 Hz Refresh Rate |48 MP + 12 MP + 12 MP Triple Primary Cameras Dual-color LED Flash 12 MP Front Camera |4422 mAh Fast Charging USB Type-C Port',
'apple-iphone-15-pro-max.webp',
148900.00);

insert into products (name, description, product_image, price)
values(
'Google Pixel 8 Pro',
'Nona Core (3 GHz, Single Core + 2.45 GHz, Quad core + 2.15 GHz, Quad core) Google Tensor G3 12 GB RAM |6.7 inches (17.02 cm) FHD+, OLED 120 Hz Refresh Rate |50 MP + 48 MP + 48 MP Triple Primary Cameras Dual LED Flash 10.5 MP Front Camera |5050 mAh Fast Charging USB Type-C Port',
'google-pixel-8-pro-mobile-phone.webp',
106999.00);

create table if not exists cart (
  email varchar(255) not null,
  product_id int,
  quantity int,
  foreign key (email) references user(email) on delete cascade,
  foreign key (product_id) references products(product_id) on delete cascade
);

-- SELECT * FROM cart as c inner join products as p on c.product_id = p.product_id where email = email_id

create table if not exists orders (
  order_id varchar(255) primary key,
  email varchar(255) not null,
  total int not null,
  foreign key (email) references user(email) on delete cascade
);

create table if not exists order_item (
  order_id varchar(255) not null,
  product_id int not null,
  quantity int not null,
  price float not null,
  foreign key (order_id) references orders(order_id) on delete cascade,
  foreign key (product_id) references products(product_id) on delete cascade
);
