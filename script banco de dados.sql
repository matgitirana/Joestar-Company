create database JoestarCompany;

create table JoestarCompany.Usuario(
    cpf char(11) unique not null,
    rg varchar(30) unique not null,
    nome varchar(50) not null,
    sobrenome varchar(50) not null,
    sexo char(1) not null,
    endereco varchar(50) not null,
    telefone varchar(20) not null,
    data_nascimento date not null,
    tipo varchar(10) not null,
    status char(1) not null,
    login varchar(10) not null,
    senha varchar(20) not null,
    caminho_foto varchar(60)  not null,
    constraint usuario_pk primary key(login)
);

create table JoestarCompany.Transporte(
    transporte varchar(50) not null,
    preco double not null,
    constraint transporte_pk primary key(transporte)
);

create table JoestarCompany.Viagem(
    id int AUTO_INCREMENT not null,
    destino varchar(30) unique not null,
    data_partida date not null,
    diarias int not null,
    transporte varchar(50) not null,
    translado char(3) not null,
    hospedagem int not null,
    passeios varchar(200),
    status char(1) not null,
    preco_diaria double not null,
    preco_translado double not null,
    usuario varchar(10),
    caminho_foto varchar(60) not null,
    constraint viagem_pk primary key(id),
    constraint viagem_fk_usuario foreign key(usuario) references Usuario(login),
    constraint viagem_fk_transporte foreign key(transporte) references Transporte(transporte)

);


insert into JoestarCompany.Usuario (cpf ,rg, nome, sobrenome, sexo, endereco, telefone, data_nascimento, tipo, status, login, senha, caminho_foto)
values (15276231141, 12345678, 'Administrador', 'do Sistema', 'o', 'Rua X', '11123456789', '1996-01-01', 'adm', '1', 'admin', 'admin', 'fotos/usuarios/foto_admin.jpg');

insert into JoestarCompany.Transporte(transporte, preco) values ('avião', 1200), ('trem', 500), ('ônibus', 200), ('navio', 800);

insert into JoestarCompany.Viagem(destino, data_partida, diarias, transporte, translado, hospedagem, passeios, status, preco_diaria, preco_translado, caminho_foto)
values ('Paris', CURDATE() + INTERVAL 10 DAY, 15, 'avião', 'Sim', 3, 'Lalalalalalalalala', '1', 300, 200, 'fotos/viagens/viagem_id_1.jpg'), 
('Londres', CURDATE() + INTERVAL 10 DAY, 15, 'avião', 'Sim', 3, 'Lelelelelelelelele', '1', 300, 400, 'fotos/viagens/viagem_id_2.jpg'), 
('São Paulo', CURDATE() + INTERVAL 11 DAY, 14, 'trem', 'Sim', 3, 'Lilililililililili', '1', 300, 100, 'fotos/viagens/viagem_id_3.jpg'), 
('Tóquio', CURDATE() + INTERVAL 60 DAY, 3, 'avião', 'Sim', 3, 'Lululululululululu', '1', 300, 500, 'fotos/viagens/viagem_id_4.jpg'), 
('Rio de Janeiro', CURDATE() + INTERVAL 15 DAY, 15, 'ônibus', 'Não', 3, 'Lololololololololo', '1', 300, 0, 'fotos/viagens/viagem_id_5.jpg'), 
('Boston', CURDATE() + INTERVAL 2 DAY, 15, 'avião', 'Sim', 3, 'Lololololululululu', '1', 300, 600, 'fotos/viagens/viagem_id_6.jpg'),
('Roma', CURDATE() + INTERVAL 30 DAY, 20, 'navio', 'Sim', 3, 'Lilililililelelele', '1', 300, 200, 'fotos/viagens/viagem_id_7.jpg'); 