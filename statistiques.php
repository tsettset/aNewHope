Top 5 des membres les mieux notés

select n.membre_id2, concat(m.prenom,' ',m.nom) as coord, avg(n.note) as moy_note, count(n.avis) as nb_avis from membre m inner join note n on m.id_membre=n.membre_id2 group by coord order by moy_note desc limit 5;


Top 5 membre les plus actifs
select concat(m.prenom, ' ',m.nom) as coord, count(c.id_commentaire)as nb_comm from membre m inner join commentaire c on m.id_membre=c.membre_id group by coord order by nb_comm desc  limit 5;


Top 5 des annonces les plus anciennes

Top 5 des catégories contenant les plus d'annonces
select c.id_categorie, c.titre, count(a.id_annonce) as nb_annonce from annonce a inner join categorie c on a.categorie_id=c.id_categorie group by 1 order by 3 desc;

Top 5 des annonces les plus anciennes

select titre, date_enregistrement from annonce group by date_enregistrement desc;
















+-----------------+------------+
| coord           | nb_annonce |
+-----------------+------------+
| Crystal Water   |          5 |
| tony tony       |          4 |
| bastien bastien |          2 |
| androd androd   |          1 |
+-----------------+------------+
4 rows in set (0.00 sec)

mysql> desc categorie;
+--------------+--------------+------+-----+---------+----------------+
| Field        | Type         | Null | Key | Default | Extra          |
+--------------+--------------+------+-----+---------+----------------+
| id_categorie | int(3)       | NO   | PRI | NULL    | auto_increment |
| titre        | varchar(255) | YES  |     | NULL    |                |
| motscles     | text         | YES  |     | NULL    |                |
+--------------+--------------+------+-----+---------+----------------+
3 rows in set (0.00 sec)

mysql> select c.id_categorie, c.titre, count(a.id_annonce) as nb_annonce from annonce a inner join categorie c on a.categorie_id=c.id_categorie group by 1 order by 3 desc;
+--------------+---------------+------------+
| id_categorie | titre         | nb_annonce |
+--------------+---------------+------------+
|            4 | Bijoux        |          5 |
|            2 | jardinage     |          4 |
|            3 | Prêt-à-porter |          3 |




+------------+-----------------+----------+---------+
| membre_id2 | coord           | moy_note | nb_avis |
+------------+-----------------+----------+---------+
|          8 | bastien bastien |   4.3333 |       3 |
|          6 | tony tony       |   4.2500 |       4 |
|          5 | peter pety      |   3.0000 |       3 |
+------------+-----------------+----------+---------+