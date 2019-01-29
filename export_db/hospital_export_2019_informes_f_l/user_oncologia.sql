

insert into auth_item (name,type) 
select * from (select 'Gestion_informe',1 ) as tmp
where not EXISTS (
SELECT 1 FROM `auth_item` WHERE name='Gestion_informe' and type=1
)LIMIT 1;


INSERT INTO user
(
`username`,
`email`,
`password`,
`status`,
`created_at`)
VALUES
("Oncologia","administrativo@hospital.com","Onco1234",1,"1484228704");


INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) 
select "Gestion_informe",u.id, "1484228704"
from user u
where  u.username='Oncologia' 
limit 1 ;

insert into auth_item (name,type,created_at)
select  * from	(select '/informe/printreducido',2, '1484228704') as tmp
where not exists (select 1 from auth_item where name='/informe/printreducido' and type=2);

insert into auth_item (name,type,created_at)
select  * from	(select '/informe/entregar',2, '1484228704') as tmp
where not exists (select 1 from auth_item where name='/informe/entregar' and type=2);

insert into auth_item (name,type,created_at)
select  * from	(select '/protocolo/terminados',2, '1484228704') as tmp
where not exists (select 1 from auth_item where name='/protocolo/terminados' and type=2);


insert into auth_item_child (parent,child) 
select * from (select 'Gestion_informe','/informe/printreducido') as tmp
where not EXISTS (
SELECT 1 
FROM auth_item_child aic join auth_item ai
WHERE parent='Gestion_informe' 
and child='/informe/printreducido'
and aic.parent=ai.name 
and ai.type=1
)
and exists(
	select * from auth_item where name='/informe/printreducido'
)
LIMIT 1;

insert into auth_item_child (parent,child) 
select * from (select 'Gestion_informe','/informe/entregar') as tmp
where not EXISTS (
SELECT 1 
FROM auth_item_child aic join auth_item ai
WHERE parent='Gestion_informe' 
and child='/informe/entregar'
and aic.parent=ai.name 
and ai.type=1
)
and exists(
	select * from auth_item where name='/informe/entregar'
)
LIMIT 1;

insert into auth_item_child (parent,child) 
select * from (select 'Gestion_informe','/protocolo/terminados') as tmp
where not EXISTS (
SELECT 1 
FROM auth_item_child aic join auth_item ai
WHERE parent='Gestion_informe' 
and child='/protocolo/terminados'
and aic.parent=ai.name 
and ai.type=1
)
and exists(
	select * from auth_item where name='/protocolo/terminados'
)
LIMIT 1;


insert into auth_item_child (parent,child) 
select * from (select 'Gestion_informe','/informe/view') as tmp
where not EXISTS (
SELECT 1 
FROM auth_item_child aic join auth_item ai
WHERE parent='Gestion_informe' 
and child='/informe/view'
and aic.parent=ai.name 
and ai.type=1
)
and exists(
	select * from auth_item where name='/informe/view'
)
LIMIT 1;


insert into auth_item_child (parent,child) 
select * from (select 'Gestion_informe','/protocolo/entregados') as tmp
where not EXISTS (
SELECT 1 
FROM auth_item_child aic join auth_item ai
WHERE parent='Gestion_informe' 
and child='/protocolo/entregados'
and aic.parent=ai.name 
and ai.type=1
)
and exists(
	select * from auth_item where name='/protocolo/entregados'
)
LIMIT 1;



insert into auth_item_child (parent,child) 
select * from (select 'Gestion_informe','/site/index') as tmp
where not EXISTS (
SELECT 1 
FROM auth_item_child aic join auth_item ai
WHERE parent='Gestion_informe' 
and child='/site/index'
and aic.parent=ai.name 
and ai.type=1
)
and exists(
	select * from auth_item where name='/site/index'
)
LIMIT 1;


insert into auth_item_child (parent,child) 
select * from (select 'Gestion_informe','/site/login') as tmp
where not EXISTS (
SELECT 1 
FROM auth_item_child aic join auth_item ai
WHERE parent='Gestion_informe' 
and child='/site/login'
and aic.parent=ai.name 
and ai.type=1
)
and exists(
	select * from auth_item where name='/site/login'
)
LIMIT 1;


