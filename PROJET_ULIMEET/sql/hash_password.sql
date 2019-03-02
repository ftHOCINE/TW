-- Passage à la version "mots de passe hachés" (empreintes), exercice 2
DELETE from s8_users
  where login != 'mallani' and login != 'aporation';

UPDATE s8_users
  set password = '$2y$10$m09t6nVdVgjw/qD7hkowFOd4AWtQI5jukA73Cq0D2mfZM0chMPda2'
  where login='mallani';

UPDATE s8_users
  set password = '$2y$10$//IwI6O9e1YbiSp4W//6v.8s6AOo7w0hqQLhC6PqjSr.dC6.1XmOi'
  where login='aporation';
