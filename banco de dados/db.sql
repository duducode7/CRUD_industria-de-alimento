create DATABASE industria_de_alimentos;

USE industria_de_alimentos;

CREATE TABLE usuarios(
	id_usuario int not null AUTO_INCREMENT PRIMARY KEY,
    nome_usuario varchar(100) not null,
    email_usuario varchar(200) not null,
    senha_usuario varchar(100) not null
);

CREATE TABLE tarefas(
	id_tarefa int NOT null AUTO_INCREMENT PRIMARY KEY,
    descricao varchar(250) NOT null,
    setor varchar(100) NOT null,
    prioridade varchar(50) NOT null,
    status varchar(50) not null,
    fk_usuario int not null,
    foreign key (fk_usuario) references usuarios(id_usuario)
);