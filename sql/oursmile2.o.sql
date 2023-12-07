create database db_oursmile
default character set utf8mb4
default collate utf8mb4_general_ci;
use db_oursmile;
	
    
create table tb_usuario(
id int not null auto_increment primary key,
ds_foto varchar(255),
nm_email varchar(45) unique key,
nm_nome varchar(15),
nm_sobrenome varchar (15),
ds_senha varchar(8) not null,
nm_local varchar(255), 
nm_local_salva varchar(255),
nm_postagem_salva varchar(255),
id_nivel int
);

create table tb_dentista(
id_dentista int not null auto_increment primary key,
ds_foto blob,
nm_dentista varchar(15),
nm_sobrenome varchar(255),
nm_email varchar(255),
nm_cro varchar(255),
nr_cpf varchar(11),
ds_senha varchar(8)
);

create table tb_blog(
id_post int not null auto_increment primary key,
ds_img blob,
nm_postagem varchar (255),
nm_desc varchar (255),
ds_conteudo text,
nm_autor varchar(255),
dt_data date,
id_categoria int,
data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

create table tb_acesso(
id int auto_increment primary key not null,
dt_acesso datetime,
ds_navegador longtext,
ip varchar(15),
id_usuario int, 
id_post int not null 
);

create table tb_clinica(
id int not null auto_increment primary key,
ds_img varchar(100),
nm_clinica varchar (30),
nr_cro int,
nm_dentista varchar(50),
nr_telefone varchar(100),
nm_endereco varchar(100),
nr_zap varchar(100),
hr_abri time,
hr_fecha time,
nm_email varchar(100),
nm_tratamentos varchar(150),
data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

create table tb_categoria(
id int auto_increment primary key,
nm_categoria varchar(255)
);

create table tb_favorito(
id int auto_increment primary key,
user_id int,
pub_id int,
clinica_id int,
CONSTRAINT fk_favorite_usuario FOREIGN KEY (user_id) REFERENCES tb_usuario (id) ON DELETE CASCADE ON UPDATE NO ACTION,
CONSTRAINT fk_favorite_post FOREIGN KEY (pub_id) REFERENCES tb_blog (id_post) ON DELETE CASCADE ON UPDATE NO ACTION,
CONSTRAINT fk_favorite_clinica FOREIGN KEY (clinica_id) REFERENCES tb_clinica (id) ON DELETE CASCADE ON UPDATE NO ACTION	
);

alter table tb_acesso add
foreign key fk_id_user (id_usuario)
references tb_usuario (id);

alter table tb_dentista add
column id_nivel int;

alter table tb_blog add
foreign key fk_id_categoria (id_categoria)
references tb_categoria (id);

INSERT INTO tb_usuario (nm_nome, nm_sobrenome, nm_email, ds_senha, nm_local, id_nivel)
VALUES ('jonas', 'tomatao', 'chefe@gmail.com', '123', 'teste', '2'),
('fa', 'fa', 'aa@gmail.com', '123', 'jose manoel lorenzo leiro itanhaem','2'),
('fe', 'fe', 'aa2@gmail.com',  '123', 'Av. José Batista Campos, 1431 - Cidade Anchieta, Itanhaém - SP', '1');

INSERT INTO tb_clinica(nm_clinica, nr_cro, nm_dentista, nr_telefone, nm_endereco, nr_zap, hr_abri, hr_fecha, nm_email) VALUES
('Central Odonto','103.281', 'Dra. Caroline Guidolin de Angelis', '1334269395','avenida washington luiz 115 itanhaém', '13991747167', '08:00', '14:00', 'central.odonto@hotmail.com'),
('Odontologia Escobar', '15493', 'Dr. Paulo C. Escobar', '(13) 3422-1848', 'Rua dos Fundadores, 649 Belas artes itanhaém', '(13)99805-2546', '07:30', '17:00', 'drdiegoescobar@gmail.com');