insert into auth_item_child (parent,child) 
select * from (select 'Gestion_informe','/site/logout') as tmp
where not EXISTS (
SELECT 1 
FROM auth_item_child aic join auth_item ai
WHERE parent='Gestion_informe' 
and child='/site/logout'
and aic.parent=ai.name 
and ai.type=1
)
and exists(
	select * from auth_item where name='/site/logout'
)
LIMIT 1;

insert into auth_item_child (parent,child) 
select * from (select 'Gestion_informe','/site/error') as tmp
where not EXISTS (
SELECT 1 
FROM auth_item_child aic join auth_item ai
WHERE parent='Gestion_informe' 
and child='/site/error'
and aic.parent=ai.name 
and ai.type=1
)
and exists(
	select * from auth_item where name='/site/error'
)
LIMIT 1;





insert into auth_item_child (parent,child) 
select * from (select 'rolDefault','/paciente-prestadora/create') as tmp
where not EXISTS (
SELECT 1 
FROM auth_item_child aic join auth_item ai
WHERE parent='rolDefault' 
and child='/paciente-prestadora/create'
and aic.parent=ai.name 
and ai.type=1
)
and exists(
	select * from auth_item where name='/paciente-prestadora/create'
)
LIMIT 1;

insert into auth_item_child (parent,child) 
select * from (select 'rolDefault','/paciente/list') as tmp
where not EXISTS (
SELECT 1 
FROM auth_item_child aic join auth_item ai
WHERE parent='rolDefault' 
and child='/paciente/list'
and aic.parent=ai.name 
and ai.type=1
)
and exists(
	select * from auth_item where name='/paciente/list'
)
LIMIT 1;

insert into auth_item_child (parent,child) 
select * from (select 'rolDefault','/paciente/datos' ) as tmp
where not EXISTS (
SELECT 1 
FROM auth_item_child aic join auth_item ai
WHERE parent='rolDefault' 
and child='/paciente/datos'
and aic.parent=ai.name 
and ai.type=1
)
and exists(
	select * from auth_item where name='/paciente/datos'
)
LIMIT 1;

insert into auth_item_child (parent,child) 
select * from (select 'rolDefault','/prestadoras/list' ) as tmp
where not EXISTS (
SELECT 1 
FROM auth_item_child aic join auth_item ai
WHERE parent='rolDefault' 
and child='/prestadoras/list'
and aic.parent=ai.name 
and ai.type=1
)
and exists(
	select * from auth_item where name='/prestadoras/list'
)
LIMIT 1;


insert into auth_item_child (parent,child) 
select * from (select 'rolDefault','/medico/list' ) as tmp
where not EXISTS (
SELECT 1 
FROM auth_item_child aic join auth_item ai
WHERE parent='rolDefault' 
and child='/medico/list'
and aic.parent=ai.name 
and ai.type=1
)
and exists(
	select * from auth_item where name='/medico/list'
)
LIMIT 1;







insert into auth_item_child (parent,child) 
select * from (select 'rolDefault','/nomenclador/index' ) as tmp
where not EXISTS (
SELECT 1 
FROM auth_item_child aic join auth_item ai
WHERE parent='rolDefault' 
and child='/nomenclador/index'
and aic.parent=ai.name 
and ai.type=1
)
and exists(
	select * from auth_item where name='/nomenclador/index'
)
LIMIT 1;

insert into auth_item_child (parent,child) 
select * from (select 'rolDefault','/nomenclador/update' ) as tmp
where not EXISTS (
SELECT 1 
FROM auth_item_child aic join auth_item ai
WHERE parent='rolDefault' 
and child='/nomenclador/update'
and aic.parent=ai.name 
and ai.type=1
)
and exists(
	select * from auth_item where name='/nomenclador/update'
)
LIMIT 1;
insert into auth_item_child (parent,child) 
select * from (select 'rolDefault','/nomenclador/create' ) as tmp
where not EXISTS (
SELECT 1 
FROM auth_item_child aic join auth_item ai
WHERE parent='rolDefault' 
and child='/nomenclador/create'
and aic.parent=ai.name 
and ai.type=1
)
and exists(
	select * from auth_item where name='/nomenclador/create'
)
LIMIT 1;











