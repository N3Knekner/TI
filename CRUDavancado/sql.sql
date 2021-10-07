create database bd_gado;
use bd_gado;

create table Veterinario (
cod int auto_increment primary key, 
nome varchar(45),
CRMV varchar(45),
telefone varchar(15)
);


create table raca (
cod int auto_increment primary key not null,
nome varchar(45)
);

create table Criador (
cod int auto_increment primary key not null,
nome varchar(45),
nome_Propriedade varchar(45)
);

create table Gado (
cod int auto_increment primary key not null,
nome varchar(45),
idade DATE,
peso decimal(5,2),
Raca_cod integer,
Criador_cod integer,
FOREIGN KEY (Raca_cod) REFERENCES raca(cod),
FOREIGN KEY (Criador_cod) REFERENCES Criador(cod)
);

create table Gado_has_Veterinario (
Gado_cod int,
Veterinario_cod int,
ultimaConsulta DATE,
tratamento varchar(45),
primary key(Gado_cod,Veterinario_cod),
foreign key(Gado_cod) references Gado(cod),
foreign key(Veterinario_cod) references Veterinario(cod)
);




