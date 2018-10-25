create database JoestarCompany;

create table JoestarCompany.Usuario(
    cpf char(11) unique not null,
    rg varchar(30) unique not null,
    nome varchar(50) not null,
    sobrenome varchar(50) not null,
    sexo char(1) not null,
    endereco varchar(50) not null,
    telefone varchar(20) not null,
    dataNascimento date not null,
    tipo varchar(10) not null,
    status char(1) not null,
    login varchar(10) not null,
    senha varchar(20) not null,
    caminhoFoto varchar(60)  not null,
    constraint usuario_pk primary key(login)
);

create table JoestarCompany.Viagem(
    id int AUTO_INCREMENT not null,
    destino varchar(30) unique not null,
    dataPartida date not null,
    diarias int not null,
    transporte varchar(50) not null,
    translado char(3) not null,
    hospedagem int not null,
    passeios varchar(200),
    usuario varchar(10),
    constraint viagem_pk primary key(id),
    constraint viagem_fk_usuario foreign key(usuario) references Usuario(login)
);

insert into JoestarCompany.Usuario (cpf ,rg, nome, sobrenome, sexo, endereco, telefone, dataNascimento, tipo, status, login, senha, caminhoFoto)
values (15276231141, 12345678, 'Administrador', 'do Sistema', 'o', 'Rua X', '11123456789', '1996-01-01', 'adm', '1', 'admin', 'admin', 'fotos/foto_admin.jpg')