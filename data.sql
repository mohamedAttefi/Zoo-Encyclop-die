use company_db;

create table animals (
    id int primary key auto_increment,
    nom varchar(50),
    type_alimentaire varchar(50),
    image varchar(100),
    id_habitat int UNIQUE

);

create table habitat (
    habitat_id int primary key auto_increment,
    nom_habitat varchar(50),
    description varchar(50),
    foreign KEY (habitat_id) REFERENCES animals (habitat_id)
);


insert into animals (nom, type_alimentaire, image, habitat_id) values
('Lion', 'Carnivore', 'https://i.pinimg.com/736x/ac/04/47/ac0447ce4b41bfe706572e27f1ad4ed7.jpg', 1),
('Zèbre', 'Herbivore', 'https://i.pinimg.com/736x/b8/c2/b5/b8c2b5d09e012ecd7147bdcde436cebe.jpg', 1),
('Singe', 'Omnivore', 'https://i.pinimg.com/736x/47/03/be/4703be8d6d50d751f08c14a2a48a9833.jpg', 2),
('Poisson-Clown', 'Omnivore', 'https://i.pinimg.com/1200x/12/db/85/12db857278c11c704d224fb3f7cb04a5.jpg', 3);


insert into habitat (nom_habitat, description) values
('Savane', 'Herbe, chaleur et lions'),
('Jungle', 'Forêt dense et animaux tropicaux'),
('Océan', 'Habitats marins et poissons'),
('Désert', 'Climat sec, sable et animaux adaptés à la chaleur');


update animals set descrition = 'chaleur et lion et rien pour voir' where habitat_id = 1;

delete from animals where id = 2;