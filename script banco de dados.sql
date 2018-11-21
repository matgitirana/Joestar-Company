drop database if exists JoestarCompany;

create database JoestarCompany;

create table JoestarCompany.Usuario(
    id int AUTO_INCREMENT not null,
    cpf char(11) unique not null,
    rg varchar(30) unique not null,
    nome varchar(50) not null,
    sobrenome varchar(50) not null,
    sexo char(1) not null,
    endereco varchar(50) not null,
    telefone varchar(20) not null,
    data_nascimento date not null,
    tipo varchar(10) not null,
    disponibilidade char(1) not null,
    login varchar(10) not null,
    senha varchar(20) not null,
    caminho_foto varchar(60),
    constraint usuario_pk primary key(id)
);

create table JoestarCompany.Transporte(
    transporte varchar(50) not null,
    preco double not null,
    disponibilidade char(1) not null,
    constraint transporte_pk primary key(transporte)
);

create table JoestarCompany.Viagem(
    id int AUTO_INCREMENT not null,
    destino varchar(30) not null,
    data_partida date not null,
    transporte varchar(50) not null,
    translado bool not null,
    disponibilidade char(1) not null,
    preco_translado double not null,
    caminho_foto varchar(60),
    constraint viagem_pk primary key(id),
    constraint viagem_fk_transporte foreign key(transporte) references Transporte(transporte)
);

create table JoestarCompany.Passeio(
    id int AUTO_INCREMENT not null,
    id_viagem int not null,
    descricao varchar(500) not null,
    preco double not null,
    constraint passeio_pk primary key(id),
    constraint passeio_fk_viagem foreign key(id_viagem) references Viagem(id)
);

create table JoestarCompany.Hospedagem(
    id int AUTO_INCREMENT not null,
    id_viagem int not null,
    estrelas int not null,
    preco_diaria double not null,
    constraint hospedagem_pk primary key(id),
    constraint hospedagem_fk_viagem foreign key(id_viagem) references Viagem(id)
);

create table JoestarCompany.Comentario(
    id int AUTO_INCREMENT not null,
    id_viagem int not null,
    id_usuario int not null,
    texto varchar(500) not null,
    constraint comentario_pk primary key(id),
    constraint comentario_fk_viagem foreign key(id_viagem) references Viagem(id),
    constraint comentario_fk_usuario foreign key(id_usuario) references Usuario(id)
);

create table JoestarCompany.Compra(
    id int AUTO_INCREMENT not null,
    id_viagem int not null, 
    id_usuario int not null,
    id_hospedagem int not null,
    preco double not null,
    forma_pagamento varchar(10) not null,
    estado varchar(10) not null,
    constraint compra_pk primary key(id),
    constraint compra_fk_viagem foreign key(id_viagem) references Viagem(id),
    constraint compra_fk_usuario foreign key(id_usuario) references Usuario(id),
    constraint compra_fk_hospedagem foreign key(id_hospedagem) references Hospedagem(id)
);

create table JoestarCompany.Compra_Passeio(
    id int AUTO_INCREMENT not null,
    id_compra int not null,
    id_passeio int not null,
    constraint compra_passeio_pk primary key(id),
    constraint compra_passeio_fk_compra foreign key(id_compra) references Compra(id),
    constraint compra_passeio_fk_passeio foreign key(id_passeio) references Passeio(id)
);


insert into JoestarCompany.Usuario (cpf ,rg, nome, sobrenome, sexo, endereco, telefone, data_nascimento, tipo, disponibilidade, login, senha, caminho_foto)
values (15276231141, 12345678, 'Administrador', 'do Sistema', 'o', 'Rua X', '11123456789', '1996-01-01', 'adm', '1', 'admin', 'admin', 'fotos/usuarios/foto_usuario_1.jpg'),
(78828788550, 87654321, 'Fulano', 'de Tal', 'm', 'Rua Y', '819123456789', '2000-11-01', 'cliente', '1', 'fulano', '12345', 'fotos/usuarios/foto_usuario_2.jpg'),
(10119841134, 13572468, 'Maria', 'Genérica', 'f', 'Rua AZ', '987654321', '1990-12-25', 'cliente', '1', 'maria', '12345', 'fotos/usuarios/foto_usuario_3.jpg'),
(28629745878, 12534878515, 'Cicrano', 'de Tal', 'o', 'Rua GH', '3021459845', '1980-01-02', 'cliente', '1', 'cicrano', '12345', 'fotos/usuarios/foto_usuario_4.jpg');

insert into JoestarCompany.Transporte(transporte, preco, disponibilidade) values ('avião', 1200, '1'), ('trem', 500, '1'), ('ônibus', 200, '1'), ('navio', 800, '1');

insert into JoestarCompany.Viagem(destino, data_partida, transporte, translado,  disponibilidade,  preco_translado, caminho_foto)
values ('Paris', CURDATE() + INTERVAL 10 DAY, 'avião', true, '1', 200, 'fotos/viagens/foto_viagem_1.jpg'), 
('Londres', CURDATE() + INTERVAL 10 DAY, 'avião', true, '1', 400, 'fotos/viagens/foto_viagem_2.jpg'), 
('São Paulo', CURDATE() + INTERVAL 11 DAY, 'trem', true, '1', 100, 'fotos/viagens/foto_viagem_3.jpg'), 
('Tóquio', CURDATE() + INTERVAL 60 DAY, 'avião', true, '1', 500, 'fotos/viagens/foto_viagem_4.jpg'), 
('Rio de Janeiro', CURDATE() + INTERVAL 15 DAY, 'ônibus', false, '1', 0, 'fotos/viagens/foto_viagem_5.jpg'), 
('Boston', CURDATE() + INTERVAL 2 DAY, 'avião', true, '1', 600, 'fotos/viagens/foto_viagem_6.jpg'),
('Roma', CURDATE() + INTERVAL 30 DAY, 'navio', true, '1', 200, 'fotos/viagens/foto_viagem_7.jpg');

insert into JoestarCompany.Passeio(id_viagem, descricao, preco) values (1, 'lalalalalalala', 500), (1, 'lelelelelele', 400), (2, 'Teste1', 500), (3, 'Text', 500), (4, 'Passeio', 500), (5, 'Coisa legal', 500), (6, 'Alguma coisa', 500);

insert into JoestarCompany.Hospedagem(id_viagem, estrelas, preco_diaria) values (1, 3, 500), (1, 2, 400), (1, 5, 500), (3, 2, 500), (4, 4, 500), (5, 3, 500), (6, 1, 500);