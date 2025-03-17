INSERT INTO repas (nom, description, prix) VALUES
('Edamame au sel de mer fumé', 'Fèves de soja vapeur, sel fumé et zeste de yuzu', 10),
('Tataki de thon rouge', 'Thon saisi, sauce ponzu, gingembre mariné', 16),
('Gyoza de porc et crevettes', 'Raviolis grillés, sauce miso épicée', 14),
('Salade wakame et sésame noir', 'Algues marinées, vinaigrette soja-sésame', 15),
('Soupe miso traditionnelle', 'Bouillon miso, tofu, algues wakame, oignons verts', 8),
('Tempura de crevettes', 'Pâte croustillante, sauce tentsuyuu', 14),
('Tartare de saumon façon japonaise', 'Saumon, huile de sésame, shiso, tobiko', 18),
('Yakitori de poulet', 'Brochettes de poulet laqué, sauce tare maison', 16);

INSERT INTO repas_categorie (repas_id, categorie_id)
SELECT r.id, c.id
FROM repas r, categories c
WHERE r.nom IN (
    'Edamame au sel de mer fumé',
    'Tataki de thon rouge',
    'Gyoza de porc et crevettes',
    'Salade wakame et sésame noir',
    'Soupe miso traditionnelle',
    'Tempura de crevettes',
    'Tartare de saumon façon japonaise',
    'Yakitori de poulet'
) AND c.nom = 'Entrées';

INSERT INTO repas (nom, description, prix) VALUES
('Saumon teriyaki', 'Filet de saumon laqué, légumes sautés au shoyu, riz vapeur', 32),
('Bœuf wagyu grillé', 'Wagyu A5, sauce yakiniku, légumes au sésame', 48),
('Poulet karaage', 'Morceaux de poulet frit, mayonnaise au yuzu', 38),
('Ramen miso maison', 'Bouillon miso, porc chashu, œuf mariné, nouilles fraîches', 44),
('Assortiment de brochette yakitori (10 morceaux)', 'Brochettes de poulet, bœuf et crevettes, accompagnées de riz et d''une Sapporo.', 40);

INSERT INTO repas_categorie (repas_id, categorie_id)
SELECT r.id, c.id
FROM repas r, categories c
WHERE r.nom IN (
    'Saumon teriyaki',
    'Bœuf wagyu grillé',
    'Poulet karaage',
    'Ramen miso maison',
    'Assortiment de brochette yakitori (10 morceaux)'
) AND c.nom = 'Plats principaux – grillades';

INSERT INTO repas (nom, description, prix) VALUES
('Ramen aux champignons shiitake', 'Bouillon miso, tofu grillé, légumes croquants, nouilles udon', 28),
('Donburi au tofu caramélisé', 'Riz japonais, tofu mariné au soja, légumes sautés, graines de sésame', 32),
('Sushis végétariens (10 morceaux)', 'Avocat, concombre, champignon, mangue, radis mariné', 30),
('Tempura de légumes croquants', 'Pâte croustillante, légumes racines, sauce tentsuyu', 24),
('Gyoza aux légumes', 'Raviolis grillés, sauce ponzu et gingembre', 32);

INSERT INTO repas_categorie (repas_id, categorie_id)
SELECT r.id, c.id
FROM repas r, categories c
WHERE r.nom IN (
    'Ramen aux champignons shiitake',
    'Donburi au tofu caramélisé',
    'Sushis végétariens (10 morceaux)',
    'Tempura de légumes croquants',
    'Gyoza aux légumes'
) AND c.nom = 'Plats principaux - végétarien';

INSERT INTO repas (nom, description, prix) VALUES
('Mochis glacés assortis', 'Matcha, mangue, sésame noir', 12),
('Dorayaki au haricot rouge', 'Pancakes japonais, pâte de haricot azuki', 10),
('Cheesecake au yuzu', 'Crémeux et acidulé, coulis de fruits rouges', 12),
('Gâteau au matcha et chocolat blanc', 'Fondant, sauce caramel miso', 12),
('Glace artisanale au sésame noir', 'Crémeuse et légèrement sucrée', 10),
('Taiyaki fourré à la crème pâtissière', 'Gaufre japonaise en forme de poisson', 10);

INSERT INTO repas_categorie (repas_id, categorie_id)
SELECT r.id, c.id
FROM repas r, categories c
WHERE r.nom IN (
    'Mochis glacés assortis',
    'Dorayaki au haricot rouge',
    'Cheesecake au yuzu',
    'Gâteau au matcha et chocolat blanc',
    'Glace artisanale au sésame noir',
    'Taiyaki fourré à la crème pâtissière'
) AND c.nom = 'Desserts';