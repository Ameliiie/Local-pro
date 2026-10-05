INSERT INTO compte (identifiant, mot_de_passe, type_compte)
VALUES
    ('alice.dupont', '$2y$10$ug9bvFcMUUVHpMgbs52SSeRrsphvHRzDl5vhmOjpqJ9gCbDuOgzYO', 'administrateur'),
    ('thomas.martin', '$2y$10$GOtJJ.JxC1B9m4wR8k7d6u/XvuxRrYiPBagaUE0352hLT7R0wX0v.', 'administrateur'),
    ('marie.durand', '$2y$10$XedZc7Gce13VN/17t9FCCe6ttzDrHIxADnoPZmZgkauGDTUXQvTPq', 'utilisateur'),
    ('paul.bernard', '$2y$10$YA57LhHgDZTQbMDINEwUc./Dj68N.dSQFakzyByuBX/AzlEEt9SU.', 'professionnel');

INSERT INTO administrateur (email, nom, prenom, id_compte)
VALUES
    (
        'alice.dupont@localpro.fr',
        'Dupont',
        'Alice',
        (SELECT id_compte FROM compte WHERE identifiant = 'alice.dupont')
    ),
    (
        'thomas.martin@localpro.fr',
        'Martin',
        'Thomas',
        (SELECT id_compte FROM compte WHERE identifiant = 'thomas.martin')
    );

INSERT INTO professionnel (email_professionnel, nom, prenom, id_compte)
VALUES
    (
        'paul.bernard@localpro.fr',
        'Bernard',
        'Paul',
        (SELECT id_compte FROM compte WHERE identifiant = 'paul.bernard')
    );

INSERT INTO utilisateur (nom, prenom, email_utilisateur, id_compte)
VALUES
    (
        'Durand',
        'Marie',
        'marie.durand@localpro.fr',
        (SELECT id_compte FROM compte WHERE identifiant = 'marie.durand')
    );